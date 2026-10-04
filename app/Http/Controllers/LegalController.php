<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LegalController extends Controller
{
    public function privacy()
    {
        return view('pages.legal.privacy', [
            'title' => 'Privacy Policy - ' . config('app.name'),
            'active' => 'legal',
        ]);
    }

    public function terms()
    {
        return view('pages.legal.terms', [
            'title' => 'Terms and Conditions - ' . config('app.name'),
            'active' => 'legal',
        ]);
    }
}
