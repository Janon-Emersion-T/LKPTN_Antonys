<!DOCTYPE html>
<html>
<head>
    <title>New Contact Form Submission</title>
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
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
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
        .field {
            margin-bottom: 20px;
        }
        .field-label {
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 5px;
        }
        .field-value {
            background-color: #f8fafc;
            padding: 10px;
            border-left: 3px solid #2563eb;
            border-radius: 4px;
        }
        .message-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
            margin-top: 10px;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📩 New Contact Form Submission</h1>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">{{ config('app.name') }}</p>
        </div>
        
        <div class="content">
            <p>Hello Admin,</p>
            <p>You have received a new contact form submission on {{ config('app.name') }}. Here are the details:</p>
            
            <div class="field">
                <div class="field-label">👤 Name:</div>
                <div class="field-value">{{ $contact->name }}</div>
            </div>
            
            <div class="field">
                <div class="field-label">📧 Email:</div>
                <div class="field-value">{{ $contact->email }}</div>
            </div>
            
            @if($contact->phone)
            <div class="field">
                <div class="field-label">📱 Phone:</div>
                <div class="field-value">{{ $contact->phone }}</div>
            </div>
            @endif
            
            <div class="field">
                <div class="field-label">📋 Subject:</div>
                <div class="field-value">{{ $contact->subject }}</div>
            </div>
            
            <div class="field">
                <div class="field-label">💬 Message:</div>
                <div class="message-box">{{ $contact->message }}</div>
            </div>
            
            <div class="field">
                <div class="field-label">📅 Submitted:</div>
                <div class="field-value">{{ $contact->created_at->format('F j, Y at g:i A') }}</div>
            </div>
        </div>
        
        <div class="footer">
            <p>This email was automatically generated from {{ config('app.name') }} contact form.</p>
            <p>To reply to this inquiry, simply reply to this email.</p>
        </div>
    </div>
</body>
</html>