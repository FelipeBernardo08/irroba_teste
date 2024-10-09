<?php

namespace App\Http\Controllers;

use App\Models\Championship;
use App\Models\Teams;
use App\Models\SubscribeChampionship;
use App\Models\QuarterFinals;
use App\Models\Points;
use Exception;
use Illuminate\Http\Request;

class ChampionshipController extends Controller
{
    private $championShip;
    private $teams;
    private $subscribe;
    private $quarterFinals;
    private $points;

    public function __construct(
        Championship $champions,
        Teams $team,
        SubscribeChampionship $sub,
        QuarterFinals $quarter,
        Points $point
    ) {
        $this->championShip = $champions;
        $this->teams = $team;
        $this->subscribe = $sub;
        $this->quarterFinals = $quarter;
        $this->points = $point;
    }


    public function createChampionship(Request $request): object
    {
        try {
            $responseTeams = $this->teams->readTeams();
            if (count($responseTeams) >= 8) {
                $responseChampionship = $this->championShip->createChampionship($request);
                if (count($responseChampionship) != 0) {
                    return $this->responseOK($responseChampionship);
                }
                return $this->error('Campeonato não pode ser cadastrado, tente novamente mais tarde!');
            }
            return $this->error('Necessário ter cadastrado no mínimo 8 times para criar um campeonato!');
        } catch (Exception $e) {
            return $this->error($e);
        }
    }

    public function readChampionships(): object
    {
        try {
            $responseChampionship = $this->championShip->readChampionships();
            if (count($responseChampionship) != 0) {
                return $this->responseOK($responseChampionship);
            }
            return $this->error('Campeonatos não encontrados, tente novamente mais tarde!');
        } catch (Exception $e) {
            return $this->error($e);
        }
    }

    public function readChampionshipId(int $id): object
    {
        try {
            $responseChampionship = $this->championShip->readChampionshipId($id);
            if (count($responseChampionship) != 0) {
                return $this->responseOK($responseChampionship);
            }
            return $this->error('Campeonato não encontrado, tente novamente mais tarde!');
        } catch (Exception $e) {
            return $this->error($e);
        }
    }

    public function initializeChampionship(int $id): object
    {
        try {
            $responseQuarter = $this->quarterFinals->readQuarterByIdChampionship($id);
            if (count($responseQuarter) == 0) {
                $responseSubscribe = $this->subscribe->readTeamsSubscribedByChampionshipId($id);
                if (count($responseSubscribe) >= 8) {
                    $responseQuarter = $this->quarterFinals->createPlayQuarter($responseSubscribe);
                    if (count($responseQuarter) != 0) {
                        $this->insertPointsPlay($responseQuarter);
                        $this->removePointsPlay($responseQuarter);
                        return $this->responseOK($responseQuarter);
                    }
                    return $this->error('Erro ao criar partidas das quartas de finais');
                }
                return $this->error('Necessário 8 times inscritos para iniciar o campeonato');
            }
            return $this->error('Campeonato já foi iniciado!');
        } catch (Exception $e) {
            return $this->error($e);
        }
    }

    public function insertPointsPlay(array $plays): void
    {
        foreach ($plays as $key => $play) {
            if ($play['goals_team_1'] > 0) {
                $this->points->incrementPoint($play['fk_team_1'], $play['fk_championship'], $play['goals_team_1']);
            }
            if ($play['goals_team_2'] > 0) {
                $this->points->incrementPoint($play['fk_team_2'], $play['fk_championship'], $play['goals_team_2']);
            }
        }
    }

    public function removePointsPlay(array $plays): void
    {
        foreach ($plays as $key => $play) {
            if ($play['goals_team_2'] > 0) {
                $this->points->decrementPoint($play['fk_team_1'], $play['fk_championship'], $play['goals_team_2']);
            }
            if ($play['goals_team_1'] > 0) {
                $this->points->decrementPoint($play['fk_team_2'], $play['fk_championship'], $play['goals_team_1']);
            }
        }
    }

    public function responseOK(array $response): object
    {
        return response()->json($response, 200);
    }

    public function error(string $message): object
    {
        return response()->json(['error' => $message], 404);
    }
}
