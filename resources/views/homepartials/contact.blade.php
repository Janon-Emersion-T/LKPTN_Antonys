{{-- Contact Page Component --}}
<div class="bg-gray-50 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

        {{-- Page Header --}}
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Contact Us</h1>
            <p class="text-lg text-blue-600 font-semibold">HOTLINE: {{env('GLOBALS.CONTACT.PHONE_NUMBER')}}</p>
        </div>

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            
            {{-- Left Column --}}
            <div class="space-y-8">
                {{-- Contact Info --}}
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Contact Details</h2>
                    <ul class="space-y-3 text-gray-700 text-sm">
                        <li><strong>Phone:</strong> <a href="tel:+{{env('GLOBALS.CONTACT.PHONE_NUMBER')}}" class="text-blue-600 hover:underline">+{{env('GLOBALS.CONTACT.PHONE_NUMBER')}}</a></li>
                        <li><strong>WhatsApp:</strong> <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', env('GLOBALS.CONTACT.WHATAPP_PHONE_NUMBER')) }}" target="_blank" class="text-blue-600 hover:underline">{{env('GLOBALS.CONTACT.WHATAPP_PHONE_NUMBER')}}</a></li>
                        <li><strong>Email:</strong> <a href="mailto:{{ env('GLOBALS.CONTACT.EMAIL')}}" class="text-blue-600 hover:underline">{{ env('GLOBALS.CONTACT.EMAIL')}}</a></li>
                        <li><strong>Address:</strong> 149/1 Jaffna-Kankesanturai Rd, Jaffna</li>
                    </ul>
                </div>

                {{-- Business Hours --}}
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Business Hours</h2>
                    <ul class="text-sm text-gray-700 space-y-2">
                        <li class="flex justify-between">
                            <span>Monday - Saturday:</span>
                            <span class="font-medium">{{env('GLOBALS.COMPANY_OPENING_HOURS')}}</span>
                        </li>
                    </ul>
                </div>

                {{-- Feedback --}}
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Feedback</h2>
                    <p class="text-sm text-gray-600">
                        Have questions about our services? Email us at 
                        <a href="mailto:{{ env('GLOBALS.CONTACT.EMAIL')}}" class="text-blue-600 hover:underline">{{ env('GLOBALS.CONTACT.EMAIL')}}</a>
                    </p>
                </div>
            </div>

            {{-- Right Column - Map --}}
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <iframe
                    src="{{ env('GLOBALS.MAP_IFRAME')}}"
                    width="100%"
                    height="600"
                    style="border:0;"
                    allowfullscreen
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

        </div>

        {{-- Contact Form --}}
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Send Us a Message</h2>
            <form id="contactForm" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                    <input type="text" id="name" name="name" required class="input-field">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                    <input type="email" id="email" name="email" required class="input-field">
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                    <input type="tel" id="phone" name="phone" class="input-field">
                </div>
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject *</label>
                    <select id="subject" name="subject" required class="input-field">
                        <option value="">Select a subject</option>
                        <option value="general">General Inquiry</option>
                        <option value="sales">Sales Inquiry</option>
                        <option value="support">Technical Support</option>
                        <option value="warranty">Warranty Claim</option>
                        <option value="feedback">Feedback</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message *</label>
                    <textarea id="message" name="message" rows="4" required class="input-field resize-none" placeholder="Describe your inquiry..."></textarea>
                </div>
                <div class="md:col-span-2 text-right">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-md transition">Send Message</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.input-field {
    @apply w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent;
}
</style>
