<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\EventTicket;
use App\Models\HotelRoom;
use App\Services\BookingPricingService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function __construct(
        protected BookingPricingService $pricingService
    ) {}

    /**
     * Endpoint API kalkulasi real-time breakdown harga dan pajak PBJT.
     */
    public function calculate(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'booking_type' => 'required|in:event,hotel',
            'item_id' => 'required|integer',
            'quantity' => 'nullable|integer|min:1',
            'rooms_count' => 'nullable|integer|min:1',
            'check_in_date' => 'nullable|date',
            'check_out_date' => 'nullable|date|after:check_in_date',
        ]);

        try {
            if ($validated['booking_type'] === 'event') {
                $ticket = EventTicket::with('event')->findOrFail($validated['item_id']);
                $qty = (int) ($validated['quantity'] ?? 1);
                $breakdown = $this->pricingService->calculateEvent($ticket, $qty);
            } else {
                $room = HotelRoom::with('place')->findOrFail($validated['item_id']);
                $roomsCount = (int) ($validated['rooms_count'] ?? 1);
                $checkIn = $validated['check_in_date'] ?? Carbon::now()->toDateString();
                $checkOut = $validated['check_out_date'] ?? Carbon::now()->addDay()->toDateString();
                $breakdown = $this->pricingService->calculateHotel($room, $roomsCount, $checkIn, $checkOut);
            }

            // Tambahkan format Rupiah untuk UI
            $breakdown['formatted'] = [
                'base_price' => 'Rp ' . number_format($breakdown['base_price'], 0, ',', '.'),
                'subtotal_amount' => 'Rp ' . number_format($breakdown['subtotal_amount'], 0, ',', '.'),
                'tax_amount' => 'Rp ' . number_format($breakdown['tax_amount'], 0, ',', '.'),
                'platform_fee' => 'Rp ' . number_format($breakdown['platform_fee'], 0, ',', '.'),
                'total_amount' => 'Rp ' . number_format($breakdown['total_amount'], 0, ',', '.'),
            ];

            return response()->json([
                'success' => true,
                'data' => $breakdown,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Simpan transaksi pemesanan (checkout).
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'booking_type' => 'required|in:event,hotel',
            'item_id' => 'required|integer',
            'customer_name' => 'required|string|max:100',
            'customer_email' => 'required|email|max:150',
            'customer_phone' => 'required|string|max:30',
            'quantity' => 'nullable|integer|min:1',
            'rooms_count' => 'nullable|integer|min:1',
            'check_in_date' => 'nullable|date',
            'check_out_date' => 'nullable|date|after:check_in_date',
            'notes' => 'nullable|string|max:500',
        ]);

        if ($validated['booking_type'] === 'event') {
            $ticket = EventTicket::with('event')->findOrFail($validated['item_id']);
            $qty = (int) ($validated['quantity'] ?? 1);

            // Validasi kuota jika ada
            if ($ticket->quota !== null && $ticket->available_quota !== null && $ticket->available_quota < $qty) {
                return back()->withErrors(['quantity' => 'Sisa kuota tiket tidak mencukupi.'])->withInput();
            }

            $breakdown = $this->pricingService->calculateEvent($ticket, $qty);
            $prefix = 'VSB-EVT';
            $checkIn = null;
            $checkOut = null;
            $effectiveQty = $qty;

            // Kurangi kuota jika ada
            if ($ticket->available_quota !== null) {
                $ticket->decrement('available_quota', $qty);
            }
        } else {
            $room = HotelRoom::with('place')->findOrFail($validated['item_id']);
            $roomsCount = (int) ($validated['rooms_count'] ?? 1);
            $checkIn = $validated['check_in_date'] ?? Carbon::now()->toDateString();
            $checkOut = $validated['check_out_date'] ?? Carbon::now()->addDay()->toDateString();

            $breakdown = $this->pricingService->calculateHotel($room, $roomsCount, $checkIn, $checkOut);
            $prefix = 'VSB-HTL';
            $effectiveQty = $breakdown['quantity'];
        }

        $bookingCode = sprintf('%s-%s-%s', $prefix, date('Ymd'), strtoupper(Str::random(5)));

        $booking = Booking::create([
            'booking_code' => $bookingCode,
            'user_id' => auth()->id(),
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'booking_type' => $breakdown['booking_type'],
            'bookable_type' => $breakdown['bookable_type'],
            'bookable_id' => $breakdown['bookable_id'],
            'source_title' => $breakdown['source_title'],
            'check_in_date' => $checkIn,
            'check_out_date' => $checkOut,
            'quantity' => $effectiveQty,
            'base_price' => $breakdown['base_price'],
            'subtotal_amount' => $breakdown['subtotal_amount'],
            'tax_rate_percent' => $breakdown['tax_rate_percent'],
            'tax_amount' => $breakdown['tax_amount'],
            'platform_fee' => $breakdown['platform_fee'],
            'total_amount' => $breakdown['total_amount'],
            'payment_status' => 'pending',
            'payment_method' => 'escrow_transfer',
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('booking.show', $booking->booking_code)
            ->with('success', 'Pemesanan berhasil dibuat! Silakan tinjau rincian biaya dan lakukan pembayaran.');
    }

    /**
     * Halaman Invoice Resmi dengan Breakdown Pajak PBJT.
     */
    public function show(string $booking_code): View
    {
        $booking = Booking::with(['bookable', 'taxLedger'])
            ->where('booking_code', $booking_code)
            ->firstOrFail();

        return view('booking.invoice', compact('booking'));
    }

    /**
     * Simulasi Pembayaran Masuk -> Otomatis Memotong Pajak & Masuk ke Rekening Penampung (Escrow).
     */
    public function simulatePayment(string $booking_code): RedirectResponse
    {
        $booking = Booking::where('booking_code', $booking_code)->firstOrFail();

        if ($booking->payment_status === 'paid') {
            return back()->with('info', 'Pemesanan ini sudah berstatus LUNAS sebelumnya.');
        }

        $booking->update([
            'payment_status' => 'paid',
            'paid_at' => now(),
            'payment_reference' => 'SIM-' . strtoupper(Str::random(10)),
        ]);

        // Catat alokasi pajak ke Rekening Penampung (Escrow)
        $taxLedger = $this->pricingService->recordTaxEscrow($booking);

        return back()->with('success', sprintf(
            'Pembayaran sebesar Rp %s berhasil dikonfirmasi! Pajak PBJT (%s%%) sebesar Rp %s telah otomatis masuk ke rekening penampung (Escrow) Kasda dengan status: %s.',
            number_format($booking->total_amount, 0, ',', '.'),
            $booking->tax_rate_percent,
            number_format($booking->tax_amount, 0, ',', '.'),
            $taxLedger?->status ?? 'held_in_escrow'
        ));
    }
}
