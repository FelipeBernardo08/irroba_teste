<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayThirdPlace extends Model
{
    use HasFactory;

    protected $fillable = [
        'fk_team_1',
        'fk_team_2',
        'goals_team_1',
        'goals_team_2',
        'fk_championship'
    ];

    public function team1()
    {
        return $this->belongsTo(Teams::class, 'fk_team_1');
    }

    public function team2()
    {
        return $this->belongsTo(Teams::class, 'fk_team_2');
    }

    public function createPlayThirdPlace(array $play, int $idChampionship): array
    {
        $play = self::create([
            'fk_team_1' => $play[0],
            'fk_team_2' => $play[1],
            'goals_team_1' => $this->generateGoal(),
            'goals_team_2' => $this->generateGoal(),
            'fk_championship' => $idChampionship
        ])->toArray();
        return self::where('id', $play['id'])
            ->get()
            ->toArray();
    }

    public function generateGoal(): int
    {
        $scriptPath = base_path('teste.py');
        $result = shell_exec("python3 $scriptPath");
        $goal = explode(' ', trim($result));
        return $goal[0];
    }
}
