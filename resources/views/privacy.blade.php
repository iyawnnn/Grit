<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Privacy Policy | Grit</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900 antialiased selection:bg-[#e26a35] selection:text-white font-sans">

    <x-header />

    <div class="bg-white border-b border-gray-200 pt-32 pb-12 sm:pt-40 sm:pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <h1 class="text-4xl sm:text-5xl font-black text-gray-900 tracking-tight mb-4">Privacy Policy</h1>
            <p class="text-lg text-gray-500 font-medium">Effective Date: April 2026</p>
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 py-12 sm:py-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20">
            
            <aside class="hidden lg:block lg:col-span-3">
                <nav class="sticky top-32 flex flex-col gap-3 text-sm font-bold tracking-wide text-gray-500 uppercase">
                    <a href="#overview" class="hover:text-[#e26a35] transition-colors">1. Overview</a>
                    <a href="#data-collection" class="hover:text-[#e26a35] transition-colors">2. Data We Collect</a>
                    <a href="#third-party" class="hover:text-[#e26a35] transition-colors">3. Third-Party Infrastructure</a>
                    <a href="#ai-processing" class="hover:text-[#e26a35] transition-colors">4. AI Data Processing</a>
                    <a href="#security" class="hover:text-[#e26a35] transition-colors">5. Data Security</a>
                    <a href="#contact" class="hover:text-[#e26a35] transition-colors">6. Contact</a>
                </nav>
            </aside>

            <article class="lg:col-span-9 space-y-16 text-lg text-gray-600 font-medium leading-relaxed">
                
                <section id="overview" class="scroll-mt-32">
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-6">1. Overview</h2>
                    <p>Welcome to Grit. We believe in absolute transparency regarding your data. Grit is an independent software project developed to assist users in tracking job applications and preparing for interviews. This Privacy Policy details how your personal information is collected, processed, and routed through our infrastructure.</p>
                </section>

                <section id="data-collection" class="scroll-mt-32">
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-6">2. Data We Collect</h2>
                    <p class="mb-4">We collect only the data necessary to make the platform function:</p>
                    <ul class="list-none space-y-4">
                        <li class="flex gap-4">
                            <span class="text-[#e26a35] font-black">•</span>
                            <div><strong>Account Data:</strong> When you authenticate via Google, we store your name, email address, and avatar URL to maintain your session securely.</div>
                        </li>
                        <li class="flex gap-4">
                            <span class="text-[#e26a35] font-black">•</span>
                            <div><strong>Application Data:</strong> Information you input regarding job postings, company names, and application statuses.</div>
                        </li>
                        <li class="flex gap-4">
                            <span class="text-[#e26a35] font-black">•</span>
                            <div><strong>Resume Files:</strong> Documents (PDFs or Word files) you explicitly upload for parsing and matching.</div>
                        </li>
                    </ul>
                </section>

                <section id="third-party" class="scroll-mt-32">
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-6">3. Third-Party Infrastructure</h2>
                    <p class="mb-4">Grit is powered by industry-leading cloud providers. By using our service, you acknowledge that your data is securely transmitted to and stored by the following infrastructure partners:</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                            <h3 class="font-bold text-gray-900 mb-2">Neon (Database)</h3>
                            <p class="text-base">All structured data (user profiles, job application history, text data) is securely encrypted at rest and stored in Neon's serverless PostgreSQL environment.</p>
                        </div>
                        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                            <h3 class="font-bold text-gray-900 mb-2">Cloudinary (Media Storage)</h3>
                            <p class="text-base">Uploaded files, such as your resume documents and profile images, are hosted and processed via Cloudinary's secure content delivery network.</p>
                        </div>
                        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm md:col-span-2">
                            <h3 class="font-bold text-gray-900 mb-2">Render (Hosting)</h3>
                            <p class="text-base">The Grit application itself is hosted on Render. All web traffic and API requests are routed securely through their cloud infrastructure.</p>
                        </div>
                    </div>
                </section>

                <section id="ai-processing" class="scroll-mt-32">
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-6">4. AI Data Processing (Groq)</h2>
                    <p class="mb-4">Grit utilizes <strong>Groq</strong> to provide ultra-fast AI inference for resume parsing, job matching, and mock interviews. When you trigger these features, we transmit the relevant text (e.g., your resume content and the job description) to Groq's API.</p>
                    <div class="bg-[#FBF6F1] border-l-4 border-[#e26a35] p-6 rounded-r-2xl mt-6 text-gray-800">
                        <strong>Privacy Commitment:</strong> Data sent to Groq is strictly used for momentary processing to return your results. We do not permit Groq or any other AI provider to use your personal resumes or job data to train their public or private models.
                    </div>
                </section>

                <section id="security" class="scroll-mt-32">
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-6">5. Data Security</h2>
                    <p>While we use enterprise-grade partners (Neon, Render, Cloudinary) to ensure standard encryption and security practices, Grit is an independent software project. We cannot guarantee absolute security against highly sophisticated attacks. We strongly advise users <strong>not to upload highly sensitive documents</strong> containing financial information, government IDs, or sensitive health data.</p>
                </section>

                <section id="contact" class="scroll-mt-32">
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-6">6. Data Deletion & Contact</h2>
                    <p>You own your data. You may delete your account and all associated data at any time via your profile settings. If you have any concerns regarding how your data is handled, please reach out to the developer directly.</p>
                </section>

            </article>
        </div>
    </main>

    <x-footer />

</body>
</html>