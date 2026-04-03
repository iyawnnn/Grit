<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Terms of Service | Grit</title>

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
            <h1 class="text-4xl sm:text-5xl font-black text-gray-900 tracking-tight mb-4">Terms of Service</h1>
            <p class="text-lg text-gray-500 font-medium">Effective Date: April 2026</p>
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 py-12 sm:py-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20">
            
            <aside class="hidden lg:block lg:col-span-3">
                <nav class="sticky top-32 flex flex-col gap-3 text-sm font-bold tracking-wide text-gray-500 uppercase">
                    <a href="#acceptance" class="hover:text-[#e26a35] transition-colors">1. Acceptance</a>
                    <a href="#usage" class="hover:text-[#e26a35] transition-colors">2. Acceptable Use</a>
                    <a href="#ai-disclaimer" class="hover:text-[#e26a35] transition-colors">3. AI Limitations</a>
                    <a href="#warranty" class="hover:text-[#e26a35] transition-colors">4. Disclaimer of Warranty</a>
                    <a href="#liability" class="hover:text-[#e26a35] transition-colors">5. Limitation of Liability</a>
                    <a href="#termination" class="hover:text-[#e26a35] transition-colors">6. Termination</a>
                </nav>
            </aside>

            <article class="lg:col-span-9 space-y-16 text-lg text-gray-600 font-medium leading-relaxed">
                
                <section id="acceptance" class="scroll-mt-32">
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-6">1. Acceptance of Terms</h2>
                    <p>By accessing or using the Grit platform, you agree to be bound by these Terms of Service. Grit is an independent software project created for portfolio and utility purposes. If you do not agree to these terms, you must immediately cease use of the platform.</p>
                </section>

                <section id="usage" class="scroll-mt-32">
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-6">2. Acceptable Use</h2>
                    <p class="mb-4">You are granted a limited, non-exclusive license to use Grit for personal job tracking and interview preparation. You agree NOT to:</p>
                    <ul class="list-none space-y-4">
                        <li class="flex gap-4">
                            <span class="text-[#e26a35] font-black">•</span>
                            <div>Upload malicious code, viruses, or illegal materials to our Cloudinary storage.</div>
                        </li>
                        <li class="flex gap-4">
                            <span class="text-[#e26a35] font-black">•</span>
                            <div>Attempt to reverse-engineer, scrape, or overwhelm our Groq AI integrations or Render hosting infrastructure.</div>
                        </li>
                        <li class="flex gap-4">
                            <span class="text-[#e26a35] font-black">•</span>
                            <div>Use the service to store sensitive PII (Personally Identifiable Information) beyond what is required for a standard resume.</div>
                        </li>
                    </ul>
                </section>

                <section id="ai-disclaimer" class="scroll-mt-32">
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-6">3. AI Output Limitations</h2>
                    <p>Grit uses Artificial Intelligence (Groq) to provide resume matching and interview feedback. You acknowledge that AI-generated content is probabilistic and may occasionally produce inaccurate, biased, or nonsensical output. <strong>Grit does not provide professional career advice, HR consulting, or legal advice.</strong> You should independently verify any feedback provided by our AI systems.</p>
                </section>

                <section id="warranty" class="scroll-mt-32">
                    <h2 class="text-3xl font-extrabold text-[#e26a35] mb-6 uppercase tracking-wider">4. Disclaimer of Warranties</h2>
                    <div class="bg-gray-100 p-8 rounded-2xl border border-gray-200">
                        <p class="text-gray-900 font-bold uppercase tracking-wide leading-loose">
                            Grit is provided on an "AS IS" and "AS AVAILABLE" basis. As an independent developer project, we make no representations or warranties of any kind, express or implied, regarding the operation of the service, system uptime, data retention, or the accuracy of the information provided. We reserve the right to modify, suspend, or completely shut down the service at any time without prior notice or liability.
                        </p>
                    </div>
                </section>

                <section id="liability" class="scroll-mt-32">
                    <h2 class="text-3xl font-extrabold text-[#e26a35] mb-6 uppercase tracking-wider">5. Limitation of Liability</h2>
                    <div class="bg-gray-100 p-8 rounded-2xl border border-gray-200">
                        <p class="text-gray-900 font-bold uppercase tracking-wide leading-loose">
                            To the absolute maximum extent permitted by law, in no event shall the developer or creator of Grit be liable for any direct, indirect, incidental, special, consequential, or punitive damages. This includes, but is not limited to, loss of data, loss of career opportunities, missed job offers, or any other intangible losses resulting from your access to or inability to access the platform, or any AI-generated feedback provided by the platform.
                        </p>
                    </div>
                </section>

                <section id="termination" class="scroll-mt-32">
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-6">6. Termination</h2>
                    <p>We reserve the right to suspend or terminate your account and access to the service at our sole discretion, without prior notice, for conduct that we believe violates these Terms of Service or is harmful to other users, us, or third parties.</p>
                </section>

            </article>
        </div>
    </main>

    <x-footer />

</body>
</html>