<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teams extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function readTeams(): array
    {
        return self::get()->toArray();
    }

    public function readTeamId(int $id): array
    {
        return self::where('id', $id)
            ->get()
            ->toArray();
    }

    public function createTeam(object $team): array
    {
        return self::create([
            'name' => $team->name
        ])->toArray();
    }
}
