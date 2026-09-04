@extends('layouts.software')

@section('title', 'BroshTech — Software built for real business')
@section('meta_description', 'Explore six purpose-built management systems for retail, salons, couriers, distribution, restaurants and paddle clubs.')

@section('content')
    <section class="hero">
        <div class="hero-orb orb-one"></div>
        <div class="hero-orb orb-two"></div>
        <div class="shell hero-grid">
            <div class="hero-copy">
                <div class="hero-kicker"><span></span> Business software, made practical</div>
                <h1>Built to run the<br><em>way you work.</em></h1>
                <p>Six focused management systems. One clear goal: less operational friction and more control over your business.</p>
                <div class="hero-actions">
                    <a class="button button-primary" href="#solutions">Explore our solutions <span>↓</span></a>
                    <button class="text-link" type="button" data-buy-product="a BroshTech solution">Talk to our team <span>→</span></button>
                </div>
                <div class="hero-proof">
                    <div class="proof-avatars"><span>CK</span><span>VE</span><span>RMS</span></div>
                    <p><strong>Made for your workflow</strong><br>Flexible, secure and ready to grow.</p>
                </div>
            </div>

            <div class="hero-visual" aria-label="Business software dashboard preview">
                <div class="visual-glow"></div>
                <div class="dashboard-card">
                    <div class="dashboard-top"><span class="mini-brand"><i></i> BroshTech</span><span class="dashboard-dots">•••</span></div>
                    <div class="dashboard-body">
                        <aside class="dashboard-side"><span class="active"></span><span></span><span></span><span></span><span></span></aside>
                        <div class="dashboard-main">
                            <div class="dash-title"><span></span><small></small></div>
                            <div class="metric-row">
                                <div><i class="violet"></i><b>24.8K</b><small>Revenue</small></div>
                                <div><i class="orange"></i><b>1,284</b><small>Orders</small></div>
                                <div><i class="green"></i><b>94.2%</b><small>Complete</small></div>
                            </div>
                            <div class="chart-card"><span>Business overview</span><div class="chart-bars"><i style="height:30%"></i><i style="height:48%"></i><i style="height:40%"></i><i style="height:72%"></i><i style="height:58%"></i><i style="height:84%"></i><i style="height:68%"></i><i style="height:96%"></i></div></div>
                        </div>
                    </div>
                </div>
                <div class="float-card float-orders"><span>✓</span><p><small>Orders today</small><strong>+18.4%</strong></p></div>
                <div class="float-card float-live"><i></i><p><small>All systems</small><strong>Running smoothly</strong></p></div>
            </div>
        </div>
    </section>

    <section class="solutions" id="solutions">
        <div class="shell">
            <div class="section-heading">
                <div><span class="section-kicker">Our software suite</span><h2>One challenge.<br><em>One focused solution.</em></h2></div>
                <p>Purpose-built tools that fit your industry—without the bloat, complexity or steep learning curve.</p>
            </div>
            <div class="product-grid">
                @foreach($products as $slug => $product)
                    <article class="product-card" style="--accent: {{ $product['color'] }}; --soft: {{ $product['soft_color'] }}; --secondary: {{ $product['secondary_color'] }}; --accent-text: {{ $product['accent_text'] }}">
                        <div class="product-icon">@include('software._icon', ['icon' => $product['icon']])</div>
                        <span class="product-number">0{{ $loop->iteration }}</span>
                        <div class="product-card-copy"><small>{{ $product['eyebrow'] }}</small><h3>{{ $product['name'] }}</h3><p>{{ $product['tagline'] }}</p></div>
                        <a href="{{ route('software.show', $slug) }}" aria-label="Explore {{ $product['name'] }}">Explore solution <span>↗</span></a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="why-us" id="why-us">
        <div class="shell why-grid">
            <div class="why-copy">
                <span class="section-kicker section-kicker-light">Why BroshTech</span>
                <h2>Technology should make business feel <em>simpler.</em></h2>
                <p>We begin with the daily realities of your operation, then build software around them. The result is technology your team can understand, adopt and depend on.</p>
                <button class="button button-light" type="button" data-buy-product="a BroshTech solution">Start a conversation <span>→</span></button>
            </div>
            <div class="why-list">
                <div><span>01</span><h3>Built for your industry</h3><p>Workflows and features shaped around real operational needs.</p></div>
                <div><span>02</span><h3>Ready to scale</h3><p>Solid foundations that grow alongside your team and locations.</p></div>
                <div><span>03</span><h3>Support that listens</h3><p>Helpful people who understand both the product and your business.</p></div>
            </div>
        </div>
    </section>

    <section class="cta-band">
        <div class="shell cta-inner">
            <div><span class="section-kicker">Ready when you are</span><h2>Let’s build a better way to work.</h2></div>
            <button class="button button-dark" type="button" data-buy-product="a BroshTech solution">Talk to sales <span>→</span></button>
        </div>
    </section>
@endsection
