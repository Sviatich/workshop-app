@extends('layouts.app')

@section('content')
    <div role="main" aria-labelledby="error-title">
        <div class="main-block">
            <div class="page-404-block">
                <div class="flex flex-col justify-center items-center text-center">
                    <img width="230px" src="{{ Vite::asset('resources/images/403.webp') }}" class="image-on-404 mt-2"
                        alt="403 Error">
                    <h1 class="text-2xl font-semibold">Ой! Доступ ограничен</h1>
                    <p class="mb-8">Вы не можете просматривать эту страницу.<br>Код ошибки: 403</p>
                </div>
                <section role="region" aria-labelledby="questions-title" class="text-center">
                    <div class="mt-4">
                        <x-contact-form-button button-text="Сообщить об ошибке" title="Что-то сломалось?"
                            select-label="Тема обращения" :select-options="['Страница недоступна', 'Другое']" />
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection