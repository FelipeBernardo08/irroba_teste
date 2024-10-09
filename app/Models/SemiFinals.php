<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SemiFinals extends Model
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

    public function createSemiFinals(array $winnersQuarters, int $idChampionship): array
    {
        shuffle($winnersQuarters);
        $keyGames = [];
        for ($i = 0; $i < count($winnersQuarters); $i += 2) {
            $keyGames[] = array_slice($winnersQuarters, $i, 2);
        }
        foreach ($keyGames as $key => $games) {
            self::create([
                'fk_team_1' => $games[0],
                'fk_team_2' => $games[1],
                'goals_team_1' => $this->generateGoal(),
                'goals_team_2' => $this->generateGoal(),
                'fk_championship' => $idChampionship
            ]);
            if (($key + 1) == count($keyGames)) {
                return self::where('fk_championship', $idChampionship)
                    ->get()
                    ->toArray();
            }
        }
    }

    public function generateGoal(): int
    {
        $scriptPath = base_path('teste.py');
        $result = shell_exec("python3 $scriptPath");
        $goal = explode(' ', trim($result));
        return $goal[0];
    }
}
