<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
    <title>TechHub - Premium Computer Store</title>
    <meta name="description" content="Your trusted partner for premium computer hardware and technology solutions in Sri Lanka. Latest laptops, desktops, gaming PCs and accessories.">
</head>
<body class="min-h-screen bg-gray-50 dark:bg-gray-900">
    @include('partials.header')
    {{-- Privacy Policy Page Component --}}
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Page Header --}}
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Privacy Policy</h1>
            <p class="text-gray-600">Last updated: August 09, 2023</p>
        </div>

        {{-- Main Content --}}
        <div class="bg-white rounded-lg shadow-sm p-8">
            <div class="prose prose-gray max-w-none">
                
                {{-- Introduction --}}
                <section class="mb-8">
                    <p class="text-gray-700 leading-relaxed mb-4">
                        This Privacy Policy describes Our policies and procedures on the collection, use and disclosure of Your information when You use the Service and tells You about Your privacy rights and how the law protects You.
                    </p>
                    <p class="text-gray-700 leading-relaxed">
                        We use Your Personal data to provide and improve the Service. By using the Service, You agree to the collection and use of information in accordance with this Privacy Policy.
                    </p>
                </section>

                {{-- Interpretation and Definitions --}}
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Interpretation and Definitions</h2>
                    
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Interpretation</h3>
                    <p class="text-gray-700 leading-relaxed mb-6">
                        The words of which the initial letter is capitalized have meanings defined under the following conditions. The following definitions shall have the same meaning regardless of whether they appear in singular or in plural.
                    </p>

                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Definitions</h3>
                    <p class="text-gray-700 leading-relaxed mb-4">For the purposes of this Privacy Policy:</p>
                    
                    <div class="bg-blue-50 rounded-lg p-6 mb-6">
                        <dl class="space-y-4">
                            <div>
                                <dt class="font-semibold text-blue-900">Account</dt>
                                <dd class="text-blue-800">means a unique account created for You to access our Service or parts of our Service.</dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-blue-900">Affiliate</dt>
                                <dd class="text-blue-800">means an entity that controls, is controlled by or is under common control with a party, where "control" means ownership of 50% or more of the shares, equity interest or other securities entitled to vote for election of directors or other managing authority.</dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-blue-900">Company</dt>
                                <dd class="text-blue-800">(referred to as either "the Company", "We", "Us" or "Our" in this Agreement) refers to Barclays Computers (PVT) Ltd, #42 Galle Rd, Colombo, Sri Lanka.</dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-blue-900">Cookies</dt>
                                <dd class="text-blue-800">are small files that are placed on Your computer, mobile device or any other device by a website, containing the details of Your browsing history on that website among its many uses.</dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-blue-900">Country</dt>
                                <dd class="text-blue-800">refers to: Sri Lanka</dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-blue-900">Device</dt>
                                <dd class="text-blue-800">means any device that can access the Service such as a computer, a cellphone or a digital tablet.</dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-blue-900">Personal Data</dt>
                                <dd class="text-blue-800">is any information that relates to an identified or identifiable individual.</dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-blue-900">Service</dt>
                                <dd class="text-blue-800">refers to the Website.</dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-blue-900">Service Provider</dt>
                                <dd class="text-blue-800">means any natural or legal person who processes the data on behalf of the Company. It refers to third-party companies or individuals employed by the Company to facilitate the Service, to provide the Service on behalf of the Company, to perform services related to the Service or to assist the Company in analyzing how the Service is used.</dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-blue-900">Usage Data</dt>
                                <dd class="text-blue-800">refers to data collected automatically, either generated by the use of the Service or from the Service infrastructure itself (for example, the duration of a page visit).</dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-blue-900">Website, Android or iOS mobile apps</dt>
                                <dd class="text-blue-800">refers to Barclays, <a href="https://www.barclays.lk" class="text-blue-600 hover:text-blue-800">https://www.barclays.lk</a></dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-blue-900">You</dt>
                                <dd class="text-blue-800">means the individual accessing or using the Service, or the company, or other legal entity on behalf of which such individual is accessing or using the Service, as applicable.</dd>
                            </div>
                        </dl>
                    </div>
                </section>

                {{-- Collecting and Using Your Personal Data --}}
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Collecting and Using Your Personal Data</h2>
                    
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Types of Data Collected</h3>
                    
                    <h4 class="text-lg font-semibold text-gray-900 mb-3">Personal Data</h4>
                    <p class="text-gray-700 leading-relaxed mb-4">
                        While using Our Service, We may ask You to provide Us with certain personally identifiable information that can be used to contact or identify You. Personally identifiable information may include, but is not limited to:
                    </p>
                    
                    <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
                        <ul class="list-disc list-inside text-green-700 space-y-1">
                            <li>Email address</li>
                            <li>First name and last name</li>
                            <li>Phone number</li>
                            <li>Address, State, Province, ZIP/Postal code, City</li>
                            <li>Usage Data</li>
                        </ul>
                    </div>

                    <h4 class="text-lg font-semibold text-gray-900 mb-3">Usage Data</h4>
                    <p class="text-gray-700 leading-relaxed mb-4">
                        Usage Data is collected automatically when using the Service.
                    </p>
                    <p class="text-gray-700 leading-relaxed mb-4">
                        Usage Data may include information such as Your Device's Internet Protocol address (e.g. IP address), browser type, browser version, the pages of our Service that You visit, the time and date of Your visit, the time spent on those pages, unique device identifiers and other diagnostic data.
                    </p>
                    <p class="text-gray-700 leading-relaxed mb-4">
                        When You access the Service by or through a mobile device or Android or iOS app, We may collect certain information automatically, including, but not limited to, the type of mobile device You use, Your mobile device unique ID, the IP address of Your mobile device, Your mobile operating system, the type of mobile Internet browser You use, unique device identifiers and other diagnostic data.
                    </p>
                    <p class="text-gray-700 leading-relaxed">
                        We may also collect information that Your browser or app sends whenever You visit our Service or when You access the Service by or through a mobile device.
                    </p>
                </section>

                {{-- Tracking Technologies and Cookies --}}
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Tracking Technologies and Cookies</h2>
                    <p class="text-gray-700 leading-relaxed mb-4">
                        We use Cookies and similar tracking technologies to track the activity on Our Service and store certain information. Tracking technologies used are beacons, tags, and scripts to collect and track information and to improve and analyze Our Service. The technologies We use may include:
                    </p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-purple-50 rounded-lg p-4">
                            <h4 class="font-semibold text-purple-900 mb-2">Cookies or Browser Cookies</h4>
                            <p class="text-purple-800 text-sm">
                                A cookie is a small file placed on Your Device. You can instruct Your browser to refuse all Cookies or to indicate when a Cookie is being sent. However, if You do not accept Cookies, You may not be able to use some parts of our Service.
                            </p>
                        </div>
                        <div class="bg-purple-50 rounded-lg p-4">
                            <h4 class="font-semibold text-purple-900 mb-2">Web Beacons</h4>
                            <p class="text-purple-800 text-sm">
                                Certain sections of our Service and our emails may contain small electronic files known as web beacons that permit the Company to count users who have visited those pages or opened an email.
                            </p>
                        </div>
                    </div>

                    <p class="text-gray-700 leading-relaxed mb-4">
                        Cookies can be "Persistent" or "Session" Cookies. Persistent Cookies remain on Your personal computer or mobile device when You go offline, while Session Cookies are deleted as soon as You close Your web browser.
                    </p>

                    <h3 class="text-xl font-semibold text-gray-900 mb-4">We use both Session and Persistent Cookies for the purposes set out below:</h3>
                    
                    <div class="space-y-4">
                        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4">
                            <h4 class="font-semibold text-yellow-900 mb-2">Necessary / Essential Cookies</h4>
                            <p class="text-yellow-800 text-sm mb-1"><strong>Type:</strong> Session Cookies</p>
                            <p class="text-yellow-800 text-sm mb-1"><strong>Administered by:</strong> Us</p>
                            <p class="text-yellow-800 text-sm"><strong>Purpose:</strong> These Cookies are essential to provide You with services available through the Website and to enable You to use some of its features. They help to authenticate users and prevent fraudulent use of user accounts.</p>
                        </div>
                        
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4">
                            <h4 class="font-semibold text-blue-900 mb-2">Cookies Policy / Notice Acceptance Cookies</h4>
                            <p class="text-blue-800 text-sm mb-1"><strong>Type:</strong> Persistent Cookies</p>
                            <p class="text-blue-800 text-sm mb-1"><strong>Administered by:</strong> Us</p>
                            <p class="text-blue-800 text-sm"><strong>Purpose:</strong> These Cookies identify if users have accepted the use of cookies on the Website.</p>
                        </div>
                        
                        <div class="bg-green-50 border-l-4 border-green-500 p-4">
                            <h4 class="font-semibold text-green-900 mb-2">Functionality Cookies</h4>
                            <p class="text-green-800 text-sm mb-1"><strong>Type:</strong> Persistent Cookies</p>
                            <p class="text-green-800 text-sm mb-1"><strong>Administered by:</strong> Us</p>
                            <p class="text-green-800 text-sm"><strong>Purpose:</strong> These Cookies allow us to remember choices You make when You use the Website, such as remembering your login details or language preference.</p>
                        </div>
                    </div>
                </section>

                {{-- Use of Your Personal Data --}}
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Use of Your Personal Data</h2>
                    <p class="text-gray-700 leading-relaxed mb-4">The Company may use Personal Data for the following purposes:</p>
                    
                    <ul class="list-disc list-inside text-gray-700 space-y-2 mb-6">
                        <li><strong>To provide and maintain our Service,</strong> including to monitor the usage of our Service.</li>
                        <li><strong>To manage Your Account:</strong> to manage Your registration as a user of the Service. The Personal Data You provide can give You access to different functionalities of the Service that are available to You as a registered user.</li>
                        <li><strong>For the performance of a contract:</strong> the development, compliance and undertaking of the purchase contract for the products, items or services You have purchased or of any other contract with Us through the Service.</li>
                        <li><strong>To contact You:</strong> To contact You by email, telephone calls, SMS, or other equivalent forms of electronic communication, such as a mobile application's push notifications regarding updates or informative communications related to the functionalities, products or contracted services, including the security updates, when necessary or reasonable for their implementation.</li>
                        <li><strong>To provide You</strong> with news, special offers and general information about other goods, services and events which we offer that are similar to those that you have already purchased or enquired about unless You have opted not to receive such information.</li>
                        <li><strong>To manage Your requests:</strong> To attend and manage Your requests to Us.</li>
                        <li><strong>For business transfers:</strong> We may use Your information to evaluate or conduct a merger, divestiture, restructuring, reorganization, dissolution, or other sale or transfer of some or all of Our assets.</li>
                        <li><strong>For other purposes:</strong> We may use Your information for other purposes, such as data analysis, identifying usage trends, determining the effectiveness of our promotional campaigns and to evaluate and improve our Service, products, services, marketing and your experience.</li>
                    </ul>

                    <h3 class="text-xl font-semibold text-gray-900 mb-4">We may share Your personal information in the following situations:</h3>
                    <ul class="list-disc list-inside text-gray-700 space-y-2">
                        <li><strong>With Service Providers:</strong> We may share Your personal information with Service Providers to monitor and analyze the use of our Service, to contact You.</li>
                        <li><strong>For business transfers:</strong> We may share or transfer Your personal information in connection with, or during negotiations of, any merger, sale of Company assets, financing, or acquisition of all or a portion of Our business to another company.</li>
                        <li><strong>With Affiliates:</strong> We may share Your information with Our affiliates, in which case we will require those affiliates to honor this Privacy Policy.</li>
                        <li><strong>With business partners:</strong> We may share Your information with Our business partners to offer You certain products, services or promotions.</li>
                        <li><strong>With other users:</strong> when You share personal information or otherwise interact in the public areas with other users, such information may be viewed by all users and may be publicly distributed outside.</li>
                        <li><strong>With Your consent:</strong> We may disclose Your personal information for any other purpose with Your consent.</li>
                    </ul>
                </section>

                {{-- Retention of Your Personal Data --}}
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Retention of Your Personal Data</h2>
                    <p class="text-gray-700 leading-relaxed mb-4">
                        The Company will retain Your Personal Data only for as long as is necessary for the purposes set out in this Privacy Policy. We will retain and use Your Personal Data to the extent necessary to comply with our legal obligations (for example, if we are required to retain your data to comply with applicable laws), resolve disputes, and enforce our legal agreements and policies.
                    </p>
                    <p class="text-gray-700 leading-relaxed">
                        The Company will also retain Usage Data for internal analysis purposes. Usage Data is generally retained for a shorter period of time, except when this data is used to strengthen the security or to improve the functionality of Our Service, or We are legally obligated to retain this data for longer time periods.
                    </p>
                </section>

                {{-- Transfer of Your Personal Data --}}
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Transfer of Your Personal Data</h2>
                    <p class="text-gray-700 leading-relaxed mb-4">
                        Your information, including Personal Data, is processed at the Company's operating offices and in any other places where the parties involved in the processing are located. It means that this information may be transferred to — and maintained on — computers located outside of Your state, province, country or other governmental jurisdiction where the data protection laws may differ than those from Your jurisdiction.
                    </p>
                    <p class="text-gray-700 leading-relaxed mb-4">
                        Your consent to this Privacy Policy followed by Your submission of such information represents Your agreement to that transfer.
                    </p>
                    <p class="text-gray-700 leading-relaxed">
                        The Company will take all steps reasonably necessary to ensure that Your data is treated securely and in accordance with this Privacy Policy and no transfer of Your Personal Data will take place to an organization or a country unless there are adequate controls in place including the security of Your data and other personal information.
                    </p>
                </section>

                {{-- Delete Your Personal Data --}}
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Delete Your Personal Data</h2>
                    <p class="text-gray-700 leading-relaxed mb-4">
                        You have the right to delete or request that We assist in deleting the Personal Data that We have collected about You.
                    </p>
                    <p class="text-gray-700 leading-relaxed mb-4">
                        Our Service may give You the ability to delete certain information about You from within the Service.
                    </p>
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-4">
                        <p class="text-red-800">
                            You may update or amend your information at any time by signing in to Your Account, if you have one, and visiting the account settings section that allows you to manage Your personal information. You may also contact Us to request access to, correct, or delete any personal information that You have provided to Us. Furthermore, if you need to delete your account, please request via email to 
                            <a href="mailto:support@barclays.lk" class="text-red-600 hover:text-red-800 font-semibold">support@barclays.lk</a>. 
                            (You must mention your account registered email address there with)
                        </p>
                    </div>
                    <p class="text-gray-700 leading-relaxed">
                        Please note, however, that We may need to retain certain information when we have a legal obligation or lawful basis to do so.
                    </p>
                </section>

                {{-- Disclosure of Your Personal Data --}}
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Disclosure of Your Personal Data</h2>
                    
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Business Transactions</h3>
                    <p class="text-gray-700 leading-relaxed mb-4">
                        If the Company is involved in a merger, acquisition or asset sale, Your Personal Data may be transferred. We will provide notice before Your Personal Data is transferred and becomes subject to a different Privacy Policy.
                    </p>

                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Law enforcement</h3>
                    <p class="text-gray-700 leading-relaxed mb-4">
                        Under certain circumstances, the Company may be required to disclose Your Personal Data if required to do so by law or in response to valid requests by public authorities (e.g. a court or a government agency).
                    </p>

                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Other legal requirements</h3>
                    <p class="text-gray-700 leading-relaxed mb-2">The Company may disclose Your Personal Data in the good faith belief that such action is necessary to:</p>
                    <ul class="list-disc list-inside text-gray-700 space-y-1">
                        <li>Comply with a legal obligation</li>
                        <li>Protect and defend the rights or property of the Company</li>
                        <li>Prevent or investigate possible wrongdoing in connection with the Service</li>
                        <li>Protect the personal safety of Users of the Service or the public</li>
                        <li>Protect against legal liability</li>
                    </ul>
                </section>

                {{-- Security of Your Personal Data --}}
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Security of Your Personal Data</h2>
                    <div class="bg-orange-50 border-l-4 border-orange-500 p-4">
                        <p class="text-orange-800">
                            The security of Your Personal Data is important to Us, but remember that no method of transmission over the Internet, or method of electronic storage is 100% secure. While We strive to use commercially acceptable means to protect Your Personal Data, We cannot guarantee its absolute security.
                        </p>
                    </div>
                </section>

                {{-- Children's Privacy --}}
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Children's Privacy</h2>
                    <p class="text-gray-700 leading-relaxed mb-4">
                        Our Service does not address anyone under the age of 13. We do not knowingly collect personally identifiable information from anyone under the age of 13. If You are a parent or guardian and You are aware that Your child has provided Us with Personal Data, please contact Us. If We become aware that We have collected Personal Data from anyone under the age of 13 without verification of parental consent, We take steps to remove that information from Our servers.
                    </p>
                    <p class="text-gray-700 leading-relaxed">
                        If We need to rely on consent as a legal basis for processing Your information and Your country requires consent from a parent, We may require Your parent's consent before We collect and use that information.
                    </p>
                </section>

                {{-- Links to Other Websites --}}
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Links to Other Websites</h2>
                    <p class="text-gray-700 leading-relaxed mb-4">
                        Our Service may contain links to other websites or apps that are not operated by Us. If You click on a third party link, You will be directed to that third party's site. We strongly advise You to review the Privacy Policy of every site You visit.
                    </p>
                    <p class="text-gray-700 leading-relaxed">
                        We have no control over and assume no responsibility for the content, privacy policies or practices of any third party sites or services.
                    </p>
                </section>

                {{-- Changes to this Privacy Policy --}}
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Changes to this Privacy Policy</h2>
                    <p class="text-gray-700 leading-relaxed mb-4">
                        We may update Our Privacy Policy from time to time. We will notify You of any changes by posting the new Privacy Policy on this page.
                    </p>
                    <p class="text-gray-700 leading-relaxed mb-4">
                        We will let You know via email and/or a prominent notice on Our Service, prior to the change becoming effective and update the "Last updated" date at the top of this Privacy Policy.
                    </p>
                    <p class="text-gray-700 leading-relaxed">
                        You are advised to review this Privacy Policy periodically for any changes. Changes to this Privacy Policy are effective when they are posted on this page.
                    </p>
                </section>

                {{-- Contact Us --}}
                <section class="mb-8">
                    <div class="bg-blue-50 rounded-lg p-6">
                        <h2 class="text-xl font-bold text-blue-900 mb-4">Contact Us</h2>
                        <p class="text-blue-800 mb-4">
                            If you have any questions about this Privacy Policy, You can contact us:
                        </p>
                        <div class="space-y-2 text-blue-700">
                            <p><strong>By email:</strong> <a href="mailto:info@barclays.lk" class="hover:text-blue-900">info@barclays.lk</a></p>
                            <p><strong>By visiting this page on our website:</strong> <a href="https://www.barclays.lk/contact.asp" class="hover:text-blue-900">https://www.barclays.lk/contact.asp</a></p>
                            <p><strong>By phone number:</strong> <a href="tel:0117510510" class="hover:text-blue-900">Call 011 7510 510</a></p>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        {{-- Page Actions --}}
        <div class="mt-8 flex justify-between items-center">
            <a href="#top" class="text-blue-600 hover:text-blue-800 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                </svg>
                Back to Top
            </a>
            <div class="space-x-4 flex items-center">
                <button onclick="window.print()" class="text-gray-600 hover:text-gray-800 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Print
                </button>
                <button onclick="sharePrivacyPolicy()" class="text-gray-600 hover:text-gray-800 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"/>
                    </svg>
                    Share
                </button>
                <button onclick="requestDataDeletion()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm font-medium transition-colors">
                    Request Data Deletion
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* Typography and spacing */
.prose h2 {
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.prose h3 {
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
}

.prose h4 {
    margin-top: 1rem;
    margin-bottom: 0.5rem;
}

.prose p {
    margin-bottom: 1rem;
    line-height: 1.7;
}

.prose ul {
    margin-bottom: 1rem;
}

.prose li {
    margin-bottom: 0.25rem;
}

/* Definition list styling */
dl {
    margin: 0;
}

dt {
    margin-bottom: 0.25rem;
}

dd {
    margin-bottom: 1rem;
    margin-left: 0;
    padding-left: 1rem;
}

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Create progress indicator
    const progressIndicator = document.createElement('div');
    progressIndicator.className = 'progress-indicator';
    document.body.appendChild(progressIndicator);

    // Update progress on scroll
    function updateProgress() {
        const scrollTop = window.pageYOffset;
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;
        const scrollPercent = (scrollTop / docHeight) * 100;
        progressIndicator.style.width = scrollPercent + '%';
    }

    window.addEventListener('scroll', updateProgress);

    // Add anchor links to headings
    const headings = document.querySelectorAll('h2, h3');
    headings.forEach((heading, index) => {
        const id = heading.textContent.toLowerCase().replace(/\s+/g, '-').replace(/[^\w-]/g, '');
        heading.id = id;
        
        // Add click handler for copying anchor links
        heading.style.cursor = 'pointer';
        heading.title = 'Click to copy link';
        heading.addEventListener('click', function() {
            const url = `${window.location.origin}${window.location.pathname}#${id}`;
            navigator.clipboard.writeText(url).then(() => {
                showNotification('Section link copied to clipboard!');
            });
        });
    });

    // Smooth scroll for anchor links
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            } else {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Track section views for analytics
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const sectionTitle = entry.target.textContent;
                console.log(`Privacy section viewed: ${sectionTitle}`);
                // Add analytics tracking here
                // gtag('event', 'privacy_section_view', { section: sectionTitle });
            }
        });
    }, { threshold: 0.5 });

    // Observe all section headings
    headings.forEach(heading => {
        observer.observe(heading);
    });

    // Email link tracking
    const emailLinks = document.querySelectorAll('a[href^="mailto:"]');
    emailLinks.forEach(link => {
        link.addEventListener('click', function() {
            console.log('Privacy policy email contact clicked');
            // Add analytics tracking here
        });
    });

    // Phone link tracking
    const phoneLinks = document.querySelectorAll('a[href^="tel:"]');
    phoneLinks.forEach(link => {
        link.addEventListener('click', function() {
            console.log('Privacy policy phone contact clicked');
            // Add analytics tracking here
        });
    });

    // Cookie acceptance demo (if needed)
    function showCookieBanner() {
        const banner = document.createElement('div');
        banner.className = 'cookie-banner';
        banner.innerHTML = `
            <div class="max-w-4xl mx-auto flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
                <div class="text-sm">
                    <p>We use cookies to enhance your experience. By continuing to visit this site you agree to our use of cookies. 
                    <a href="#tracking-technologies-and-cookies" class="text-blue-300 hover:text-blue-200 underline">Learn more</a></p>
                </div>
                <div class="space-x-4">
                    <button onclick="acceptCookies()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">Accept</button>
                    <button onclick="declineCookies()" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded text-sm">Decline</button>
                </div>
            </div>
        `;
        document.body.appendChild(banner);
        
        setTimeout(() => {
            banner.classList.add('show');
        }, 1000);
        
        return banner;
    }

    // Check if cookies were already accepted
    if (!localStorage.getItem('cookiesAccepted') && !localStorage.getItem('cookiesDeclined')) {
        // Uncomment to show cookie banner
        // showCookieBanner();
    }
});

// Share functionality
function sharePrivacyPolicy() {
    if (navigator.share) {
        navigator.share({
            title: 'Barclays Computers Privacy Policy',
            text: 'Read about how Barclays Computers protects your personal information',
            url: window.location.href
        }).catch(console.error);
    } else {
        // Fallback - copy URL to clipboard
        navigator.clipboard.writeText(window.location.href).then(() => {
            showNotification('Privacy Policy link copied to clipboard!');
        });
    }
}

// Data deletion request
function requestDataDeletion() {
    const confirmed = confirm('Are you sure you want to request deletion of your personal data? This action will require email verification.');
    
    if (confirmed) {
        const email = prompt('Please enter your registered email address:');
        if (email && validateEmail(email)) {
            // Compose email for data deletion request
            const subject = encodeURIComponent('Data Deletion Request');
            const body = encodeURIComponent(`Dear Barclays Computers Team,

I am requesting the deletion of my personal data associated with this email address: ${email}

Please process my request in accordance with your Privacy Policy and applicable data protection laws.

Thank you.`);
            
            window.location.href = `mailto:support@barclays.lk?subject=${subject}&body=${body}`;
            
            showNotification('Email client opened with deletion request template. Please send the email to complete your request.');
        } else if (email) {
            alert('Please enter a valid email address.');
        }
    }
}

// Cookie management functions
function acceptCookies() {
    localStorage.setItem('cookiesAccepted', 'true');
    const banner = document.querySelector('.cookie-banner');
    if (banner) {
        banner.classList.remove('show');
        setTimeout(() => {
            banner.remove();
        }, 300);
    }
    console.log('Cookies accepted');
    // Enable all tracking/analytics here
}

function declineCookies() {
    localStorage.setItem('cookiesDeclined', 'true');
    const banner = document.querySelector('.cookie-banner');
    if (banner) {
        banner.classList.remove('show');
        setTimeout(() => {
            banner.remove();
        }, 300);
    }
    console.log('Cookies declined');
    // Disable non-essential tracking here
}

// Email validation
function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Notification system
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.textContent = message;
    
    const bgColor = type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#3b82f6';
    
    notification.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: ${bgColor};
        color: white;
        padding: 12px 20px;
        border-radius: 6px;
        z-index: 10002;
        transition: all 0.3s ease;
        transform: translateY(100px);
        max-width: 300px;
        font-size: 14px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    `;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateY(0)';
    }, 100);
    
    // Remove after 4 seconds
    setTimeout(() => {
        notification.style.transform = 'translateY(100px)';
        setTimeout(() => {
            if (document.body.contains(notification)) {
                document.body.removeChild(notification);
            }
        }, 300);
    }, 4000);
}

// Privacy settings management
window.PrivacySettings = {
    // Get current cookie preferences
    getCookiePreferences: function() {
        return {
            accepted: localStorage.getItem('cookiesAccepted') === 'true',
            declined: localStorage.getItem('cookiesDeclined') === 'true'
        };
    },
    
    // Clear all stored preferences
    clearPreferences: function() {
        localStorage.removeItem('cookiesAccepted');
        localStorage.removeItem('cookiesDeclined');
        showNotification('Privacy preferences cleared. Refresh the page to see the cookie banner again.');
    },
    
    // Export user data (placeholder)
    exportUserData: function() {
        const data = {
            exportDate: new Date().toISOString(),
            cookiePreferences: this.getCookiePreferences(),
            message: 'This is a demo export. In a real implementation, this would contain all user data.'
        };
        
        const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'barclays-privacy-data-export.json';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
        
        showNotification('Privacy data export downloaded successfully.');
    }
};

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + K to search within policy
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        const searchTerm = prompt('Search within Privacy Policy:');
        if (searchTerm) {
            searchInPolicy(searchTerm);
        }
    }
    
    // Escape key to close any modals/notifications
    if (e.key === 'Escape') {
        const notifications = document.querySelectorAll('[style*="position: fixed"]');
        notifications.forEach(notification => {
            if (notification.style.bottom && notification.style.right) {
                notification.style.transform = 'translateY(100px)';
                setTimeout(() => {
                    if (document.body.contains(notification)) {
                        document.body.removeChild(notification);
                    }
                }, 300);
            }
        });
    }
});

// Search within policy
function searchInPolicy(searchTerm) {
    const content = document.querySelector('.prose');
    const text = content.textContent.toLowerCase();
    const term = searchTerm.toLowerCase();
    
    if (text.includes(term)) {
        // Simple highlight implementation
        const walker = document.createTreeWalker(
            content,
            NodeFilter.SHOW_TEXT,
            null,
            false
        );
        
        const textNodes = [];
        let node;
        while (node = walker.nextNode()) {
            textNodes.push(node);
        }
        
        textNodes.forEach(textNode => {
            const text = textNode.textContent;
            const lowerText = text.toLowerCase();
            const index = lowerText.indexOf(term);
            
            if (index !== -1) {
                const beforeText = text.substring(0, index);
                const matchText = text.substring(index, index + term.length);
                const afterText = text.substring(index + term.length);
                
                const wrapper = document.createElement('span');
                wrapper.innerHTML = `${beforeText}<mark style="background-color: #fbbf24; padding: 2px 4px; border-radius: 2px;">${matchText}</mark>${afterText}`;
                
                textNode.parentNode.replaceChild(wrapper, textNode);
                
                // Scroll to first match
                if (textNodes.indexOf(textNode) === textNodes.findIndex(n => n.textContent.toLowerCase().includes(term))) {
                    wrapper.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
        
        showNotification(`Found "${searchTerm}" in the privacy policy. Highlighted matches are shown.`);
        
        // Clear highlights after 10 seconds
        setTimeout(() => {
            const highlights = document.querySelectorAll('mark[style*="background-color: #fbbf24"]');
            highlights.forEach(mark => {
                const parent = mark.parentNode;
                parent.textContent = parent.textContent; // This removes the mark and normalizes text
            });
        }, 10000);
    } else {
        showNotification(`"${searchTerm}" not found in the privacy policy.`, 'error');
    }
}
</script>
    
@include('partials.footer')

    <script>
        // Add to Cart functionality
        async function addToCart(productId) {
            try {
                const response = await fetch('{{ route('cart.add') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: 1
                    })
                });

                const data = await response.json();
                
                if (data.success) {
                    showNotification('Product added to cart!', 'success');
                    updateCartCount(data.cart_count);
                } else {
                    showNotification(data.message || 'Failed to add product to cart', 'error');
                }
            } catch (error) {
                showNotification('An error occurred. Please try again.', 'error');
            }
        }

        // Wishlist functionality
        async function toggleWishlist(productId) {
            @guest
                alert('Please login to add items to wishlist');
                return;
            @endguest

            try {
                const response = await fetch('{{ route('customer.wishlist.add') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                });

                const data = await response.json();
                
                if (data.success) {
                    showNotification('Added to wishlist!', 'success');
                } else {
                    showNotification(data.message || 'Failed to add to wishlist', 'error');
                }
            } catch (error) {
                showNotification('An error occurred. Please try again.', 'error');
            }
        }

        // Utility function for notifications
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 rounded-lg px-6 py-3 text-white shadow-lg transition-opacity ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            }`;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => document.body.removeChild(notification), 300);
            }, 3000);
        }

        function updateCartCount(count) {
            const cartCountElements = document.querySelectorAll('[data-cart-count]');
            cartCountElements.forEach(el => {
                el.textContent = count;
            });
        }
    </script>
</body>
</html>