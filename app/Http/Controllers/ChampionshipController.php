<?php

namespace App\Http\Controllers;

use App\Models\Championship;
use Exception;
use Illuminate\Http\Request;

class ChampionshipController extends Controller
{
    private $championShip;

    public function __construct(Championship $champions)
    {
        $this->championShip = $champions;
    }


    public function createChampionship(Request $request): object
    {
        try {
            $responseTeam = $this->championShip->createChampionship($request);
            if (count($responseTeam) != 0) {
                return $this->responseOK($responseTeam);
            }
            return $this->error('Time não pode ser cadastrado, tente novamente mais tarde!');
        } catch (Exception $e) {
            return $this->error($e);
        }
    }

    public function readChampionships(): object
    {
        try {
            $responseTeam = $this->championShip->readChampionships();
            if (count($responseTeam) != 0) {
                return $this->responseOK($responseTeam);
            }
            return $this->error('Times não encontrados, tente novamente mais tarde!');
        } catch (Exception $e) {
            return $this->error($e);
        }
    }

    public function readChampionshipId(int $id): object
    {
        try {
            $responseTeam = $this->championShip->readChampionshipId($id);
            if (count($responseTeam) != 0) {
                return $this->responseOK($responseTeam);
            }
            return $this->error('Time não encontrado, tente novamente mais tarde!');
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
