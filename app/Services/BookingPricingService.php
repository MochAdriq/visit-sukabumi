<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\EventTicket;
use App\Models\HotelRoom;
use App\Models\TaxLedger;
use App\Models\TaxSetting;
use Carbon\Carbon;
use InvalidArgumentException;

class BookingPricingService
{
    /**
     * Dapatkan persentase tarif pajak aktif untuk sektor tertentu (default: 10%).
     */
    public function getActiveTaxRate(string $category): array
    {
        $setting = TaxSetting::where('category', $category)
            ->where('is_active', true)
            ->first();

        if ($setting) {
            return [
                'setting_id' => $setting->id,
                'name' => $setting->name,
                'rate_percent' => (float) $setting->rate_percent,
            ];
        }

        // Fallback default PBJT jika belum dikonfigurasi di DB
        $defaultName = $category === 'hotel' ? 'PBJT Jasa Perhotelan' : 'PBJT Kesenian dan Hiburan';
        return [
            'setting_id' => null,
            'name' => $defaultName,
            'rate_percent' => 10.00,
        ];
    }

    /**
     * Hitung rincian harga untuk tiket event.
     */
    public function calculateEvent(EventTicket $ticket, int $quantity = 1, float $platformFee = 0): array
    {
        if ($quantity < 1) {
            throw new InvalidArgumentException('Jumlah tiket minimal 1.');
        }

        $basePrice = (float) $ticket->price;
        $subtotal = $basePrice * $quantity;

        $taxInfo = $this->getActiveTaxRate('event');
        $taxRatePercent = $taxInfo['rate_percent'];
        $taxAmount = round($subtotal * ($taxRatePercent / 100), 2);
        $totalAmount = $subtotal + $taxAmount + $platformFee;

        return [
            'booking_type' => 'event',
            'bookable_type' => EventTicket::class,
            'bookable_id' => $ticket->id,
            'source_title' => $ticket->event ? $ticket->event->title : $ticket->name,
            'item_name' => $ticket->name,
            'base_price' => $basePrice,
            'quantity' => $quantity,
            'duration_nights' => 1,
            'subtotal_amount' => $subtotal,
            'tax_setting_id' => $taxInfo['setting_id'],
            'tax_name' => $taxInfo['name'],
            'tax_rate_percent' => $taxRatePercent,
            'tax_amount' => $taxAmount,
            'platform_fee' => $platformFee,
            'total_amount' => $totalAmount,
        ];
    }

    /**
     * Hitung rincian harga untuk pemesanan kamar hotel / akomodasi.
     */
    public function calculateHotel(HotelRoom $room, int $roomsCount, Carbon|string $checkIn, Carbon|string $checkOut, float $platformFee = 0): array
    {
        if ($roomsCount < 1) {
            throw new InvalidArgumentException('Jumlah kamar minimal 1.');
        }

        $checkInDate = is_string($checkIn) ? Carbon::parse($checkIn)->startOfDay() : $checkIn->copy()->startOfDay();
        $checkOutDate = is_string($checkOut) ? Carbon::parse($checkOut)->startOfDay() : $checkOut->copy()->startOfDay();

        if ($checkOutDate->lte($checkInDate)) {
            throw new InvalidArgumentException('Tanggal check-out harus setelah tanggal check-in.');
        }

        $nights = max(1, $checkInDate->diffInDays($checkOutDate));
        $basePrice = (float) $room->price_per_night;
        $effectiveUnits = $roomsCount * $nights;
        $subtotal = $basePrice * $effectiveUnits;

        $taxInfo = $this->getActiveTaxRate('hotel');
        $taxRatePercent = $taxInfo['rate_percent'];
        $taxAmount = round($subtotal * ($taxRatePercent / 100), 2);
        $totalAmount = $subtotal + $taxAmount + $platformFee;

        return [
            'booking_type' => 'hotel',
            'bookable_type' => HotelRoom::class,
            'bookable_id' => $room->id,
            'source_title' => $room->place ? $room->place->name : $room->name,
            'item_name' => $room->name,
            'check_in_date' => $checkInDate->toDateString(),
            'check_out_date' => $checkOutDate->toDateString(),
            'duration_nights' => $nights,
            'rooms_count' => $roomsCount,
            'quantity' => $effectiveUnits,
            'base_price' => $basePrice,
            'subtotal_amount' => $subtotal,
            'tax_setting_id' => $taxInfo['setting_id'],
            'tax_name' => $taxInfo['name'],
            'tax_rate_percent' => $taxRatePercent,
            'tax_amount' => $taxAmount,
            'platform_fee' => $platformFee,
            'total_amount' => $totalAmount,
        ];
    }

    /**
     * Catat mutasi pajak ke Rekening Penampung (Escrow) di TaxLedger saat transaksi PAID.
     */
    public function recordTaxEscrow(Booking $booking): ?TaxLedger
    {
        if ($booking->tax_amount <= 0) {
            return null;
        }

        // Hindari duplikasi pencatatan
        $existing = TaxLedger::where('booking_id', $booking->id)->first();
        if ($existing) {
            return $existing;
        }

        $taxSetting = TaxSetting::where('category', $booking->booking_type)
            ->where('is_active', true)
            ->first();

        return TaxLedger::create([
            'booking_id' => $booking->id,
            'tax_setting_id' => $taxSetting?->id,
            'sector' => $booking->booking_type,
            'vendor_name' => $booking->source_title,
            'tax_amount' => $booking->tax_amount,
            'status' => 'held_in_escrow',
        ]);
    }
}
