<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Экспорт и импорт товаров</title>
    @livewireStyles
</head>
<body class="bg-gray-50 min-h-screen">
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden p-6">
        @livewire('product-export')
    </div>
</div>
@livewireScripts

<style>
    .product-export-container {
        max-width: 500px;
        margin: 0 auto;
        padding: 20px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .page-title {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
        font-size: 24px;
    }
    .export-section {
        margin-bottom: 25px;
    }
    .import-section {
        padding-top: 20px;
        border-top: 1px solid #eee;
    }
    .input-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #333;
    }
    .form-select, .file-input {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }
    .export-button, .import-button {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 4px;
        color: white;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    .export-button {
        background-color: #2563eb;
    }
    .export-button:hover {
        background-color: #1d4ed8;
    }
    .import-button {
        background-color: #16a34a;
    }
    .import-button:hover {
        background-color: #15803d;
    }
    .import-button:disabled, .export-button:disabled {
        background-color: #94a3b8;
        cursor: not-allowed;
    }
    .error-message {
        color: #dc2626;
        font-size: 14px;
        display: block;
        margin-top: 5px;
    }
    .status-message {
        padding: 12px;
        margin-top: 15px;
        border-radius: 4px;
        font-size: 14px;
    }
    .success-message {
        background-color: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }
    .error-message {
        background-color: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }
    .importing-message {
        background-color: #dbeafe;
        color: #1e40af;
        border: 1px solid #bfdbfe;
    }
    .loading-indicator {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .spinner {
        display: inline-block;
        width: 16px;
        height: 16px;
        border: 2px solid rgba(255,255,255,0.3);
        border-radius: 50%;
        border-top-color: white;
        animation: spin 1s ease-in-out infinite;
        margin-right: 8px;
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>
</body>
</html>
