@props([
  'buttonText' => 'Связаться с нами',
  'title' => 'Обратная связь',
  'selectLabel' => 'Тема обращения',
  'selectOptions' => [],
  // unique id suffix in case of multiple buttons per page
  'id' => 'contact-form',
  // pass current page by default
  'page' => request()->path(),
])

@php
  $templateId = 'tpl-'.$id;
@endphp

<button type="button" class="banner-block-button btn-hover-effect cursor-pointer" data-contact-form-open data-template-id="#{{ $templateId }}" data-title="{{ $title }}">
  {{ $buttonText }}
</button>

<script type="text/template" id="{{ $templateId }}">
  <x-contact-form :title="$title" :select-label="$selectLabel" :select-options="$selectOptions" :page="$page" compact="true" />
</script>

