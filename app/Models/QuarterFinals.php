<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuarterFinals extends Model
{
    use HasFactory;

    protected $fillable = [
        'fk_team_1',
        'fk_team_2',
        'goals_team_1',
        'goals_team_2',
        'fk_championship'
    ];

    public function createPlayQuarter(array $teams): array
    {
        shuffle($teams);
        $keyGames = [];
        for ($i = 0; $i < count($teams); $i += 2) {
            $keyGames[] = array_slice($teams, $i, 2);
        }
        foreach ($keyGames as $key => $games) {
            self::create([
                'fk_team_1' => $games[0]['fk_team'],
                'fk_team_2' => $games[1]['fk_team'],
                'goals_team_1' => $this->generateGoal(),
                'goals_team_2' => $this->generateGoal(),
                'fk_championship' => $games[0]['fk_championship']
            ]);
            if (($key + 1) == count($keyGames)) {
                return self::where('fk_championship', $games[0]['fk_championship'])
                    ->get()
                    ->toArray();
            }
        }
        return $keyGames;
    }

    public function readQuarterByIdChampionship(int $id_championship): array
    {
        return self::where('fk_championship', $id_championship)
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
