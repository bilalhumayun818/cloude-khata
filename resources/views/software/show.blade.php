@extends('layouts.software')

@section('title', $product['name'] . ' — ' . $product['eyebrow'])
@section('meta_description', $product['description'])
@section('body_class', 'product-page')

@section('content')
    <section class="product-hero" style="--accent: {{ $product['color'] }}; --soft: {{ $product['soft_color'] }}; --secondary: {{ $product['secondary_color'] }}; --accent-text: {{ $product['accent_text'] }}">
        <div class="product-hero-pattern"></div>
        <div class="shell">
            <a class="back-link" href="{{ route('software.index') }}#solutions"><span>←</span> All solutions</a>
            <div class="product-hero-grid">
                <div class="product-hero-copy">
                    <div class="product-title-row"><div class="product-icon product-icon-large">@include('software._icon', ['icon' => $product['icon']])</div><span>{{ $product['eyebrow'] }}</span></div>
                    <h1>{{ $product['name'] }}</h1>
                    <h2>{{ $product['tagline'] }}</h2>
                    <p>{{ $product['description'] }}</p>
                    <div class="product-actions">
                        @if($product['demo_url'])
                            <a class="button button-accent" href="{{ $product['demo_url'] }}" target="_blank" rel="noopener noreferrer">Open live demo <span>↗</span></a>
                        @else
                            <button class="button button-muted" type="button" disabled title="Demo coming soon">Demo coming soon</button>
                        @endif
                        <button class="button button-outline" type="button" data-buy-product="{{ $product['name'] }}">Buy now <span>→</span></button>
                    </div>
                </div>
                <div class="product-showcase">
                    <div class="showcase-window">
                        <div class="showcase-bar"><i></i><i></i><i></i><span>{{ strtolower(str_replace(' ', '-', $product['name'])) }}.app</span></div>
                        <div class="showcase-body"><aside><b></b><i></i><i></i><i></i><i></i><i></i></aside><div class="showcase-content"><div class="showcase-heading"><span></span><small></small></div><div class="showcase-stats"><i></i><i></i><i></i></div><div class="showcase-chart"><span></span><span></span><span></span><span></span><span></span><span></span><span></span></div><div class="showcase-table"><i></i><i></i><i></i></div></div></div>
                    </div>
                    <div class="showcase-badge"><span>✓</span><strong>All in one place</strong><small>Simple. Connected. Reliable.</small></div>
                </div>
            </div>
        </div>
    </section>

    <section class="feature-section">
        <div class="shell">
            <div class="feature-intro"><span class="section-kicker">Everything you need</span><h2>More control.<br><em>Less busywork.</em></h2><p>Core tools designed to keep your team aligned and your operation moving.</p></div>
            <div class="feature-grid">
                @foreach($product['features'] as $feature)
                    <article><span class="feature-check">✓</span><h3>{{ $feature['title'] }}</h3><p>{{ $feature['description'] }}</p></article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="product-cta" style="--accent: {{ $product['color'] }}; --secondary: {{ $product['secondary_color'] }}; --accent-text: {{ $product['accent_text'] }}">
        <div class="shell">
            <div><span>Bring better operations within reach.</span><h2>Ready to get started with {{ $product['name'] }}?</h2></div>
            <div class="product-cta-actions">
                @if($product['demo_url'])<a class="button button-white-outline" href="{{ $product['demo_url'] }}" target="_blank" rel="noopener noreferrer">Try the demo <span>↗</span></a>@endif
                <button class="button button-white" type="button" data-buy-product="{{ $product['name'] }}">Contact sales <span>→</span></button>
            </div>
        </div>
    </section>

    <section class="more-products">
        <div class="shell">
            <div class="more-heading"><div><span class="section-kicker">Keep exploring</span><h2>More from BroshTech</h2></div><a href="{{ route('software.index') }}#solutions">View all six <span>→</span></a></div>
            <div class="more-grid">
                @foreach(collect($products)->except($slug)->take(3) as $otherSlug => $other)
                    <a class="more-card" href="{{ route('software.show', $otherSlug) }}" style="--accent: {{ $other['color'] }}; --soft: {{ $other['soft_color'] }}; --secondary: {{ $other['secondary_color'] }}; --accent-text: {{ $other['accent_text'] }}"><span class="product-icon">@include('software._icon', ['icon' => $other['icon']])</span><span><small>{{ $other['eyebrow'] }}</small><strong>{{ $other['name'] }}</strong></span><b>↗</b></a>
                @endforeach
            </div>
        </div>
    </section>
@endsection
