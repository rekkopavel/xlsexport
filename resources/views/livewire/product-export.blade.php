<div>
    <h1>Экспорт и импорт товаров</h1>

    <label for="count">Количество товаров для выгрузки:</label>
    <select wire:model="count" id="count">
        @for ($i = 10000; $i <= 100000; $i += 10000)
            <option value="{{ $i }}">{{ number_format($i) }}</option>
        @endfor
    </select>

    <div><button wire:click="export">Экспортировать в Excel</button></div>
    <div> <button wire:click="import">Импортировать из Excel</button></div>
</div>
