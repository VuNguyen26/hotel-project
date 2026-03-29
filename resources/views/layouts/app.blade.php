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

                        <div class="pointer-events-none fixed right-4 top-4 z-[120] flex w-full max-w-sm flex-col gap-3 sm:right-6 sm:top-6">
                            @if(session('success'))
                                <div
                                    data-toast
                                    class="pointer-events-auto rounded-2xl border border-emerald-200 bg-white p-4 shadow-xl shadow-emerald-100/50 transition"
                                >
                                    <div class="flex items-start gap-3">
                                        <div class="mt-0.5 flex h-8 w-8 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
                                            ✓
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm font-semibold text-slate-900">Thành công</p>
                                            <p class="mt-1 text-sm text-slate-600">{{ session('success') }}</p>
                                        </div>
                                        <button
                                            type="button"
                                            data-toast-close
                                            class="rounded-lg p-1 text-slate-400 transition hover:bg-slate-100 hover:text-slate-600"
                                        >
                                            ✕
                                        </button>
                                    </div>
                                </div>
                            @endif

                            @if(session('error'))
                                <div
                                    data-toast
                                    class="pointer-events-auto rounded-2xl border border-rose-200 bg-white p-4 shadow-xl shadow-rose-100/50 transition"
                                >
                                    <div class="flex items-start gap-3">
                                        <div class="mt-0.5 flex h-8 w-8 items-center justify-center rounded-full bg-rose-100 text-rose-600">
                                            !
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm font-semibold text-slate-900">Có lỗi xảy ra</p>
                                            <p class="mt-1 text-sm text-slate-600">{{ session('error') }}</p>
                                        </div>
                                        <button
                                            type="button"
                                            data-toast-close
                                            class="rounded-lg p-1 text-slate-400 transition hover:bg-slate-100 hover:text-slate-600"
                                        >
                                            ✕
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div
                            id="confirmModal"
                            class="fixed inset-0 z-[130] hidden items-center justify-center bg-slate-950/50 px-4 backdrop-blur-[2px]"
                        >
                            <div class="w-full max-w-md rounded-3xl bg-white p-6 shadow-2xl">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-100 text-xl text-amber-600">
                                    !
                                </div>

                                <h3 class="mt-4 text-xl font-bold text-slate-900">Xác nhận thao tác</h3>
                                <p id="confirmModalMessage" class="mt-2 text-sm leading-6 text-slate-600">
                                    Bạn có chắc muốn tiếp tục không?
                                </p>

                                <div class="mt-6 flex items-center justify-end gap-3">
                                    <button
                                        type="button"
                                        id="confirmModalCancel"
                                        class="rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
                                    >
                                        Hủy
                                    </button>

                                    <button
                                        type="button"
                                        id="confirmModalSubmit"
                                        class="rounded-xl bg-rose-600 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-rose-700"
                                    >
                                        Xác nhận
                                    </button>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>

        @stack('modals')
        @livewireScripts
    </body>
</html>