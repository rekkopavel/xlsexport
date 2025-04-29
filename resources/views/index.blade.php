<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Экспорт и импорт товаров</title>
    @livewireStyles
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-50">
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-xs">

        <div class="space-y-3">
            @livewire('product-export')
        </div>


    </div>
</div>

@livewireScripts
</body>
</html>
