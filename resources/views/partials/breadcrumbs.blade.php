@props(['items' => []])

<nav class="text-sm primary-text-color mb-3" aria-label="Хлебные крошки">
  <ol class="flex flex-wrap items-center gap-1">
    @foreach($items as $index => $item)
      @php($isLast = $index === array_key_last($items))
      @if(!empty($item['url']) && !$isLast)
        <li><a href="{{ $item['url'] }}" class="underline hover:no-underline">{{ $item['label'] }}</a></li>
        <li aria-hidden="true" class="primary-text-color">/</li>
      @else
        <li class="text-gray-400">{{ $item['label'] }}</li>
      @endif
    @endforeach
  </ol>
  
</nav>

