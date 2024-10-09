<?php

namespace App\Http\Controllers;

use App\Models\Championship;
use App\Models\Teams;
use App\Models\SubscribeChampionship;
use App\Models\QuarterFinals;
use App\Models\Points;
use App\Models\Finals;
use App\Models\SemiFinals;
use App\Models\SecondPlace;
use App\Models\ThirdPlace;
use App\Models\Champion;
use App\Models\PlayThirdPlace;
use Exception;
use Illuminate\Http\Request;

class ChampionshipController extends Controller
{
    private $championShip;
    private $teams;
    private $subscribe;
    private $quarterFinals;
    private $points;
    private $finals;
    private $semiFinals;
    private $secondPlace;
    private $thirdPlace;
    private $champion;
    private $playThirdPlace;

    public function __construct(
        Championship $champions,
        Teams $team,
        SubscribeChampionship $sub,
        QuarterFinals $quarter,
        Points $point,
        Finals $final,
        SemiFinals $semi,
        SecondPlace $second,
        Champion $champ,
        PlayThirdPlace $playThird,
        ThirdPlace $third
    ) {
        $this->championShip = $champions;
        $this->teams = $team;
        $this->subscribe = $sub;
        $this->quarterFinals = $quarter;
        $this->points = $point;
        $this->finals = $final;
        $this->semiFinals = $semi;
        $this->secondPlace = $second;
        $this->champion = $champ;
        $this->playThirdPlace = $playThird;
        $this->thirdPlace = $third;
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
                        $winnersQuarters = $this->getWinners($responseQuarter);
                        $responseSemiFinals = $this->semiFinals->createSemiFinals($winnersQuarters, $id);
                        if (count($responseSemiFinals) != 0) {
                            $this->insertPointsPlay($responseSemiFinals);
                            $this->removePointsPlay($responseSemiFinals);
                            $winnersSemiFinals = $this->getWinners($responseSemiFinals);
                            $idLosers = $this->getLosers($responseSemiFinals);
                            $this->setPlayThirdPlace($idLosers, $id);
                            $responseFinals = $this->finals->createFinals($winnersSemiFinals, $id);
                            if (count($responseFinals) != 0) {
                                $this->insertPointsPlay($responseFinals);
                                $this->removePointsPlay($responseFinals);

                                $idWinner = $this->getWinners($responseFinals);
                                $this->setSecondPlace($idWinner[0], $id, $responseFinals);
                                $this->setWinner($idWinner[0], $id);
                                $championshipComplete = $this->championShip->readChampionshipId($id);
                                return $this->responseOK($championshipComplete);
                            }
                            return $this->error('Erro criar partida final');
                        }
                        return $this->error('Erro criar partidas semifinais');
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
        foreach ($plays as $play) {
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
        foreach ($plays as $play) {
            if ($play['goals_team_2'] > 0) {
                $this->points->decrementPoint($play['fk_team_1'], $play['fk_championship'], $play['goals_team_2']);
            }
            if ($play['goals_team_1'] > 0) {
                $this->points->decrementPoint($play['fk_team_2'], $play['fk_championship'], $play['goals_team_1']);
            }
        }
    }

    public function setPlayThirdPlace(array $losersSemiFinals, int $idChampionship): void
    {
        $responseThirdPlace = $this->playThirdPlace->createPlayThirdPlace($losersSemiFinals, $idChampionship);
        $this->insertPointsPlay($responseThirdPlace);
        $this->removePointsPlay($responseThirdPlace);
        if (count($responseThirdPlace) != 0) {
            $winner = $this->getWinners($responseThirdPlace);
            $this->setThirdPlace($winner[0], $idChampionship);
        }
    }

    public function getWinners(array $plays): array
    {
        $winners = [];
        foreach ($plays as $play) {
            if ($play['goals_team_1'] > $play['goals_team_2']) {
                array_push($winners, $play['fk_team_1']);
            } else if ($play['goals_team_1'] < $play['goals_team_2']) {
                array_push($winners, $play['fk_team_2']);
            } else {
                $resultPoints = $this->getWinnerByPoints($play);
                if ($resultPoints > 0) {
                    array_push($winners, $resultPoints);
                } else {
                    $resultsSubscribeOrder = $this->getWinnerBySubscribeOrder($play);
                    if ($resultsSubscribeOrder > 0) {
                        array_push($winners, $resultsSubscribeOrder);
                    }
                }
            }
        }
        return $winners;
    }

    public function getLosers(array $plays): array
    {
        $losers = [];
        foreach ($plays as $play) {
            if ($play['goals_team_1'] > $play['goals_team_2']) {
                array_push($losers, $play['fk_team_2']);
            } else if ($play['goals_team_1'] < $play['goals_team_2']) {
                array_push($losers, $play['fk_team_1']);
            } else {
                $resultPoints = $this->getLoserByPoints($play);
                if ($resultPoints > 0) {
                    array_push($losers, $resultPoints);
                } else {
                    $resultsSubscribeOrder = $this->getLoserBySubscribeOrder($play);
                    if ($resultsSubscribeOrder > 0) {
                        array_push($losers, $resultsSubscribeOrder);
                    }
                }
            }
        }
        return $losers;
    }

    public function getWinnerByPoints($play): int
    {
        $pointsTeams = $this->points->getPointsByArrayIdTeam([$play['fk_team_1'], $play['fk_team_2']], $play['fk_championship']);
        if (count($pointsTeams) == 2) {
            if ($pointsTeams[0]['points'] > $pointsTeams[1]['points']) {
                return $pointsTeams[0]['fk_team'];
            } else if ($pointsTeams[0]['points'] < $pointsTeams[1]['points']) {
                return $pointsTeams[1]['fk_team'];
            }
            return 0;
        }
        return 0;
    }

    public function getLoserByPoints($play): int
    {
        $pointsTeams = $this->points->getPointsByArrayIdTeam([$play['fk_team_1'], $play['fk_team_2']], $play['fk_championship']);
        if (count($pointsTeams) == 2) {
            if ($pointsTeams[0]['points'] > $pointsTeams[1]['points']) {
                return $pointsTeams[1]['fk_team'];
            } else if ($pointsTeams[0]['points'] < $pointsTeams[1]['points']) {
                return $pointsTeams[0]['fk_team'];
            }
            return 0;
        }
        return 0;
    }

    public function getWinnerBySubscribeOrder($play): int
    {
        $subscribeTeams = $this->subscribe->getSubscribeByArrayTeams([$play['fk_team_1'], $play['fk_team_2']], $play['fk_championship']);
        if (count($subscribeTeams) == 2) {
            if ($subscribeTeams[0]['id'] > $subscribeTeams[1]['id']) {
                return $subscribeTeams[0]['fk_team'];
            }
            return $subscribeTeams[1]['fk_team'];
        }
        return 0;
    }

    public function getLoserBySubscribeOrder($play): int
    {
        $subscribeTeams = $this->subscribe->getSubscribeByArrayTeams([$play['fk_team_1'], $play['fk_team_2']], $play['fk_championship']);
        if (count($subscribeTeams) == 2) {
            if ($subscribeTeams[0]['id'] > $subscribeTeams[1]['id']) {
                return $subscribeTeams[1]['fk_team'];
            }
            return $subscribeTeams[0]['fk_team'];
        }
        return 0;
    }

    public function setWinner(int $idWinner, int $idChampionship)
    {
        $this->champion->createChampion($idWinner, $idChampionship);
    }

    public function setSecondPlace(int $idWinner, int $idChampionship, array $final): void
    {
        if ($final[0]['fk_team_1'] == $idWinner) {
            $this->secondPlace->createTeamSecondPlace($final[0]['fk_team_2'], $idChampionship);
        } else {
            $this->secondPlace->createTeamSecondPlace($final[0]['fk_team_1'], $idChampionship);
        }
    }

    public function setThirdPlace(int $idWinner, int $idChampionship): void
    {
        $this->thirdPlace->createThirdPlace($idWinner, $idChampionship);
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
