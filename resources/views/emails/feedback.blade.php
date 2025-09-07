<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>{{ $subject ?? 'Сообщение с сайта' }}</title>
    <style>
        body { font-family: -apple-system, Segoe UI, Roboto, Arial, sans-serif; }
        .box { max-width: 640px; margin: 0 auto; padding: 16px; }
        .row { margin-bottom: 8px; }
        .label { color: #555; width: 140px; display: inline-block; }
        .val { color: #111; }
        .msg { white-space: pre-wrap; background:#fafafa; border:1px solid #eee; padding:12px; border-radius:8px; }
    </style>
  </head>
  <body>
    <div class="box">
        <h2 style="margin:0 0 16px;">Новое сообщение с формы обратной связи</h2>

        <div class="row"><span class="label">ФИО:</span> <span class="val">{{ $fullName ?: '—' }}</span></div>
        <div class="row"><span class="label">Телефон:</span> <span class="val">{{ $phone ?: '—' }}</span></div>
        <div class="row"><span class="label">Email:</span> <span class="val">{{ $email ?: '—' }}</span></div>
        <div class="row"><span class="label">Тема:</span> <span class="val">{{ $subject ?: '—' }}</span></div>
        @if(!empty($page))
            <div class="row"><span class="label">Страница:</span> <span class="val">{{ $page }}</span></div>
        @endif

        <h3 style="margin:16px 0 8px;">Сообщение</h3>
        <div class="msg">{{ $text }}</div>

        <p style="margin-top:16px; color:#666;">Если были приложены файлы, они добавлены к письму вложениями.</p>
    </div>
  </body>
</html>

