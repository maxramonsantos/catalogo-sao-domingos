@props(['comercio', 'destaque' => false])

<article @class([
    'group flex h-full flex-col overflow-hidden rounded-2xl border bg-white shadow-sm transition hover:shadow-md',
    'border-amber-300 ring-1 ring-amber-200' => $destaque,
    'border-gray-200' => ! $destaque,
])>
    <div class="relative aspect-[4/3] w-full overflow-hidden bg-gray-100">
        <img
            src="{{ $comercio->foto_url }}"
            alt="Foto de {{ $comercio->nome }}"
            loading="lazy"
            class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
        >

        @if ($destaque)
            <span class="absolute left-2 top-2 rounded-full bg-amber-400 px-2.5 py-1 text-xs font-semibold text-amber-950 shadow">
                ⭐ Destaque
            </span>
        @endif

        @if (! is_null($comercio->esta_aberto))
            <span @class([
                'absolute right-2 top-2 rounded-full px-2.5 py-1 text-xs font-semibold shadow',
                'bg-emerald-500 text-white' => $comercio->esta_aberto,
                'bg-gray-700 text-white' => ! $comercio->esta_aberto,
            ])>
                {{ $comercio->esta_aberto ? 'Aberto agora' : 'Fechado' }}
            </span>
        @endif
    </div>

    <div class="flex flex-1 flex-col gap-1 p-4">
        <p class="text-xs font-medium uppercase tracking-wide text-emerald-600">
            {{ $comercio->categoria->icone }} {{ $comercio->categoria->nome }}
        </p>

        <h3 class="text-sm font-semibold text-gray-900 sm:text-base">
            {{ $comercio->nome }}
        </h3>

        <p class="text-xs text-gray-500 sm:text-sm">
            {{ $comercio->endereco ?? 'Endereço não informado' }} · {{ $comercio->bairro->nome }}
        </p>

        <div class="mt-auto flex items-center gap-2 pt-3">
            <a
                href="{{ $comercio->whatsapp_link }}"
                target="_blank"
                rel="noopener noreferrer"
                class="flex flex-1 items-center justify-center gap-1.5 rounded-lg bg-emerald-500 px-3 py-2 text-xs font-semibold text-white transition hover:bg-emerald-600 sm:text-sm"
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-4 w-4 fill-current" aria-hidden="true">
                    <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.29-1.39a9.9 9.9 0 0 0 4.75 1.21h.01c5.46 0 9.9-4.45 9.9-9.91C21.96 6.45 17.5 2 12.04 2Zm5.8 14.16c-.24.68-1.39 1.3-1.92 1.38-.49.08-1.11.11-1.8-.11-.41-.13-.94-.31-1.62-.6-2.85-1.23-4.71-4.1-4.85-4.29-.14-.19-1.16-1.54-1.16-2.94 0-1.4.73-2.09.99-2.38.26-.28.57-.35.76-.35s.38 0 .55.01c.18.01.42-.07.65.5.24.58.82 2 .89 2.14.07.14.11.31.02.5-.09.19-.14.31-.28.48-.14.16-.29.36-.42.49-.14.14-.28.29-.12.57.16.28.71 1.17 1.53 1.9 1.05.94 1.94 1.23 2.22 1.37.28.14.44.12.6-.07.16-.19.68-.79.86-1.06.18-.28.36-.23.6-.14.24.09 1.53.72 1.79.85.26.14.44.2.5.31.06.12.06.68-.18 1.36Z" />
                </svg>
                WhatsApp
            </a>

            <a
                href="{{ url('/comercios/'.$comercio->slug) }}"
                class="flex items-center justify-center rounded-lg border border-gray-200 px-3 py-2 text-xs font-semibold text-gray-600 transition hover:border-emerald-300 hover:text-emerald-700 sm:text-sm"
            >
                Ver detalhes
            </a>
        </div>
    </div>
</article>
