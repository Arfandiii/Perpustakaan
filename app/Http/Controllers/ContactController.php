<?php

namespace App\Http\Controllers;

use App\Mail\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{

    public function sendContact(Request $request)
    {
        // Validasi input dari form
        $validatedData = $request->validate([
            'first-name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:500',
        ]);
        Mail::to(env('MAIL_TO_ADDRESS'))->send(new Enquiry($validatedData));
        return redirect()->back()->with('success', 'Pesan berhasil dikirim.');
    }
}
