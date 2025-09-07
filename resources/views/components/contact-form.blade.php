@props([
    'title' => 'Обратная связь',
    'selectLabel' => 'Тема обращения',
    // Array of options. Accepts [value => label] or ['Label 1', 'Label 2']
    'selectOptions' => [],
    // Hidden context, e.g., page or source
    'page' => request()->path(),
    // Render compact form (for modal)
    'compact' => false,
])

@php
    $normalizedOptions = [];
    foreach ($selectOptions as $k => $v) {
        if (is_int($k)) { $normalizedOptions[$v] = $v; } else { $normalizedOptions[$k] = $v; }
    }
@endphp

<form action="{{ route('feedback.send') }}" method="post" enctype="multipart/form-data" data-contact-form>
  @csrf
  @honeypot

  {{-- @if(!empty($title))
    <h3 class="text-xl font-semibold mb-4">{{ $title }}</h3>
  @endif --}}

  <input type="hidden" name="page" value="{{ $page }}">

  <div class="grid gap-3" style="grid-template-columns: 1fr 1fr;">
    <label class="block col-span-2 sm:col-span-1">
      <span class="block text mb-1 font-semibold">ФИО</span>
      <input id="feedback_form-full_name" type="text" name="full_name" required class="w-full border rounded px-3 py-2" placeholder="Иванов Иван Иванович">
    </label>

    <label class="block col-span-2 sm:col-span-1">
      <span class="block text mb-1 font-semibold">Телефон</span>
      <input id="feedback_form-phone" type="tel" name="phone" class="w-full border rounded px-3 py-2" placeholder="+7 (___) ___-__-__">
    </label>
  </div>

  <label class="block mt-3">
    <span class="block text mb-1 font-semibold">Email</span>
    <input id="feedback_form-email" type="email" name="email" required class="w-full border rounded px-3 py-2" placeholder="you@example.com">
  </label>

  @if(count($normalizedOptions))
    <label class="block mt-3">
      <span class="block text mb-1 font-semibold">{{ $selectLabel }}</span>
      <select id="feedback_form-select" name="topic" class="w-full border rounded px-3 py-2">
        <option value="">— Выберите —</option>
        @foreach($normalizedOptions as $value => $label)
          <option value="{{ $value }}">{{ $label }}</option>
        @endforeach
      </select>
    </label>
  @endif

  <label class="block mt-3">
    <span class="block text mb-1 font-semibold">Сообщение</span>
    <textarea id="feedback_form-textarea" name="message" required rows="4" class="w-full border rounded px-3 py-2" placeholder="Опишите ваш вопрос"></textarea>
  </label>

  <label class="block mt-3">
    <span class="block text mb-1 font-semibold">Вложение</span>
    <input id="feedback_form-file" type="file" name="attachment" class="border rounded px-3 py-2" accept=".png,.jpg,.jpeg,.pdf,.doc,.docx,.xls,.xlsx,.zip">
  </label>

  <div class="mt-4 flex items-center gap-3">
    <button type="submit" class="add-to-cart-button btn-hover-effect cursor-pointer" style="width:auto;">Отправить</button>
    <span class="text-sm main-gray-color" data-contact-form-status></span>
  </div>

  <p class="text-xs main-gray-color mt-2">Нажимая «Отправить», вы соглашаетесь с обработкой персональных данных согласно нашей <a href="{{ route('legal.privacy') }}" class="underline">политике конфиденциальности</a>.</p>
</form>

