<section class="page-hero main-block">
    <div class="page-hero__inner">
        <div class="page-hero__text">
            @isset($breadcrumbs)
                <div class="page-hero__breadcrumbs">
                    @include('partials.breadcrumbs', ['items' => $breadcrumbs])
                </div>
            @endisset
            @isset($eyebrow)
                <p class="page-hero__eyebrow">{{ $eyebrow }}</p>
            @endisset
            <h1 class="main-h1">{{ $title ?? '' }}</h1>
            @isset($text)
                <p class="page-hero__lead">{{ $text }}</p>
            @endisset
            @isset($slot)
                <div class="page-hero__slot">{!! $slot !!}</div>
            @endisset
        </div>
        <div class="page-hero__media hidden lg:block">
            @if(!empty($image))
                <img class="page-hero__img p-5" src="{{ $image }}" alt="{{ $imageAlt ?? '' }}">
            @else
                <div class="image-slot image-slot--hero" aria-hidden="true">
                    <span>Место для изображения</span>
                </div>
            @endif
        </div>
    </div>
</section>
