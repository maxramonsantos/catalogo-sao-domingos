<?php

use App\Models\Bairro;
use App\Models\Categoria;
use App\Models\Comercio;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    #[Url(as: 'busca', history: true)]
    public string $busca = '';

    #[Url(as: 'categoria', history: true)]
    public ?int $categoriaId = null;

    #[Url(as: 'bairro', history: true)]
    public ?int $bairroId = null;

    public function updatingBusca(): void
    {
        $this->resetPage();
    }

    public function selecionarCategoria(int $id): void
    {
        $this->categoriaId = $this->categoriaId === $id ? null : $id;
        $this->resetPage();
    }

    public function selecionarBairro(int $id): void
    {
        $this->bairroId = $this->bairroId === $id ? null : $id;
        $this->resetPage();
    }

    public function limparFiltros(): void
    {
        $this->reset(['busca', 'categoriaId', 'bairroId']);
        $this->resetPage();
    }

    public function with(): array
    {
        return [
            'categorias' => Categoria::orderBy('nome')->get(),
            'bairros' => Bairro::orderBy('nome')->get(),
            'destaques' => Comercio::query()
                ->where('destaque', true)
                ->where('ativo', true)
                ->with(['categoria', 'bairro'])
                ->orderBy('nome')
                ->get(),
            'comercios' => Comercio::query()
                ->where('ativo', true)
                ->when($this->busca, function ($query) {
                    $termo = $this->busca;
                    $query->where(function ($query) use ($termo) {
                        $query->where('nome', 'like', "%{$termo}%")
                            ->orWhereHas('categoria', fn ($q) => $q->where('nome', 'like', "%{$termo}%"));
                    });
                })
                ->when($this->categoriaId, fn ($query) => $query->where('categoria_id', $this->categoriaId))
                ->when($this->bairroId, fn ($query) => $query->where('bairro_id', $this->bairroId))
                ->with(['categoria', 'bairro'])
                ->orderByDesc('destaque')
                ->orderBy('nome')
                ->paginate(12),
        ];
    }
};
?>

<div class="space-y-10">
    {{-- Hero --}}
    <section class="relative overflow-hidden rounded-2xl sm:rounded-3xl">
        <div class="absolute inset-0 bg-gradient-to-br from-amber-400 via-emerald-500 to-sky-600"></div>

        <svg class="absolute inset-x-0 bottom-0 h-24 w-full text-sky-700/40 sm:h-32" viewBox="0 0 1440 200" preserveAspectRatio="none" fill="currentColor" aria-hidden="true">
            <path d="M0,120 C240,180 480,60 720,100 C960,140 1200,180 1440,110 L1440,200 L0,200 Z" />
        </svg>
        <svg class="absolute inset-x-0 bottom-0 h-16 w-full text-sky-900/30 sm:h-20" viewBox="0 0 1440 200" preserveAspectRatio="none" fill="currentColor" aria-hidden="true">
            <path d="M0,150 C300,100 700,190 1000,140 C1200,110 1320,150 1440,130 L1440,200 L0,200 Z" />
        </svg>

        <div class="absolute inset-0 bg-black/25"></div>

        <div class="relative px-5 py-12 text-center text-white sm:px-10 sm:py-20">
            <span class="inline-flex items-center gap-2 rounded-full bg-white/90 px-4 py-1.5 text-sm font-semibold text-emerald-800 shadow-sm">
                <span aria-hidden="true">🍍</span>
                O Guia Oficial de São Domingos do Maranhão
            </span>

            <h1 class="mx-auto mt-5 max-w-2xl text-2xl font-extrabold leading-tight drop-shadow-sm sm:text-4xl">
                Encontre empresas, serviços e produtos em São Domingos
            </h1>

            <p class="mx-auto mt-3 max-w-xl text-sm text-white/90 sm:text-base">
                O guia comercial da Terra do Abacaxi 🍍 — perto da Lagoa do Zé Feio.
            </p>

            {{-- Busca em tempo real --}}
            <div class="mx-auto mt-6 max-w-xl">
                <div class="relative">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                        </svg>
                    </span>

                    <input
                        type="search"
                        wire:model.live.debounce.300ms="busca"
                        placeholder="Busque por farmácia, pizza, auto peças..."
                        class="w-full rounded-full border-0 bg-white py-3 pl-11 pr-4 text-sm text-gray-800 shadow-lg outline-none ring-1 ring-black/5 placeholder:text-gray-400 focus:ring-2 focus:ring-emerald-500 sm:text-base"
                    >
                </div>
            </div>

            {{-- Seleção rápida de bairros --}}
            <div class="mx-auto mt-4 flex max-w-xl flex-wrap items-center justify-center gap-2">
                @foreach ($bairros as $bairro)
                    <button
                        type="button"
                        wire:click="selecionarBairro({{ $bairro->id }})"
                        @class([
                            'rounded-full px-3.5 py-1.5 text-xs font-medium transition sm:text-sm',
                            'bg-white text-emerald-800 shadow' => $bairroId === $bairro->id,
                            'bg-white/20 text-white hover:bg-white/30' => $bairroId !== $bairro->id,
                        ])
                    >
                        {{ $bairro->nome }}
                    </button>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Categorias --}}
    <section>
        <h2 class="mb-3 text-lg font-semibold text-gray-800 sm:text-xl">Categorias</h2>

        <div class="-mx-4 flex snap-x gap-3 overflow-x-auto px-4 pb-2 sm:mx-0 sm:flex-wrap sm:px-0">
            @foreach ($categorias as $categoria)
                <button
                    type="button"
                    wire:click="selecionarCategoria({{ $categoria->id }})"
                    @class([
                        'flex shrink-0 snap-start flex-col items-center gap-1.5 rounded-xl border px-4 py-3 text-center transition sm:shrink',
                        'border-emerald-500 bg-emerald-50 text-emerald-800 shadow-sm' => $categoriaId === $categoria->id,
                        'border-gray-200 bg-white text-gray-600 hover:border-emerald-300 hover:bg-emerald-50/50' => $categoriaId !== $categoria->id,
                    ])
                >
                    <span class="text-2xl" aria-hidden="true">{{ $categoria->icone }}</span>
                    <span class="text-xs font-medium sm:text-sm">{{ $categoria->nome }}</span>
                </button>
            @endforeach

            @if ($busca || $categoriaId || $bairroId)
                <button
                    type="button"
                    wire:click="limparFiltros"
                    class="flex shrink-0 items-center gap-1.5 rounded-xl border border-dashed border-gray-300 px-4 py-3 text-xs font-medium text-gray-500 hover:border-gray-400 hover:text-gray-700 sm:text-sm"
                >
                    ✕ Limpar filtros
                </button>
            @endif
        </div>
    </section>

    {{-- Em destaque --}}
    @if ($destaques->isNotEmpty())
        <section>
            <h2 class="mb-3 flex items-center gap-2 text-lg font-semibold text-gray-800 sm:text-xl">
                <span aria-hidden="true">⭐</span> Em destaque
            </h2>

            <div class="-mx-4 flex snap-x gap-4 overflow-x-auto px-4 pb-2 sm:mx-0 sm:px-0">
                @foreach ($destaques as $comercio)
                    <div class="w-64 shrink-0 snap-start sm:w-72">
                        <x-partials.comercio-card :comercio="$comercio" :destaque="true" />
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Grid principal --}}
    <section>
        <div class="mb-3 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800 sm:text-xl">
                Comércios
                <span class="font-normal text-gray-400">({{ $comercios->total() }})</span>
            </h2>
        </div>

        @if ($comercios->isEmpty())
            <div class="rounded-xl border border-dashed border-gray-300 bg-white py-14 text-center">
                <p class="text-2xl">🍍</p>
                <p class="mt-2 text-sm text-gray-500">Nenhum comércio encontrado para esse filtro.</p>
            </div>
        @else
            <div wire:loading.class="opacity-50" class="grid grid-cols-1 gap-4 transition-opacity sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($comercios as $comercio)
                    <x-partials.comercio-card :comercio="$comercio" />
                @endforeach
            </div>

            <div class="mt-6">
                {{ $comercios->links() }}
            </div>
        @endif
    </section>
</div>
