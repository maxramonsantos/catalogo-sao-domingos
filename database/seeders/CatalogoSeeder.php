<?php

namespace Database\Seeders;

use App\Models\Bairro;
use App\Models\Categoria;
use App\Models\Comercio;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CatalogoSeeder extends Seeder
{
    /**
     * Semeia categorias, bairros e comércios.
     *
     * Apenas "AF Barbearia" é um comércio real, informado pelo cliente.
     * Os demais são registros de demonstração para preencher a grade e a
     * paginação enquanto os comércios reais ainda não são cadastrados.
     */
    public function run(): void
    {
        $categorias = collect([
            ['nome' => 'Alimentação', 'icone' => '🍽️'],
            ['nome' => 'Saúde', 'icone' => '💊'],
            ['nome' => 'Supermercados', 'icone' => '🛒'],
            ['nome' => 'Serviços', 'icone' => '🔧'],
            ['nome' => 'Construção', 'icone' => '🧱'],
            ['nome' => 'Roupas', 'icone' => '👕'],
            ['nome' => 'Autopeças', 'icone' => '🚗'],
            ['nome' => 'Barbearia', 'icone' => '✂️'],
        ])->map(fn ($c) => Categoria::firstOrCreate(
            ['slug' => Str::slug($c['nome'])],
            ['nome' => $c['nome'], 'icone' => $c['icone']],
        ))->keyBy(fn (Categoria $c) => $c->slug);

        $bairros = collect(['Centro', 'Entrada', 'São José', 'Zona Rural'])
            ->map(fn ($nome) => Bairro::firstOrCreate(
                ['slug' => Str::slug($nome)],
                ['nome' => $nome],
            ))->keyBy(fn (Bairro $b) => $b->slug);

        $comercios = [
            // Comércio real informado pelo cliente.
            [
                'nome' => 'AF Barbearia',
                'categoria' => 'barbearia',
                'bairro' => 'centro',
                'whatsapp' => '999999999',
                'endereco' => null,
                'destaque' => true,
                'abre_as' => null,
                'fecha_as' => null,
            ],

            // Registros de demonstração (placeholder) até cadastrarmos os
            // comércios reais restantes.
            ['nome' => 'Mercadinho Bom Preço', 'categoria' => 'supermercados', 'bairro' => 'centro', 'whatsapp' => '999999998', 'endereco' => 'Rua Principal, Centro', 'destaque' => false, 'abre_as' => '07:00', 'fecha_as' => '20:00'],
            ['nome' => 'Restaurante Sabor da Terra', 'categoria' => 'alimentacao', 'bairro' => 'centro', 'whatsapp' => '999999997', 'endereco' => 'Av. Central, Centro', 'destaque' => false, 'abre_as' => '10:00', 'fecha_as' => '22:00'],
            ['nome' => 'Farmácia Vida', 'categoria' => 'saude', 'bairro' => 'entrada', 'whatsapp' => '999999996', 'endereco' => 'Rua da Entrada, s/n', 'destaque' => false, 'abre_as' => '07:00', 'fecha_as' => '23:00'],
            ['nome' => 'Auto Peças União', 'categoria' => 'autopecas', 'bairro' => 'entrada', 'whatsapp' => '999999995', 'endereco' => 'Rua da Entrada, 120', 'destaque' => false, 'abre_as' => '08:00', 'fecha_as' => '18:00'],
            ['nome' => 'Loja Elegance Modas', 'categoria' => 'roupas', 'bairro' => 'sao-jose', 'whatsapp' => '999999994', 'endereco' => 'Rua São José, 45', 'destaque' => false, 'abre_as' => '08:00', 'fecha_as' => '18:00'],
            ['nome' => 'Construmix Materiais de Construção', 'categoria' => 'construcao', 'bairro' => 'sao-jose', 'whatsapp' => '999999993', 'endereco' => 'Rua São José, 200', 'destaque' => false, 'abre_as' => '07:00', 'fecha_as' => '17:00'],
            ['nome' => 'Pizzaria Point do Sabor', 'categoria' => 'alimentacao', 'bairro' => 'centro', 'whatsapp' => '999999992', 'endereco' => 'Praça Central, Centro', 'destaque' => true, 'abre_as' => '18:00', 'fecha_as' => '23:59'],
            ['nome' => 'Salão Beleza Real', 'categoria' => 'servicos', 'bairro' => 'entrada', 'whatsapp' => '999999991', 'endereco' => 'Rua da Entrada, 80', 'destaque' => false, 'abre_as' => '08:00', 'fecha_as' => '19:00'],
            ['nome' => 'Supermercado Economia', 'categoria' => 'supermercados', 'bairro' => 'zona-rural', 'whatsapp' => '999999990', 'endereco' => 'Zona Rural, km 2', 'destaque' => false, 'abre_as' => '07:00', 'fecha_as' => '21:00'],
            ['nome' => 'Oficina do Zé', 'categoria' => 'autopecas', 'bairro' => 'zona-rural', 'whatsapp' => '999999989', 'endereco' => 'Zona Rural, km 5', 'destaque' => false, 'abre_as' => '08:00', 'fecha_as' => '17:00'],
            ['nome' => 'Padaria Pão Quente', 'categoria' => 'alimentacao', 'bairro' => 'entrada', 'whatsapp' => '999999988', 'endereco' => 'Rua da Entrada, 15', 'destaque' => true, 'abre_as' => '05:00', 'fecha_as' => '20:00'],
        ];

        foreach ($comercios as $c) {
            Comercio::firstOrCreate(
                ['slug' => Str::slug($c['nome'])],
                [
                    'nome' => $c['nome'],
                    'categoria_id' => $categorias[$c['categoria']]->id,
                    'bairro_id' => $bairros[$c['bairro']]->id,
                    'endereco' => $c['endereco'],
                    'whatsapp' => $c['whatsapp'],
                    'destaque' => $c['destaque'],
                    'abre_as' => $c['abre_as'],
                    'fecha_as' => $c['fecha_as'],
                ],
            );
        }
    }
}
