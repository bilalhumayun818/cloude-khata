<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'Purpose-built software that makes complex business operations simple.')">
    <title>@yield('title', 'BroshTech Software')</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/software-catalog.css') }}?v={{ filemtime(public_path('css/software-catalog.css')) }}">
</head>
<body class="@yield('body_class')">
    <header class="site-header" id="site-header">
        <div class="shell nav-wrap">
            <a class="brand" href="{{ route('software.index') }}" aria-label="BroshTech software home">
                <span class="brand-mark" aria-hidden="true">
                    <svg viewBox="0 0 32 32"><path d="M8.5 9.5 16 5l7.5 4.5v4L16 18l-7.5-4.5v-4Z"/><path d="M8.5 18.5 16 23l7.5-4.5M8.5 14v8.5L16 27l7.5-4.5V14"/></svg>
                </span>
                <span>Brosh<span>Tech</span></span>
            </a>

            <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="site-nav" aria-label="Open navigation">
                <span></span><span></span><span></span>
            </button>

            <nav class="site-nav" id="site-nav" aria-label="Main navigation">
                <a href="{{ route('software.index') }}#solutions">Solutions</a>
                <a href="{{ route('software.index') }}#why-us">Why us</a>
                <a href="{{ route('software.index') }}#contact">Contact</a>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="site-footer" id="contact">
        <div class="shell">
            <div class="footer-callout">
                <div>
                    <span>Let’s work together</span>
                    <h2>Better operations start with the right tools.</h2>
                </div>
                <button class="footer-cta" type="button" data-buy-product="a BroshTech solution">
                    Talk to our team <span aria-hidden="true">→</span>
                </button>
            </div>

            <div class="footer-grid">
                <div class="footer-about">
                <a class="brand brand-light" href="{{ route('software.index') }}">
                    <span class="brand-mark" aria-hidden="true">
                        <svg viewBox="0 0 32 32"><path d="M8.5 9.5 16 5l7.5 4.5v4L16 18l-7.5-4.5v-4Z"/><path d="M8.5 18.5 16 23l7.5-4.5M8.5 14v8.5L16 27l7.5-4.5V14"/></svg>
                    </span>
                    <span>Brosh<span>Tech</span></span>
                </a>
                    <p>Practical software built around how your business actually works.</p>
                </div>

                <div class="footer-links">
                    <span>Our solutions</span>
                    <div class="footer-solution-links">
                        @foreach(config('software.products') as $footerSlug => $footerProduct)
                            <a href="{{ route('software.show', $footerSlug) }}">{{ $footerProduct['name'] }} <i aria-hidden="true">↗</i></a>
                        @endforeach
                    </div>
                </div>

                <div class="footer-contact">
                    <span class="footer-label">Contact sales</span>
                    <a href="mailto:{{ config('software.sales_email') }}">
                        <span class="footer-contact-icon" aria-hidden="true">@</span>
                        <span><small>Email</small><strong>{{ config('software.sales_email') }}</strong></span>
                    </a>
                    <a href="tel:{{ preg_replace('/[^+0-9]/', '', config('software.sales_phone')) }}">
                        <span class="footer-contact-icon" aria-hidden="true">☎</span>
                        <span><small>Call or WhatsApp</small><strong>{{ config('software.sales_phone') }}</strong></span>
                    </a>
                </div>
            </div>

            <div class="footer-bottom">
                <span>&copy; {{ date('Y') }} BroshTech. All rights reserved.</span>
                <a href="{{ route('software.index') }}" aria-label="Back to homepage">Back to top <span aria-hidden="true">↑</span></a>
            </div>
        </div>
    </footer>

    <div class="contact-modal" id="contact-modal" aria-hidden="true">
        <div class="modal-backdrop" data-close-modal></div>
        <section class="modal-card" role="dialog" aria-modal="true" aria-labelledby="contact-title">
            <button class="modal-close" type="button" data-close-modal aria-label="Close contact dialog">×</button>
            <span class="section-kicker">Let’s get you started</span>
            <h2 id="contact-title">Buy <span data-product-name>our software</span></h2>
            <p>Contact our sales team and we’ll help with pricing, setup and the right package for your business.</p>
            <div class="contact-options">
                <a class="contact-option" data-email-link href="mailto:{{ config('software.sales_email') }}">
                    <span class="contact-icon">@</span>
                    <span><small>Email us</small><strong>{{ config('software.sales_email') }}</strong></span>
                    <b aria-hidden="true">→</b>
                </a>
                <a class="contact-option" href="tel:{{ preg_replace('/[^+0-9]/', '', config('software.sales_phone')) }}">
                    <span class="contact-icon">☎</span>
                    <span><small>Call or WhatsApp</small><strong>{{ config('software.sales_phone') }}</strong></span>
                    <b aria-hidden="true">→</b>
                </a>
            </div>
            <p class="modal-note">Our team will respond as soon as possible during business hours.</p>
        </section>
    </div>

    <script>
        (function () {
            var header = document.getElementById('site-header');
            var toggle = document.querySelector('.nav-toggle');
            var nav = document.getElementById('site-nav');
            var modal = document.getElementById('contact-modal');
            var lastTrigger;

            window.addEventListener('scroll', function () {
                header.classList.toggle('scrolled', window.scrollY > 16);
            }, { passive: true });

            toggle.addEventListener('click', function () {
                var isOpen = toggle.getAttribute('aria-expanded') === 'true';
                toggle.setAttribute('aria-expanded', String(!isOpen));
                nav.classList.toggle('open', !isOpen);
            });

            nav.querySelectorAll('a').forEach(function (link) {
                link.addEventListener('click', function () {
                    toggle.setAttribute('aria-expanded', 'false');
                    nav.classList.remove('open');
                });
            });

            function closeModal() {
                modal.classList.remove('open');
                modal.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('modal-open');
                if (lastTrigger) lastTrigger.focus();
            }

            document.querySelectorAll('[data-buy-product]').forEach(function (button) {
                button.addEventListener('click', function () {
                    lastTrigger = button;
                    var product = button.getAttribute('data-buy-product');
                    modal.querySelector('[data-product-name]').textContent = product;
                    var email = modal.querySelector('[data-email-link]');
                    email.href = 'mailto:{{ config('software.sales_email') }}?subject=' + encodeURIComponent('I am interested in ' + product);
                    modal.classList.add('open');
                    modal.setAttribute('aria-hidden', 'false');
                    document.body.classList.add('modal-open');
                    modal.querySelector('.modal-close').focus();
                });
            });

            modal.querySelectorAll('[data-close-modal]').forEach(function (button) {
                button.addEventListener('click', closeModal);
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && modal.classList.contains('open')) closeModal();
            });
        }());
    </script>
</body>
</html>
