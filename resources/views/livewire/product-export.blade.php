<div class="product-export-container">
    <h1 class="page-title">Экспорт и импорт товаров</h1>

    <div class="export-section">
        <label for="count" class="input-label">Количество товаров для выгрузки:</label>
        <select wire:model="count" id="count" class="form-select">
            @for ($i = 10000; $i <= 100000; $i += 10000)
                <option value="{{ $i }}">{{ number_format($i, 0, '.', ' ') }}</option>
            @endfor
        </select>

        <button wire:click="export" class="export-button" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="export">Экспортировать в Excel</span>
            <span wire:loading wire:target="export" class="loading-indicator">
                <span class="spinner"></span>
                Генерация файла...
            </span>
        </button>
    </div>

    <div class="import-section">
        <form wire:submit.prevent="import" class="import-form">
            <label class="input-label">Файл для импорта (XLS/XLSX):</label>
            <input type="file" wire:model="file" accept=".xlsx,.xls" class="file-input" required>
            @error('file') <span class="error-message">{{ $message }}</span> @enderror

            <button type="submit" class="import-button" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="import">Импортировать из Excel</span>
                <span wire:loading wire:target="import" class="loading-indicator">
                    <span class="spinner"></span>
                    Идет импорт...
                </span>
            </button>
        </form>

        @if($isImporting)
            <div class="status-message importing-message">
                Идет обработка файла, пожалуйста подождите...
            </div>
        @endif

        @if($successMessage)
            <div class="status-message success-message">
                {{ $successMessage }}
            </div>
        @endif

        @if($importError)
            <div class="status-message error-message">
                {{ $importError }}
            </div>
        @endif
    </div>
</div>

