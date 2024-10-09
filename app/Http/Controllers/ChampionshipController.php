<?php

namespace App\Http\Controllers;

use App\Models\Championship;
use App\Models\Teams;
use Exception;
use Illuminate\Http\Request;

class ChampionshipController extends Controller
{
    private $championShip;
    private $teams;

    public function __construct(
        Championship $champions,
        Teams $team
    ) {
        $this->championShip = $champions;
        $this->teams = $team;
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

    public function responseOK(array $response): object
    {
        return response()->json($response, 200);
    }

    public function error(string $message): object
    {
        return response()->json(['error' => $message], 404);
    }
}
