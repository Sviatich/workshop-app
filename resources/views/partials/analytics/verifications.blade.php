{{-- Мета-теги для подтверждения прав на сайт в поисковых системах --}}
@if ($g = config('services.verification.google'))
  <meta name="google-site-verification" content="{{ $g }}">
@endif
@if ($y = config('services.verification.yandex'))
  <meta name="yandex-verification" content="{{ $y }}">
@endif