<?php

namespace App\Http\Controllers;

use App\Models\Teams;
use Exception;
use Illuminate\Http\Request;

class TeamsController extends Controller
{
    private $teams;

    public function __construct(Teams $team)
    {
        $this->teams = $team;
    }

    public function createTeam(Request $request): object
    {
        try {
            $responseTeam = $this->teams->createTeam($request);
            if (count($responseTeam) != 0) {
                return $this->responseOK($responseTeam);
            }
            return $this->error('Time não pode ser cadastrado, tente novamente mais tarde!');
        } catch (Exception $e) {
            return $this->error($e);
        }
    }

    public function readTeams(): object
    {
        try {
            $responseTeam = $this->teams->readTeams();
            if (count($responseTeam) != 0) {
                return $this->responseOK($responseTeam);
            }
            return $this->error('Times não encontrados, tente novamente mais tarde!');
        } catch (Exception $e) {
            return $this->error($e);
        }
    }

    public function readTeamId(int $id): object
    {
        try {
            $responseTeam = $this->teams->readTeamId($id);
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
