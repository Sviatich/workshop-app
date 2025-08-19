<article 
  class="main-block overflow-hidden"
  role="region"
  aria-labelledby="home-feature-title"
  aria-describedby="home-feature-subtitle"
>
  <div class="grid grid-cols-1 md:grid-cols-2">

    {{-- Левая часть: иконка + текст --}}
    <div class="items-start gap-4">
      {{-- Иконка (декоративная) --}}
      <img
        src="{{ Vite::asset('resources/images/ui/box-icon.svg') }}"
        alt=""
        aria-hidden="true"
        class="w-12 h-12 shrink-0"
      />

      <div>
        <h2 id="home-feature-title" class="text-2xl font-bold text-gray-900">
          Нужен макет дизайна?
        </h2>
        <p id="home-feature-subtitle" class="mt-2 text-gray-600">
          Просто отправьте нам размеры и пожелания, и мы создадим уникальный дизайн, который подчеркнет ваш бренд.
        </p>
      </div>
    </div>

    {{-- Правая часть: изображение/илллюстрация --}}
    <figure class="relative bg-gray-50">
      <img
        src="{{ Vite::asset('resources/images/hero/preview.png') }}"
        alt="Пример собранной коробки с нанесённым логотипом"
        class="w-full h-full object-cover md:object-contain aspect-[4/3] md:aspect-auto"
      />
      {{-- Если нужна подпись к изображению, раскомментируй: --}}
      {{-- <figcaption class="sr-only">Визуальный пример конфигурации коробки</figcaption> --}}
    </figure>

  </div>
</article>
