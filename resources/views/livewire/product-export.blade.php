<div>
    <h1>Экспорт и импорт товаров</h1>

    <label for="count">Количество товаров для выгрузки:</label>
    <select wire:model="count" id="count">
        @for ($i = 10000; $i <= 100000; $i += 10000)
            <option value="{{ $i }}">{{ number_format($i) }}</option>
        @endfor
    </select>

    <div>
        <button wire:click="export">Экспортировать в Excel</button>
    </div>
    <div>
        <form wire:submit="import" class="space-y-4">
            <input type="file" wire:model="file" required>
            @error('file') <span class="text-red-600">{{ $message }}</span> @enderror

            <button type="submit">Импортировать из Excel</button>
        </form>

    </div>

</div>
