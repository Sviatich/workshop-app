<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $heading ?? 'Уведомление' }}</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; color:#111827; margin:0; padding:0; background:#f9fafb; }
        .container { max-width: 600px; margin: 0 auto; padding: 24px 16px; }
        .card { background:#ffffff; border:1px solid #e5e7eb; border-radius:12px; padding: 20px; }
        .h1 { font-size: 20px; font-weight: 700; margin: 0 0 12px; }
        .muted { color:#6b7280; }
        .row { display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #f3f4f6; }
        .row:last-child { border-bottom:none; }
        .btn { display:inline-block; background:#111827; color:#fff !important; text-decoration:none; padding:10px 14px; border-radius:8px; }
        .small { font-size:12px; color:#6b7280; }
        .spacer { height: 12px; }
    </style>
    <!--[if mso]>
    <style type="text/css">
      .h1 { font-size: 22px !important; }
    </style>
    <![endif]-->
    
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="h1">{{ $heading ?? 'Уведомление' }}</div>
            @if(!empty($messageText))
                <p style="margin-top:0;">{!! nl2br(e($messageText)) !!}</p>
            @endif

            <div class="spacer"></div>
            <div class="row"><div>Номер заказа:</div><div><strong>{{ $order->uuid }}</strong></div></div>
            <div class="row"><div>Дата создания:</div><div>{{ optional($order->created_at)->format('d.m.Y H:i') }}</div></div>
            <div class="row"><div>Сумма заказа:</div><div><strong>{{ number_format((float) $order->total_price, 2, ',', ' ') }} ₽</strong></div></div>
            @if(!empty($order->public_status))
                <div class="row"><div>Статус:</div><div>{{ $order->public_status }}</div></div>
            @endif

            @if(!empty($orderUrl))
                <div class="spacer"></div>
                <p><a href="{{ $orderUrl }}" class="btn" target="_blank" rel="noopener">Открыть заказ</a></p>
                <p class="small">Если кнопка не работает, скопируйте ссылку: <br><span class="muted">{{ $orderUrl }}</span></p>
            @endif

            <div class="spacer"></div>
            <p class="small">Отправлено автоматически с сайта {{ parse_url(config('app.url', ''), PHP_URL_HOST) ?: 'mp.market' }}.</p>
        </div>
    </div>
</body>
</html>

