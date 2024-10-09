<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Championship extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function quarters()
    {
        return $this->hasMany(QuarterFinals::class, 'fk_championship');
    }

    public function readChampionships(): array
    {
        return self::with('quarters')->get()->toArray();
    }

    public function readChampionshipId(int $id): array
    {
        return self::where('id', $id)
            ->with('quarters')
            ->get()
            ->toArray();
    }

    public function createChampionship(object $team): array
    {
        return self::create([
            'name' => $team->name
        ])->toArray();
    }
}
