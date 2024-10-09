<?php

namespace App\Http\Controllers;

use App\Models\Championship;
use App\Models\Teams;
use App\Models\SubscribeChampionship;
use Exception;
use Illuminate\Http\Request;

class ChampionshipController extends Controller
{
    private $championShip;
    private $teams;
    private $subscribe;

    public function __construct(
        Championship $champions,
        Teams $team,
        SubscribeChampionship $sub
    ) {
        $this->championShip = $champions;
        $this->teams = $team;
        $this->subscribe = $sub;
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
            $responseSubscribe = $this->subscribe->readTeamsSubscribedByChampionshipId($id);
            if (count($responseSubscribe) >= 8) {
            }
            return $this->error('Necessário 8 times inscritos para iniciar o campeonato');
        } catch (Exception $e) {
            return $this->error($e);
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
