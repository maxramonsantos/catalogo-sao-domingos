<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Comercio extends Model
{
    protected $fillable = [
        'nome', 'slug', 'categoria_id', 'bairro_id', 'endereco',
        'whatsapp', 'foto_path', 'abre_as', 'fecha_as', 'destaque', 'ativo',
    ];

    protected $casts = [
        'abre_as' => 'datetime:H:i',
        'fecha_as' => 'datetime:H:i',
        'destaque' => 'boolean',
        'ativo' => 'boolean',
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function bairro(): BelongsTo
    {
        return $this->belongsTo(Bairro::class);
    }

    protected function whatsappLink(): Attribute
    {
        return Attribute::get(function () {
            $digitos = preg_replace('/\D/', '', $this->whatsapp);

            if (! str_starts_with($digitos, '55')) {
                $digitos = '55'.$digitos;
            }

            return "https://wa.me/{$digitos}";
        });
    }

    protected function fotoUrl(): Attribute
    {
        return Attribute::get(fn () => $this->foto_path
            ? asset('storage/'.$this->foto_path)
            : asset('images/placeholder-comercio.svg')
        );
    }

    protected function estaAberto(): Attribute
    {
        return Attribute::get(function () {
            if (! $this->abre_as || ! $this->fecha_as) {
                return null;
            }

            $agora = now()->format('H:i');
            $abre = $this->abre_as->format('H:i');
            $fecha = $this->fecha_as->format('H:i');

            if ($abre <= $fecha) {
                return $agora >= $abre && $agora <= $fecha;
            }

            // horário que vira a noite (ex: 18:00 às 02:00)
            return $agora >= $abre || $agora <= $fecha;
        });
    }
}
