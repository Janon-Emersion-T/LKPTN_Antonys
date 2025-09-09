<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    /**
     * Display the contact form
     */
    public function index(): View
    {
        return view('pages.contactus');
    }

    /**
     * Store contact form submission
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        // Create the contact record
        $contact = Contact::create($validated);

        // Send email notification to admin
        try {
            $adminEmail = env('GLOBALS.CONTACT.EMAIL', config('mail.from.address'));
            
            Mail::send('emails.contact-notification', compact('contact'), function ($message) use ($adminEmail, $contact) {
                $message->to($adminEmail)
                    ->subject('New Contact Form Submission: ' . $contact->subject)
                    ->replyTo($contact->email, $contact->name);
            });

            // Send confirmation email to user
            Mail::send('emails.contact-confirmation', compact('contact'), function ($message) use ($contact) {
                $message->to($contact->email, $contact->name)
                    ->subject('Thank you for contacting us - ' . $contact->subject);
            });

        } catch (\Exception $e) {
            \Log::error('Contact form email failed: ' . $e->getMessage());
        }

        return redirect()
            ->route('contactus')
            ->with('success', 'Thank you for your message! We will get back to you soon.');
    }
}
