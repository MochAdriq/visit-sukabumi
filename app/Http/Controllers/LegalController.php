<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LegalController extends Controller
{
    /**
     * Display the official information and legal terms page.
     */
    public function show(string $tab = 'tentang-kami')
    {
        $validTabs = [
            'tentang-kami',
            'kebijakan-privasi',
            'syarat-ketentuan',
            'aksesibilitas',
            'hubungi-kami',
        ];

        if (!in_array($tab, $validTabs)) {
            $tab = 'tentang-kami';
        }

        return view('legal.index', [
            'activeTab' => $tab,
        ]);
    }
}
