<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? config('app.name') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
    </head>
    <body class="min-h-screen bg-gray-50 text-gray-900 antialiased">
        <div class="flex min-h-screen flex-col">
            <header x-data="{ open: false }" class="sticky top-0 z-40 border-b border-gray-200 bg-white/90 backdrop-blur">
                <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-8">
                    <a href="{{ url('/') }}" class="text-lg font-bold text-emerald-700">
                        Catálogo São Domingos
                    </a>

                    <button
                        type="button"
                        @click="open = !open"
                        class="inline-flex items-center justify-center rounded-md p-2 text-gray-700 hover:bg-gray-100 sm:hidden"
                        aria-label="Abrir menu"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <nav class="hidden items-center gap-6 text-sm font-medium text-gray-600 sm:flex">
                        <a href="{{ url('/') }}" class="hover:text-emerald-700">Início</a>
                        <a href="#" class="hover:text-emerald-700">Comércios</a>
                        <a href="#" class="hover:text-emerald-700">Guia da Cidade</a>
                        <a href="#" class="hover:text-emerald-700">Contato</a>
                    </nav>
                </div>

                <nav x-show="open" x-cloak x-transition class="border-t border-gray-200 bg-white px-4 py-3 sm:hidden">
                    <div class="flex flex-col gap-3 text-sm font-medium text-gray-600">
                        <a href="{{ url('/') }}" class="hover:text-emerald-700">Início</a>
                        <a href="#" class="hover:text-emerald-700">Comércios</a>
                        <a href="#" class="hover:text-emerald-700">Guia da Cidade</a>
                        <a href="#" class="hover:text-emerald-700">Contato</a>
                    </div>
                </nav>
            </header>

            <main class="mx-auto w-full max-w-6xl flex-1 px-4 py-6 sm:px-6 lg:px-8">
                {{ $slot }}
            </main>

            <footer class="border-t border-gray-200 bg-gradient-to-r from-amber-50 via-emerald-50 to-sky-50">
                <div class="mx-auto max-w-6xl px-4 py-8 text-center sm:px-6 lg:px-8">
                    <p class="text-sm font-medium text-gray-700">
                        Desenvolvido com orgulho em São Domingos do Maranhão — A Terra do Abacaxi 🍍
                    </p>

                    <a href="#" class="mt-3 inline-block text-sm font-semibold text-emerald-700 underline-offset-2 hover:underline">
                        Tem um comércio? Cadastre sua loja gratuitamente
                    </a>

                    <p class="mt-4 text-xs text-gray-400">
                        &copy; {{ date('Y') }} Catálogo São Domingos. Todos os direitos reservados.
                    </p>
                </div>
            </footer>
        </div>

        @livewireScripts
    </body>
</html>
