<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function create()
    {
        // Static org details from your prompt
        $org = [
            'director' => 'The Director of the National Arts Council of Zambia',
            'address_1' => 'Acacia House, Cairo Road (Next to National Milling)',
            'po_box'    => 'P.O. Box 50812, Lusaka',
            'email'     => 'zedartspolicy2022@gmail.com',
            'mobile'    => '+260 979 313 121',
            'landline'  => '+260 211 220 638',
            'website'   => 'www.arts.gov.zm',
            'facebook'  => 'https://www.facebook.com/NACZedArts',
        ];

        return view('contact.create', compact('org'));
    }

    public function store(Request $request)
    {
        // Honeypot field name: "website_url"
        $validated = $request->validate([
            'name'         => ['required','string','max:160'],
            'email'        => ['required','email','max:160'],
            'phone'        => ['nullable','string','max:40'],
            'subject'      => ['required','string','max:180'],
            'message'      => ['required','string','max:5000'],
            'website_url'  => ['nullable','size:0'], // bot trap
        ], [
            'website_url.size' => 'Bot detected.',
        ]);

        // Persist
        $msg = ContactMessage::create([
            'name'    => $validated['name'],
            'email'   => $validated['email'],
            'phone'   => $validated['phone'] ?? null,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'ip'      => $request->ip(),
            'ua'      => substr((string)$request->userAgent(), 0, 255),
        ]);

        // Email notify (simple inline view)
        try {
            Mail::send('emails.contact_message', ['m' => $msg], function ($mail) use ($msg) {
                $mail->to('zedartspolicy2022@gmail.com', 'NAC Zambia')
                     ->subject('New Contact Message: '.$msg->subject);
            });
        } catch (\Throwable $e) {
            // Fail silently; message is still saved.
            report($e);
        }

        return redirect()->route('contact.create')
            ->with('status', 'Thanks! Your message has been sent. We’ll get back to you soon.');
    }
}
