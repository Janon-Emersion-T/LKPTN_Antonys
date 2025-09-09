<!DOCTYPE html>
<html>
<head>
    <title>Thank you for contacting us</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px 20px;
        }
        .summary-box {
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .summary-item {
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #dcfce7;
        }
        .summary-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .label {
            font-weight: bold;
            color: #059669;
        }
        .footer {
            background-color: #f8fafc;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }
        .footer p {
            margin: 0;
            color: #64748b;
            font-size: 14px;
        }
        .contact-info {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✅ Message Received!</h1>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">Thank you for contacting {{ config('app.name') }}</p>
        </div>
        
        <div class="content">
            <p>Dear {{ $contact->name }},</p>
            
            <p>Thank you for reaching out to us! We have successfully received your message and our team will review it shortly.</p>
            
            <div class="summary-box">
                <h3 style="margin-top: 0; color: #059669;">📋 Your Message Summary:</h3>
                
                <div class="summary-item">
                    <span class="label">Subject:</span> {{ $contact->subject }}
                </div>
                
                <div class="summary-item">
                    <span class="label">Email:</span> {{ $contact->email }}
                </div>
                
                @if($contact->phone)
                <div class="summary-item">
                    <span class="label">Phone:</span> {{ $contact->phone }}
                </div>
                @endif
                
                <div class="summary-item">
                    <span class="label">Submitted:</span> {{ $contact->created_at->format('F j, Y at g:i A') }}
                </div>
                
                <div class="summary-item">
                    <span class="label">Message:</span><br>
                    <div style="margin-top: 8px; padding: 10px; background-color: white; border-radius: 4px;">
                        {{ $contact->message }}
                    </div>
                </div>
            </div>
            
            <p><strong>What happens next?</strong></p>
            <ul>
                <li>We have received your query and will review your message within 24-48 hours</li>
                <li>Our support team will respond to you at <strong>{{ $contact->email }}</strong></li>
                <li>We aim to provide timely and helpful responses to all inquiries</li>
                <li>For urgent matters, you can contact us directly using the details below</li>
            </ul>
            
            <div class="contact-info">
                <h4 style="margin-top: 0; color: #f59e0b;">📞 Need immediate assistance or haven't heard back in a timely manner?</h4>
                <p style="margin-bottom: 0; line-height: 1.6;">
                    <strong>📞 Phone:</strong> <a href="tel:+{{ env('GLOBALS.CONTACT.PHONE_NUMBER') }}" style="color: #2563eb; text-decoration: none;">{{ env('GLOBALS.CONTACT.PHONE_NUMBER') }}</a><br>
                    <strong>💬 WhatsApp:</strong> <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', env('GLOBALS.CONTACT.WHATAPP_PHONE_NUMBER')) }}" style="color: #2563eb; text-decoration: none;" target="_blank">{{ env('GLOBALS.CONTACT.WHATAPP_PHONE_NUMBER') }}</a><br>
                    <strong>📧 Email:</strong> <a href="mailto:{{ env('GLOBALS.CONTACT.EMAIL') }}" style="color: #2563eb; text-decoration: none;">{{ env('GLOBALS.CONTACT.EMAIL') }}</a><br>
                    <strong>📍 Address:</strong> {{ env('GLOBALS.CONTACT.ADDRESS') }}
                </p>
                <p style="margin-top: 15px; font-size: 14px; color: #64748b;">
                    <em>If we haven't responded within a reasonable timeframe or you need immediate assistance, please don't hesitate to reach out using any of the contact methods above. We're here to help!</em>
                </p>
            </div>
        </div>
        
        <div class="footer">
            <p>This is an automated confirmation email from {{ config('app.name') }}.</p>
            <p>Please do not reply directly to this email.</p>
        </div>
    </div>
</body>
</html>