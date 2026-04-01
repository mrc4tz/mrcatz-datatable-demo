<!DOCTYPE html>
<html lang="en" data-theme="mrcatz-light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MrCatz DataTable Demo</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons|Material+Symbols+Outlined" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-base-200 min-h-screen">

    <div class="navbar bg-base-100 shadow-sm sticky top-0 z-30 px-6">
        <div class="flex-1 gap-3">
            <span class="material-icons text-primary text-2xl">inventory_2</span>
            <div>
                <h1 class="text-lg font-bold text-base-content leading-tight">MrCatz DataTable</h1>
                <p class="text-[10px] text-base-content/40">Product Management Demo</p>
            </div>
        </div>
        <div class="flex-none gap-2">
            <a href="https://github.com/mrcatz/datatables" target="_blank" class="btn btn-ghost btn-sm gap-1 text-xs">
                <span class="material-icons text-sm">code</span>
                GitHub
            </a>
        </div>
    </div>

    <div class="p-4 md:p-6 max-w-7xl mx-auto">
        {{ $slot }}
    </div>

    @include('mrcatz::components.ui.notification')

    @stack('scripts')
</body>
</html>
