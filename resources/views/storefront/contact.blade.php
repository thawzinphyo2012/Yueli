@extends('layouts.storefront')

@section('title', 'Contact — '.($siteName ?? 'Yueli Studio'))

@section('content')
    <section class="border-b border-ink/10">
        <div class="mx-auto max-w-7xl px-5 py-20 lg:px-8 lg:py-28">
            <p class="fade-up section-label">Contact</p>
            <h1 class="fade-up reveal-delay-1 mt-4 font-serif text-5xl text-ink md:text-6xl">Speak with the atelier</h1>
            <p class="fade-up reveal-delay-2 mt-5 max-w-lg font-serif text-xl leading-relaxed text-ink/65">
                Enquiries for fittings, press, and collaborations — we respond with care.
            </p>
        </div>
    </section>

    <section class="mx-auto grid max-w-7xl gap-16 px-5 py-20 lg:grid-cols-2 lg:px-8">
        <div class="fade-up space-y-10">
            <div>
                <p class="section-label mb-4">Studio</p>
                <ul class="space-y-5 text-ink/75">
                    <li class="flex items-start gap-4">
                        <i data-lucide="mail" class="mt-1 h-4 w-4 text-champagne"></i>
                        <div>
                            <p class="text-[11px] uppercase tracking-[0.2em] text-ink/40">Email</p>
                            <a href="mailto:studio@yueli.studio" class="mt-1 block font-serif text-xl hover:text-petrol">studio@yueli.studio</a>
                        </div>
                    </li>
                    <li class="flex items-start gap-4">
                        <i data-lucide="phone" class="mt-1 h-4 w-4 text-champagne"></i>
                        <div>
                            <p class="text-[11px] uppercase tracking-[0.2em] text-ink/40">Phone</p>
                            <p class="mt-1 font-serif text-xl">+1 (000) 000-0000</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-4">
                        <i data-lucide="map-pin" class="mt-1 h-4 w-4 text-champagne"></i>
                        <div>
                            <p class="text-[11px] uppercase tracking-[0.2em] text-ink/40">Location</p>
                            <p class="mt-1 font-serif text-xl">By appointment · Global atelier</p>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="border-t border-ink/10 pt-8">
                <p class="font-serif text-lg italic text-ink/55">
                    {{ $siteName ?? 'Yueli Studio' }} — {{ $siteTagline ?? 'Editorial clothing for modern quiet luxury.' }}
                </p>
            </div>
        </div>

        <div class="reveal reveal-delay-1">
            <form
                action="mailto:studio@yueli.studio"
                method="get"
                enctype="text/plain"
                class="space-y-8"
                x-data="{
                    name: '',
                    email: '',
                    subject: '',
                    message: '',
                    submit() {
                        const body = [
                            'Name: ' + this.name,
                            'Email: ' + this.email,
                            '',
                            this.message
                        ].join(String.fromCharCode(10));
                        window.location.href = 'mailto:studio@yueli.studio?subject=' + encodeURIComponent(this.subject || 'Atelier enquiry') + '&body=' + encodeURIComponent(body);
                    }
                }"
                @submit.prevent="submit"
            >
                <div>
                    <label for="name" class="mb-2 block text-[11px] uppercase tracking-[0.2em] text-ink/50">Name</label>
                    <input id="name" type="text" x-model="name" required class="input-field" placeholder="Your name">
                </div>
                <div>
                    <label for="email" class="mb-2 block text-[11px] uppercase tracking-[0.2em] text-ink/50">Email</label>
                    <input id="email" type="email" x-model="email" required class="input-field" placeholder="you@example.com">
                </div>
                <div>
                    <label for="subject" class="mb-2 block text-[11px] uppercase tracking-[0.2em] text-ink/50">Subject</label>
                    <input id="subject" type="text" x-model="subject" class="input-field" placeholder="Fitting, press, collaboration…">
                </div>
                <div>
                    <label for="message" class="mb-2 block text-[11px] uppercase tracking-[0.2em] text-ink/50">Message</label>
                    <textarea id="message" x-model="message" required rows="5" class="input-field resize-y" placeholder="Tell us a little about your enquiry"></textarea>
                </div>
                <button type="submit" class="btn-primary">
                    Send message
                    <i data-lucide="send" class="h-3.5 w-3.5"></i>
                </button>
            </form>
        </div>
    </section>
@endsection
