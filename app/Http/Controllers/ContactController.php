<?php

namespace App\Http\Controllers;

use App\Mail\ContactSupportMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:2000',
        ]);

        Mail::to('iannmacabulos@gmail.com')->send(new ContactSupportMessage($validated));

        return back()->with('status', 'Your message has been sent successfully.');
    }
}
