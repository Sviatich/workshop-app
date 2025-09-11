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
            @php(
                $hasVideo = !empty($video ?? null) || !empty($videoMp4 ?? null) || !empty($videoWebm ?? null)
            )
            @if($hasVideo)
                <video
                    class="page-hero__video p-5"
                    @if(($videoAutoplay ?? true)) autoplay @endif
                    @if(($videoMuted ?? true)) muted @endif
                    @if(($videoLoop ?? true)) loop @endif
                    playsinline
                    @if(!empty(($poster ?? null) ?: ($image ?? null))) poster="{{ ($poster ?? null) ?: ($image ?? null) }}" @endif
                    @if(!empty($videoAlt ?? $imageAlt ?? null)) aria-label="{{ $videoAlt ?? $imageAlt ?? '' }}" @endif
                >
                    @if(!empty($videoMp4 ?? null))
                        <source src="{{ $videoMp4 }}" type="video/mp4">
                    @endif
                    @if(!empty($videoWebm ?? null))
                        <source src="{{ $videoWebm }}" type="video/webm">
                    @endif
                    @if(!empty($video ?? null))
                        <source src="{{ $video }}">
                    @endif
                    Your browser does not support the video tag.
                </video>
            @elseif(!empty($image))
                <img class="page-hero__img p-5" src="{{ $image }}" alt="{{ $imageAlt ?? '' }}">
            @else
                <div class="image-slot image-slot--hero" aria-hidden="true"></div>
            @endif
        </div>
    </div>
</section>

