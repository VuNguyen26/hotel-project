<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles

        <style>
            @media print {
                @page {
                    size: A4;
                    margin: 12mm;
                }

                html, body {
                    background: #ffffff !important;
                }

                .app-chrome {
                    display: none !important;
                }

                .app-content-wrap {
                    padding-left: 0 !important;
                }

                .app-content-inner {
                    padding-top: 0 !important;
                }

                .page-header-print-hide {
                    display: none !important;
                }

                .print-main {
                    padding: 0 !important;
                    margin: 0 !important;
                }

                * {
                    box-shadow: none !important;
                }
            }
        </style>
    </head>
    <body class="bg-slate-100 font-sans text-slate-900 antialiased">
        <x-banner />

        <div class="min-h-screen bg-slate-100">
            <div class="app-chrome">
                @livewire('navigation-menu')
            </div>

            <div class="app-content-wrap lg:pl-64">
                <div class="app-content-inner pt-16">
                    @isset($header)
                        <header class="page-header-print-hide border-b border-slate-200 bg-white/85 backdrop-blur">
                            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </header>
                    @endisset

                    <main class="print-main">
                        {{ $slot }}
                    </main>
                </div>
            </div>
        </div>

        @stack('modals')
        @livewireScripts
    </body>
</html>