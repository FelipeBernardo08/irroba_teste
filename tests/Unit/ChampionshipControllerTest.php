<?php

namespace Tests\Unit;

use Illuminate\Http\Request;
use Tests\TestCase;
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
use App\Http\Controllers\ChampionshipController;
use Mockery;

class ChampionshipControllerTest extends TestCase
{
    public function test_errorResponseChampionshipMethod(): void
    {
        $mockModelChampionship = Mockery::mock(Championship::class);
        $mockModelTeams = Mockery::mock(Teams::class);
        $mockModelSubscribe = Mockery::mock(SubscribeChampionship::class);
        $mockModelQuarters = Mockery::mock(QuarterFinals::class);
        $mockModelPoints = Mockery::mock(Points::class);
        $mockModelFinals = Mockery::mock(Finals::class);
        $mockModelSemiFinals = Mockery::mock(SemiFinals::class);
        $mockModelSecondPlace = Mockery::mock(SecondPlace::class);
        $mockModelThirdPlace = Mockery::mock(ThirdPlace::class);
        $mockModelChampion = Mockery::mock(Champion::class);
        $mockModelPlayThird = Mockery::mock(PlayThirdPlace::class);

        $mockController = new ChampionshipController(
            $mockModelChampionship,
            $mockModelTeams,
            $mockModelSubscribe,
            $mockModelQuarters,
            $mockModelPoints,
            $mockModelFinals,
            $mockModelSemiFinals,
            $mockModelSecondPlace,
            $mockModelChampion,
            $mockModelPlayThird,
            $mockModelThirdPlace
        );

        $mockMessage = 'Erro';
        $response = $mockController->error($mockMessage);
        $this->assertEquals(404, $response->status());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['error' => $mockMessage]),
            $response->getContent()
        );
    }

    public function test_okResponseChampionshipMethod(): void
    {
        $mockModelChampionship = Mockery::mock(Championship::class);
        $mockModelTeams = Mockery::mock(Teams::class);
        $mockModelSubscribe = Mockery::mock(SubscribeChampionship::class);
        $mockModelQuarters = Mockery::mock(QuarterFinals::class);
        $mockModelPoints = Mockery::mock(Points::class);
        $mockModelFinals = Mockery::mock(Finals::class);
        $mockModelSemiFinals = Mockery::mock(SemiFinals::class);
        $mockModelSecondPlace = Mockery::mock(SecondPlace::class);
        $mockModelThirdPlace = Mockery::mock(ThirdPlace::class);
        $mockModelChampion = Mockery::mock(Champion::class);
        $mockModelPlayThird = Mockery::mock(PlayThirdPlace::class);

        $mockController = new ChampionshipController(
            $mockModelChampionship,
            $mockModelTeams,
            $mockModelSubscribe,
            $mockModelQuarters,
            $mockModelPoints,
            $mockModelFinals,
            $mockModelSemiFinals,
            $mockModelSecondPlace,
            $mockModelChampion,
            $mockModelPlayThird,
            $mockModelThirdPlace
        );

        $mockResponse = ['teste'];
        $response = $mockController->responseOK($mockResponse);
        $this->assertEquals(200, $response->status());
        $this->assertJsonStringEqualsJsonString(
            json_encode($mockResponse),
            $response->getContent()
        );
    }

    public function test_setThirdPlaceMethod(): void
    {
        $mockModelChampionship = Mockery::mock(Championship::class);
        $mockModelTeams = Mockery::mock(Teams::class);
        $mockModelSubscribe = Mockery::mock(SubscribeChampionship::class);
        $mockModelQuarters = Mockery::mock(QuarterFinals::class);
        $mockModelPoints = Mockery::mock(Points::class);
        $mockModelFinals = Mockery::mock(Finals::class);
        $mockModelSemiFinals = Mockery::mock(SemiFinals::class);
        $mockModelSecondPlace = Mockery::mock(SecondPlace::class);
        $mockModelThirdPlace = Mockery::mock(ThirdPlace::class);
        $mockModelChampion = Mockery::mock(Champion::class);
        $mockModelPlayThird = Mockery::mock(PlayThirdPlace::class);

        $mockController = new ChampionshipController(
            $mockModelChampionship,
            $mockModelTeams,
            $mockModelSubscribe,
            $mockModelQuarters,
            $mockModelPoints,
            $mockModelFinals,
            $mockModelSemiFinals,
            $mockModelSecondPlace,
            $mockModelChampion,
            $mockModelPlayThird,
            $mockModelThirdPlace
        );

        $idWinnerMock = 1;
        $idChampionshipMock = 2;

        $mockModelThirdPlace->shouldReceive('createThirdPlace')
            ->with($idWinnerMock, $idChampionshipMock)
            ->once();

        $mockController->setThirdPlace($idWinnerMock, $idChampionshipMock);
    }

    public function test_setSecondPlaceExpectUseTeam2(): void
    {
        $mockModelChampionship = Mockery::mock(Championship::class);
        $mockModelTeams = Mockery::mock(Teams::class);
        $mockModelSubscribe = Mockery::mock(SubscribeChampionship::class);
        $mockModelQuarters = Mockery::mock(QuarterFinals::class);
        $mockModelPoints = Mockery::mock(Points::class);
        $mockModelFinals = Mockery::mock(Finals::class);
        $mockModelSemiFinals = Mockery::mock(SemiFinals::class);
        $mockModelSecondPlace = Mockery::mock(SecondPlace::class);
        $mockModelThirdPlace = Mockery::mock(ThirdPlace::class);
        $mockModelChampion = Mockery::mock(Champion::class);
        $mockModelPlayThird = Mockery::mock(PlayThirdPlace::class);

        $mockController = new ChampionshipController(
            $mockModelChampionship,
            $mockModelTeams,
            $mockModelSubscribe,
            $mockModelQuarters,
            $mockModelPoints,
            $mockModelFinals,
            $mockModelSemiFinals,
            $mockModelSecondPlace,
            $mockModelChampion,
            $mockModelPlayThird,
            $mockModelThirdPlace
        );

        $finalMock = [
            [
                "fk_team_2" => 1,
                "fk_team_1" => 3,
            ]
        ];

        $idChampionshipMock = 1;

        $idWinnerMock = 3;

        $mockModelSecondPlace->shouldReceive('createTeamSecondPlace')
            ->with($finalMock[0]['fk_team_2'], $idChampionshipMock)
            ->once();

        $mockController->setSecondPlace($idWinnerMock, $idChampionshipMock, $finalMock);
    }

    public function test_setSecondPlaceExpectUseTeam1(): void
    {
        $mockModelChampionship = Mockery::mock(Championship::class);
        $mockModelTeams = Mockery::mock(Teams::class);
        $mockModelSubscribe = Mockery::mock(SubscribeChampionship::class);
        $mockModelQuarters = Mockery::mock(QuarterFinals::class);
        $mockModelPoints = Mockery::mock(Points::class);
        $mockModelFinals = Mockery::mock(Finals::class);
        $mockModelSemiFinals = Mockery::mock(SemiFinals::class);
        $mockModelSecondPlace = Mockery::mock(SecondPlace::class);
        $mockModelThirdPlace = Mockery::mock(ThirdPlace::class);
        $mockModelChampion = Mockery::mock(Champion::class);
        $mockModelPlayThird = Mockery::mock(PlayThirdPlace::class);

        $mockController = new ChampionshipController(
            $mockModelChampionship,
            $mockModelTeams,
            $mockModelSubscribe,
            $mockModelQuarters,
            $mockModelPoints,
            $mockModelFinals,
            $mockModelSemiFinals,
            $mockModelSecondPlace,
            $mockModelChampion,
            $mockModelPlayThird,
            $mockModelThirdPlace
        );

        $finalMock = [
            [
                "fk_team_2" => 1,
                "fk_team_1" => 3,
            ]
        ];

        $idChampionshipMock = 1;

        $idWinnerMock = 1;

        $mockModelSecondPlace->shouldReceive('createTeamSecondPlace')
            ->with($finalMock[0]['fk_team_1'], $idChampionshipMock)
            ->once();

        $mockController->setSecondPlace($idWinnerMock, $idChampionshipMock, $finalMock);
    }

    public function test_setWinnerMethod(): void
    {
        $mockModelChampionship = Mockery::mock(Championship::class);
        $mockModelTeams = Mockery::mock(Teams::class);
        $mockModelSubscribe = Mockery::mock(SubscribeChampionship::class);
        $mockModelQuarters = Mockery::mock(QuarterFinals::class);
        $mockModelPoints = Mockery::mock(Points::class);
        $mockModelFinals = Mockery::mock(Finals::class);
        $mockModelSemiFinals = Mockery::mock(SemiFinals::class);
        $mockModelSecondPlace = Mockery::mock(SecondPlace::class);
        $mockModelThirdPlace = Mockery::mock(ThirdPlace::class);
        $mockModelChampion = Mockery::mock(Champion::class);
        $mockModelPlayThird = Mockery::mock(PlayThirdPlace::class);

        $mockController = new ChampionshipController(
            $mockModelChampionship,
            $mockModelTeams,
            $mockModelSubscribe,
            $mockModelQuarters,
            $mockModelPoints,
            $mockModelFinals,
            $mockModelSemiFinals,
            $mockModelSecondPlace,
            $mockModelChampion,
            $mockModelPlayThird,
            $mockModelThirdPlace
        );


        $idChampionshipMock = 1;

        $idWinnerMock = 3;

        $mockModelChampion->shouldReceive('createChampion')
            ->with($idWinnerMock, $idChampionshipMock)
            ->once();

        $mockController->setWinner($idWinnerMock, $idChampionshipMock);
    }

    public function test_getLoserBySubscribeOrderExpectReturn0Index(): void
    {
        $mockModelChampionship = Mockery::mock(Championship::class);
        $mockModelTeams = Mockery::mock(Teams::class);
        $mockModelSubscribe = Mockery::mock(SubscribeChampionship::class);
        $mockModelQuarters = Mockery::mock(QuarterFinals::class);
        $mockModelPoints = Mockery::mock(Points::class);
        $mockModelFinals = Mockery::mock(Finals::class);
        $mockModelSemiFinals = Mockery::mock(SemiFinals::class);
        $mockModelSecondPlace = Mockery::mock(SecondPlace::class);
        $mockModelThirdPlace = Mockery::mock(ThirdPlace::class);
        $mockModelChampion = Mockery::mock(Champion::class);
        $mockModelPlayThird = Mockery::mock(PlayThirdPlace::class);

        $mockController = new ChampionshipController(
            $mockModelChampionship,
            $mockModelTeams,
            $mockModelSubscribe,
            $mockModelQuarters,
            $mockModelPoints,
            $mockModelFinals,
            $mockModelSemiFinals,
            $mockModelSecondPlace,
            $mockModelChampion,
            $mockModelPlayThird,
            $mockModelThirdPlace
        );

        $playMock = [
            "fk_team_1" => 1,
            "fk_team_2" => 2,
            "fk_championship" => 1
        ];

        $returnResponseSubscribedMock = (array) [
            [
                "id" => 1,
                "fk_team" => 1
            ],
            [
                "id" => 2,
                "fk_team" => 2
            ]
        ];

        $mockModelSubscribe->shouldReceive('getSubscribeByArrayTeams')
            ->once()
            ->with([$playMock['fk_team_1'], $playMock['fk_team_2']], $playMock['fk_championship'])
            ->andReturn($returnResponseSubscribedMock);

        $result = $mockController->getLoserBySubscribeOrder($playMock);

        $this->assertEquals($result, $returnResponseSubscribedMock[1]['fk_team']);
    }

    public function test_getLoserBySubscribeOrderExpectReturn1Index(): void
    {
        $mockModelChampionship = Mockery::mock(Championship::class);
        $mockModelTeams = Mockery::mock(Teams::class);
        $mockModelSubscribe = Mockery::mock(SubscribeChampionship::class);
        $mockModelQuarters = Mockery::mock(QuarterFinals::class);
        $mockModelPoints = Mockery::mock(Points::class);
        $mockModelFinals = Mockery::mock(Finals::class);
        $mockModelSemiFinals = Mockery::mock(SemiFinals::class);
        $mockModelSecondPlace = Mockery::mock(SecondPlace::class);
        $mockModelThirdPlace = Mockery::mock(ThirdPlace::class);
        $mockModelChampion = Mockery::mock(Champion::class);
        $mockModelPlayThird = Mockery::mock(PlayThirdPlace::class);

        $mockController = new ChampionshipController(
            $mockModelChampionship,
            $mockModelTeams,
            $mockModelSubscribe,
            $mockModelQuarters,
            $mockModelPoints,
            $mockModelFinals,
            $mockModelSemiFinals,
            $mockModelSecondPlace,
            $mockModelChampion,
            $mockModelPlayThird,
            $mockModelThirdPlace
        );

        $playMock = [
            "fk_team_1" => 1,
            "fk_team_2" => 2,
            "fk_championship" => 1
        ];

        $returnResponseSubscribedMock = (array) [
            [
                "id" => 2,
                "fk_team" => 1
            ],
            [
                "id" => 1,
                "fk_team" => 2
            ]
        ];


        $mockModelSubscribe->shouldReceive('getSubscribeByArrayTeams')
            ->once()
            ->with([$playMock['fk_team_1'], $playMock['fk_team_2']], $playMock['fk_championship'])
            ->andReturn($returnResponseSubscribedMock);

        $result = $mockController->getLoserBySubscribeOrder($playMock);

        $this->assertEquals($result, $returnResponseSubscribedMock[0]['fk_team']);
    }

    public function test_getLoserBySubscribeOrderExpectReturnNumber0(): void
    {
        $mockModelChampionship = Mockery::mock(Championship::class);
        $mockModelTeams = Mockery::mock(Teams::class);
        $mockModelSubscribe = Mockery::mock(SubscribeChampionship::class);
        $mockModelQuarters = Mockery::mock(QuarterFinals::class);
        $mockModelPoints = Mockery::mock(Points::class);
        $mockModelFinals = Mockery::mock(Finals::class);
        $mockModelSemiFinals = Mockery::mock(SemiFinals::class);
        $mockModelSecondPlace = Mockery::mock(SecondPlace::class);
        $mockModelThirdPlace = Mockery::mock(ThirdPlace::class);
        $mockModelChampion = Mockery::mock(Champion::class);
        $mockModelPlayThird = Mockery::mock(PlayThirdPlace::class);

        $mockController = new ChampionshipController(
            $mockModelChampionship,
            $mockModelTeams,
            $mockModelSubscribe,
            $mockModelQuarters,
            $mockModelPoints,
            $mockModelFinals,
            $mockModelSemiFinals,
            $mockModelSecondPlace,
            $mockModelChampion,
            $mockModelPlayThird,
            $mockModelThirdPlace
        );

        $playMock = [
            "fk_team_1" => 2,
            "fk_team_2" => 1,
            "fk_championship" => 1
        ];

        $returnResponseSubscribedMock = (array) [
            [
                "id" => 1,
                "fk_team" => 1
            ],
            [
                "id" => 2,
                "fk_team" => 2
            ],
            [
                "id" => 3,
                "fk_team" => 3
            ]
        ];

        $mockModelSubscribe->shouldReceive('getSubscribeByArrayTeams')
            ->once()
            ->with([$playMock['fk_team_1'], $playMock['fk_team_2']], $playMock['fk_championship'])
            ->andReturn($returnResponseSubscribedMock);

        $result = $mockController->getLoserBySubscribeOrder($playMock);

        $this->assertEquals($result, 0);
    }

    public function test_getWinnerBySubscribeOrderExpectReturn0Index(): void
    {
        $mockModelChampionship = Mockery::mock(Championship::class);
        $mockModelTeams = Mockery::mock(Teams::class);
        $mockModelSubscribe = Mockery::mock(SubscribeChampionship::class);
        $mockModelQuarters = Mockery::mock(QuarterFinals::class);
        $mockModelPoints = Mockery::mock(Points::class);
        $mockModelFinals = Mockery::mock(Finals::class);
        $mockModelSemiFinals = Mockery::mock(SemiFinals::class);
        $mockModelSecondPlace = Mockery::mock(SecondPlace::class);
        $mockModelThirdPlace = Mockery::mock(ThirdPlace::class);
        $mockModelChampion = Mockery::mock(Champion::class);
        $mockModelPlayThird = Mockery::mock(PlayThirdPlace::class);

        $mockController = new ChampionshipController(
            $mockModelChampionship,
            $mockModelTeams,
            $mockModelSubscribe,
            $mockModelQuarters,
            $mockModelPoints,
            $mockModelFinals,
            $mockModelSemiFinals,
            $mockModelSecondPlace,
            $mockModelChampion,
            $mockModelPlayThird,
            $mockModelThirdPlace
        );

        $playMock = [
            "fk_team_1" => 2,
            "fk_team_2" => 1,
            "fk_championship" => 1
        ];

        $returnResponseSubscribedMock = (array) [
            [
                "id" => 1,
                "fk_team" => 1
            ],
            [
                "id" => 2,
                "fk_team" => 2
            ]
        ];

        $mockModelSubscribe->shouldReceive('getSubscribeByArrayTeams')
            ->once()
            ->with([$playMock['fk_team_1'], $playMock['fk_team_2']], $playMock['fk_championship'])
            ->andReturn($returnResponseSubscribedMock);

        $result = $mockController->getWinnerBySubscribeOrder($playMock);

        $this->assertEquals($result, $returnResponseSubscribedMock[0]['fk_team']);
    }

    public function test_getWinnerBySubscribeOrderExpectReturn1Index(): void
    {
        $mockModelChampionship = Mockery::mock(Championship::class);
        $mockModelTeams = Mockery::mock(Teams::class);
        $mockModelSubscribe = Mockery::mock(SubscribeChampionship::class);
        $mockModelQuarters = Mockery::mock(QuarterFinals::class);
        $mockModelPoints = Mockery::mock(Points::class);
        $mockModelFinals = Mockery::mock(Finals::class);
        $mockModelSemiFinals = Mockery::mock(SemiFinals::class);
        $mockModelSecondPlace = Mockery::mock(SecondPlace::class);
        $mockModelThirdPlace = Mockery::mock(ThirdPlace::class);
        $mockModelChampion = Mockery::mock(Champion::class);
        $mockModelPlayThird = Mockery::mock(PlayThirdPlace::class);

        $mockController = new ChampionshipController(
            $mockModelChampionship,
            $mockModelTeams,
            $mockModelSubscribe,
            $mockModelQuarters,
            $mockModelPoints,
            $mockModelFinals,
            $mockModelSemiFinals,
            $mockModelSecondPlace,
            $mockModelChampion,
            $mockModelPlayThird,
            $mockModelThirdPlace
        );

        $playMock = [
            "fk_team_1" => 2,
            "fk_team_2" => 1,
            "fk_championship" => 1
        ];

        $returnResponseSubscribedMock = (array) [
            [
                "id" => 2,
                "fk_team" => 1
            ],
            [
                "id" => 1,
                "fk_team" => 2
            ]
        ];

        $mockModelSubscribe->shouldReceive('getSubscribeByArrayTeams')
            ->once()
            ->with([$playMock['fk_team_1'], $playMock['fk_team_2']], $playMock['fk_championship'])
            ->andReturn($returnResponseSubscribedMock);

        $result = $mockController->getWinnerBySubscribeOrder($playMock);

        $this->assertEquals($result, $returnResponseSubscribedMock[1]['fk_team']);
    }

    public function test_getWinnerBySubscribeOrderExpectReturnNumber0(): void
    {
        $mockModelChampionship = Mockery::mock(Championship::class);
        $mockModelTeams = Mockery::mock(Teams::class);
        $mockModelSubscribe = Mockery::mock(SubscribeChampionship::class);
        $mockModelQuarters = Mockery::mock(QuarterFinals::class);
        $mockModelPoints = Mockery::mock(Points::class);
        $mockModelFinals = Mockery::mock(Finals::class);
        $mockModelSemiFinals = Mockery::mock(SemiFinals::class);
        $mockModelSecondPlace = Mockery::mock(SecondPlace::class);
        $mockModelThirdPlace = Mockery::mock(ThirdPlace::class);
        $mockModelChampion = Mockery::mock(Champion::class);
        $mockModelPlayThird = Mockery::mock(PlayThirdPlace::class);

        $mockController = new ChampionshipController(
            $mockModelChampionship,
            $mockModelTeams,
            $mockModelSubscribe,
            $mockModelQuarters,
            $mockModelPoints,
            $mockModelFinals,
            $mockModelSemiFinals,
            $mockModelSecondPlace,
            $mockModelChampion,
            $mockModelPlayThird,
            $mockModelThirdPlace
        );

        $playMock = [
            "fk_team_1" => 2,
            "fk_team_2" => 1,
            "fk_championship" => 1
        ];

        $returnResponseSubscribedMock = (array) [
            [
                "id" => 1,
                "fk_team" => 1
            ],
            [
                "id" => 2,
                "fk_team" => 2
            ],
            [
                "id" => 3,
                "fk_team" => 3
            ]
        ];

        $mockModelSubscribe->shouldReceive('getSubscribeByArrayTeams')
            ->once()
            ->with([$playMock['fk_team_1'], $playMock['fk_team_2']], $playMock['fk_championship'])
            ->andReturn($returnResponseSubscribedMock);

        $result = $mockController->getWinnerBySubscribeOrder($playMock);

        $this->assertEquals($result, 0);
    }

    public function test_getLoserByPointsExpectReturn0Index(): void
    {
        $mockModelChampionship = Mockery::mock(Championship::class);
        $mockModelTeams = Mockery::mock(Teams::class);
        $mockModelSubscribe = Mockery::mock(SubscribeChampionship::class);
        $mockModelQuarters = Mockery::mock(QuarterFinals::class);
        $mockModelPoints = Mockery::mock(Points::class);
        $mockModelFinals = Mockery::mock(Finals::class);
        $mockModelSemiFinals = Mockery::mock(SemiFinals::class);
        $mockModelSecondPlace = Mockery::mock(SecondPlace::class);
        $mockModelThirdPlace = Mockery::mock(ThirdPlace::class);
        $mockModelChampion = Mockery::mock(Champion::class);
        $mockModelPlayThird = Mockery::mock(PlayThirdPlace::class);

        $mockController = new ChampionshipController(
            $mockModelChampionship,
            $mockModelTeams,
            $mockModelSubscribe,
            $mockModelQuarters,
            $mockModelPoints,
            $mockModelFinals,
            $mockModelSemiFinals,
            $mockModelSecondPlace,
            $mockModelChampion,
            $mockModelPlayThird,
            $mockModelThirdPlace
        );

        $playMock = [
            "fk_team_1" => 2,
            "fk_team_2" => 1,
            "fk_championship" => 1
        ];

        $returnResponsePointsMock = (array) [
            [
                "id" => 1,
                "fk_team" => 1,
                "points" => 1
            ],
            [
                "id" => 2,
                "fk_team" => 2,
                "points" => 2
            ]
        ];

        $mockModelPoints->shouldReceive('getPointsByArrayIdTeam')
            ->once()
            ->with([$playMock['fk_team_1'], $playMock['fk_team_2']], $playMock['fk_championship'])
            ->andReturn($returnResponsePointsMock);

        $response = $mockController->getLoserByPoints($playMock);
        $this->assertEquals($response, $returnResponsePointsMock[0]['fk_team']);
    }

    public function test_getLoserByPointsExpectReturn1Index(): void
    {
        $mockModelChampionship = Mockery::mock(Championship::class);
        $mockModelTeams = Mockery::mock(Teams::class);
        $mockModelSubscribe = Mockery::mock(SubscribeChampionship::class);
        $mockModelQuarters = Mockery::mock(QuarterFinals::class);
        $mockModelPoints = Mockery::mock(Points::class);
        $mockModelFinals = Mockery::mock(Finals::class);
        $mockModelSemiFinals = Mockery::mock(SemiFinals::class);
        $mockModelSecondPlace = Mockery::mock(SecondPlace::class);
        $mockModelThirdPlace = Mockery::mock(ThirdPlace::class);
        $mockModelChampion = Mockery::mock(Champion::class);
        $mockModelPlayThird = Mockery::mock(PlayThirdPlace::class);

        $mockController = new ChampionshipController(
            $mockModelChampionship,
            $mockModelTeams,
            $mockModelSubscribe,
            $mockModelQuarters,
            $mockModelPoints,
            $mockModelFinals,
            $mockModelSemiFinals,
            $mockModelSecondPlace,
            $mockModelChampion,
            $mockModelPlayThird,
            $mockModelThirdPlace
        );

        $playMock = [
            "fk_team_1" => 2,
            "fk_team_2" => 1,
            "fk_championship" => 1
        ];

        $returnResponsePointsMock = (array) [
            [
                "id" => 1,
                "fk_team" => 1,
                "points" => 2
            ],
            [
                "id" => 2,
                "fk_team" => 2,
                "points" => 1
            ]
        ];

        $mockModelPoints->shouldReceive('getPointsByArrayIdTeam')
            ->once()
            ->with([$playMock['fk_team_1'], $playMock['fk_team_2']], $playMock['fk_championship'])
            ->andReturn($returnResponsePointsMock);

        $response = $mockController->getLoserByPoints($playMock);
        $this->assertEquals($response, $returnResponsePointsMock[1]['fk_team']);
    }

    public function test_getLoserByPointsExpectReturn0(): void
    {
        $mockModelChampionship = Mockery::mock(Championship::class);
        $mockModelTeams = Mockery::mock(Teams::class);
        $mockModelSubscribe = Mockery::mock(SubscribeChampionship::class);
        $mockModelQuarters = Mockery::mock(QuarterFinals::class);
        $mockModelPoints = Mockery::mock(Points::class);
        $mockModelFinals = Mockery::mock(Finals::class);
        $mockModelSemiFinals = Mockery::mock(SemiFinals::class);
        $mockModelSecondPlace = Mockery::mock(SecondPlace::class);
        $mockModelThirdPlace = Mockery::mock(ThirdPlace::class);
        $mockModelChampion = Mockery::mock(Champion::class);
        $mockModelPlayThird = Mockery::mock(PlayThirdPlace::class);

        $mockController = new ChampionshipController(
            $mockModelChampionship,
            $mockModelTeams,
            $mockModelSubscribe,
            $mockModelQuarters,
            $mockModelPoints,
            $mockModelFinals,
            $mockModelSemiFinals,
            $mockModelSecondPlace,
            $mockModelChampion,
            $mockModelPlayThird,
            $mockModelThirdPlace
        );

        $playMock = [
            "fk_team_1" => 2,
            "fk_team_2" => 1,
            "fk_championship" => 1
        ];

        $returnResponsePointsMock = (array) [
            [
                "id" => 1,
                "fk_team" => 1,
                "points" => 2
            ],
            [
                "id" => 2,
                "fk_team" => 2,
                "points" => 1
            ],
            [
                "id" => 3,
                "fk_team" => 3,
                "points" => 1
            ]
        ];

        $mockModelPoints->shouldReceive('getPointsByArrayIdTeam')
            ->once()
            ->with([$playMock['fk_team_1'], $playMock['fk_team_2']], $playMock['fk_championship'])
            ->andReturn($returnResponsePointsMock);

        $response = $mockController->getLoserByPoints($playMock);
        $this->assertEquals($response, 0);
    }

    public function test_getWinnerByPointsExpectReturn0Index(): void
    {
        $mockModelChampionship = Mockery::mock(Championship::class);
        $mockModelTeams = Mockery::mock(Teams::class);
        $mockModelSubscribe = Mockery::mock(SubscribeChampionship::class);
        $mockModelQuarters = Mockery::mock(QuarterFinals::class);
        $mockModelPoints = Mockery::mock(Points::class);
        $mockModelFinals = Mockery::mock(Finals::class);
        $mockModelSemiFinals = Mockery::mock(SemiFinals::class);
        $mockModelSecondPlace = Mockery::mock(SecondPlace::class);
        $mockModelThirdPlace = Mockery::mock(ThirdPlace::class);
        $mockModelChampion = Mockery::mock(Champion::class);
        $mockModelPlayThird = Mockery::mock(PlayThirdPlace::class);

        $mockController = new ChampionshipController(
            $mockModelChampionship,
            $mockModelTeams,
            $mockModelSubscribe,
            $mockModelQuarters,
            $mockModelPoints,
            $mockModelFinals,
            $mockModelSemiFinals,
            $mockModelSecondPlace,
            $mockModelChampion,
            $mockModelPlayThird,
            $mockModelThirdPlace
        );

        $playMock = [
            "fk_team_1" => 2,
            "fk_team_2" => 1,
            "fk_championship" => 1
        ];

        $returnResponsePointsMock = (array) [
            [
                "id" => 1,
                "fk_team" => 1,
                "points" => 2
            ],
            [
                "id" => 2,
                "fk_team" => 2,
                "points" => 1
            ]
        ];

        $mockModelPoints->shouldReceive('getPointsByArrayIdTeam')
            ->once()
            ->with([$playMock['fk_team_1'], $playMock['fk_team_2']], $playMock['fk_championship'])
            ->andReturn($returnResponsePointsMock);

        $response = $mockController->getWinnerByPoints($playMock);
        $this->assertEquals($response, $returnResponsePointsMock[0]['fk_team']);
    }

    public function test_getWinnerByPointsExpectReturn1Index(): void
    {
        $mockModelChampionship = Mockery::mock(Championship::class);
        $mockModelTeams = Mockery::mock(Teams::class);
        $mockModelSubscribe = Mockery::mock(SubscribeChampionship::class);
        $mockModelQuarters = Mockery::mock(QuarterFinals::class);
        $mockModelPoints = Mockery::mock(Points::class);
        $mockModelFinals = Mockery::mock(Finals::class);
        $mockModelSemiFinals = Mockery::mock(SemiFinals::class);
        $mockModelSecondPlace = Mockery::mock(SecondPlace::class);
        $mockModelThirdPlace = Mockery::mock(ThirdPlace::class);
        $mockModelChampion = Mockery::mock(Champion::class);
        $mockModelPlayThird = Mockery::mock(PlayThirdPlace::class);

        $mockController = new ChampionshipController(
            $mockModelChampionship,
            $mockModelTeams,
            $mockModelSubscribe,
            $mockModelQuarters,
            $mockModelPoints,
            $mockModelFinals,
            $mockModelSemiFinals,
            $mockModelSecondPlace,
            $mockModelChampion,
            $mockModelPlayThird,
            $mockModelThirdPlace
        );

        $playMock = [
            "fk_team_1" => 2,
            "fk_team_2" => 1,
            "fk_championship" => 1
        ];

        $returnResponsePointsMock = (array) [
            [
                "id" => 1,
                "fk_team" => 1,
                "points" => 1
            ],
            [
                "id" => 2,
                "fk_team" => 2,
                "points" => 2
            ]
        ];

        $mockModelPoints->shouldReceive('getPointsByArrayIdTeam')
            ->once()
            ->with([$playMock['fk_team_1'], $playMock['fk_team_2']], $playMock['fk_championship'])
            ->andReturn($returnResponsePointsMock);

        $response = $mockController->getWinnerByPoints($playMock);
        $this->assertEquals($response, $returnResponsePointsMock[1]['fk_team']);
    }

    public function test_getWinnerByPointsExpectReturn0(): void
    {
        $mockModelChampionship = Mockery::mock(Championship::class);
        $mockModelTeams = Mockery::mock(Teams::class);
        $mockModelSubscribe = Mockery::mock(SubscribeChampionship::class);
        $mockModelQuarters = Mockery::mock(QuarterFinals::class);
        $mockModelPoints = Mockery::mock(Points::class);
        $mockModelFinals = Mockery::mock(Finals::class);
        $mockModelSemiFinals = Mockery::mock(SemiFinals::class);
        $mockModelSecondPlace = Mockery::mock(SecondPlace::class);
        $mockModelThirdPlace = Mockery::mock(ThirdPlace::class);
        $mockModelChampion = Mockery::mock(Champion::class);
        $mockModelPlayThird = Mockery::mock(PlayThirdPlace::class);

        $mockController = new ChampionshipController(
            $mockModelChampionship,
            $mockModelTeams,
            $mockModelSubscribe,
            $mockModelQuarters,
            $mockModelPoints,
            $mockModelFinals,
            $mockModelSemiFinals,
            $mockModelSecondPlace,
            $mockModelChampion,
            $mockModelPlayThird,
            $mockModelThirdPlace
        );

        $playMock = [
            "fk_team_1" => 2,
            "fk_team_2" => 1,
            "fk_championship" => 1
        ];

        $returnResponsePointsMock = (array) [
            [
                "id" => 1,
                "fk_team" => 1,
                "points" => 1
            ],
            [
                "id" => 2,
                "fk_team" => 2,
                "points" => 2
            ],
            [
                "id" => 3,
                "fk_team" => 3,
                "points" => 3
            ]
        ];

        $mockModelPoints->shouldReceive('getPointsByArrayIdTeam')
            ->once()
            ->with([$playMock['fk_team_1'], $playMock['fk_team_2']], $playMock['fk_championship'])
            ->andReturn($returnResponsePointsMock);

        $response = $mockController->getWinnerByPoints($playMock);
        $this->assertEquals($response, 0);
    }

    public function test_getLosersExpectReturnValidArrayByGoals(): void
    {
        $mockModelChampionship = Mockery::mock(Championship::class);
        $mockModelTeams = Mockery::mock(Teams::class);
        $mockModelSubscribe = Mockery::mock(SubscribeChampionship::class);
        $mockModelQuarters = Mockery::mock(QuarterFinals::class);
        $mockModelPoints = Mockery::mock(Points::class);
        $mockModelFinals = Mockery::mock(Finals::class);
        $mockModelSemiFinals = Mockery::mock(SemiFinals::class);
        $mockModelSecondPlace = Mockery::mock(SecondPlace::class);
        $mockModelThirdPlace = Mockery::mock(ThirdPlace::class);
        $mockModelChampion = Mockery::mock(Champion::class);
        $mockModelPlayThird = Mockery::mock(PlayThirdPlace::class);

        $mockController = new ChampionshipController(
            $mockModelChampionship,
            $mockModelTeams,
            $mockModelSubscribe,
            $mockModelQuarters,
            $mockModelPoints,
            $mockModelFinals,
            $mockModelSemiFinals,
            $mockModelSecondPlace,
            $mockModelChampion,
            $mockModelPlayThird,
            $mockModelThirdPlace
        );

        $playsMock = (array)[
            [
                "goals_team_1" => 1,
                "goals_team_2" => 2,
                "fk_team_1" => 1,
                "fk_team_2" => 2
            ]
        ];

        $result = $mockController->getLosers($playsMock);
        $this->assertEquals($result[0], $playsMock[0]['fk_team_1']);
    }

    public function test_getLosersExpectReturnValidArrayByPoints(): void
    {
        $mockModelChampionship = Mockery::mock(Championship::class);
        $mockModelTeams = Mockery::mock(Teams::class);
        $mockModelSubscribe = Mockery::mock(SubscribeChampionship::class);
        $mockModelQuarters = Mockery::mock(QuarterFinals::class);
        $mockModelPoints = Mockery::mock(Points::class);
        $mockModelFinals = Mockery::mock(Finals::class);
        $mockModelSemiFinals = Mockery::mock(SemiFinals::class);
        $mockModelSecondPlace = Mockery::mock(SecondPlace::class);
        $mockModelThirdPlace = Mockery::mock(ThirdPlace::class);
        $mockModelChampion = Mockery::mock(Champion::class);
        $mockModelPlayThird = Mockery::mock(PlayThirdPlace::class);

        $mockController = new ChampionshipController(
            $mockModelChampionship,
            $mockModelTeams,
            $mockModelSubscribe,
            $mockModelQuarters,
            $mockModelPoints,
            $mockModelFinals,
            $mockModelSemiFinals,
            $mockModelSecondPlace,
            $mockModelChampion,
            $mockModelPlayThird,
            $mockModelThirdPlace
        );

        $playsMock = (array)[
            [
                "goals_team_1" => 1,
                "goals_team_2" => 1,
                "fk_team_1" => 1,
                "fk_team_2" => 2,
                "fk_championship" => 4
            ]
        ];

        $returnPointsMock = (array) [
            [
                "fk_team" => 1,
                "points" => 2
            ],
            [
                "fk_team" => 2,
                "points" => 1
            ]
        ];

        $mockModelPoints->shouldReceive('getPointsByArrayIdTeam')
            ->once()
            ->with([$playsMock[0]['fk_team_1'], $playsMock[0]['fk_team_2']], $playsMock[0]['fk_championship'])
            ->andReturn($returnPointsMock);

        $result = $mockController->getLosers($playsMock);

        $this->assertEquals($result[0], $playsMock[0]['fk_team_2']);
    }

    public function test_getLosersExpectReturnValidArrayBySubscribe(): void
    {
        $mockModelChampionship = Mockery::mock(Championship::class);
        $mockModelTeams = Mockery::mock(Teams::class);
        $mockModelSubscribe = Mockery::mock(SubscribeChampionship::class);
        $mockModelQuarters = Mockery::mock(QuarterFinals::class);
        $mockModelPoints = Mockery::mock(Points::class);
        $mockModelFinals = Mockery::mock(Finals::class);
        $mockModelSemiFinals = Mockery::mock(SemiFinals::class);
        $mockModelSecondPlace = Mockery::mock(SecondPlace::class);
        $mockModelThirdPlace = Mockery::mock(ThirdPlace::class);
        $mockModelChampion = Mockery::mock(Champion::class);
        $mockModelPlayThird = Mockery::mock(PlayThirdPlace::class);

        $mockController = new ChampionshipController(
            $mockModelChampionship,
            $mockModelTeams,
            $mockModelSubscribe,
            $mockModelQuarters,
            $mockModelPoints,
            $mockModelFinals,
            $mockModelSemiFinals,
            $mockModelSecondPlace,
            $mockModelChampion,
            $mockModelPlayThird,
            $mockModelThirdPlace
        );

        $playsMock = (array)[
            [
                "goals_team_1" => 1,
                "goals_team_2" => 1,
                "fk_team_1" => 1,
                "fk_team_2" => 2,
                "fk_championship" => 4
            ]
        ];

        $returnPointsMock = (array) [
            [
                "fk_team" => 1,
                "points" => 1
            ],
            [
                "fk_team" => 2,
                "points" => 1
            ]
        ];

        $returnSubscribeMock = (array) [
            [
                "id" => 1,
                "fk_team" => 1
            ],
            [
                "id" => 2,
                "fk_team" => 2
            ]
        ];

        $mockModelPoints->shouldReceive('getPointsByArrayIdTeam')
            ->once()
            ->with([$playsMock[0]['fk_team_1'], $playsMock[0]['fk_team_2']], $playsMock[0]['fk_championship'])
            ->andReturn($returnPointsMock);

        $mockModelSubscribe->shouldReceive('getSubscribeByArrayTeams')
            ->once()
            ->with([$playsMock[0]['fk_team_1'], $playsMock[0]['fk_team_2']], $playsMock[0]['fk_championship'])
            ->andReturn($returnSubscribeMock);


        $result = $mockController->getLosers($playsMock);

        $this->assertEquals($result[0], $playsMock[0]['fk_team_2']);
    }

    public function test_getWinnersExpectReturnValidArrayByGoals(): void
    {
        $mockModelChampionship = Mockery::mock(Championship::class);
        $mockModelTeams = Mockery::mock(Teams::class);
        $mockModelSubscribe = Mockery::mock(SubscribeChampionship::class);
        $mockModelQuarters = Mockery::mock(QuarterFinals::class);
        $mockModelPoints = Mockery::mock(Points::class);
        $mockModelFinals = Mockery::mock(Finals::class);
        $mockModelSemiFinals = Mockery::mock(SemiFinals::class);
        $mockModelSecondPlace = Mockery::mock(SecondPlace::class);
        $mockModelThirdPlace = Mockery::mock(ThirdPlace::class);
        $mockModelChampion = Mockery::mock(Champion::class);
        $mockModelPlayThird = Mockery::mock(PlayThirdPlace::class);

        $mockController = new ChampionshipController(
            $mockModelChampionship,
            $mockModelTeams,
            $mockModelSubscribe,
            $mockModelQuarters,
            $mockModelPoints,
            $mockModelFinals,
            $mockModelSemiFinals,
            $mockModelSecondPlace,
            $mockModelChampion,
            $mockModelPlayThird,
            $mockModelThirdPlace
        );

        $playsMock = (array)[
            [
                "goals_team_1" => 1,
                "goals_team_2" => 2,
                "fk_team_1" => 1,
                "fk_team_2" => 2
            ]
        ];

        $result = $mockController->getWinners($playsMock);
        $this->assertEquals($result[0], $playsMock[0]['fk_team_2']);
    }

    public function test_getWinnersExpectReturnValidArrayByPoints(): void
    {
        $mockModelChampionship = Mockery::mock(Championship::class);
        $mockModelTeams = Mockery::mock(Teams::class);
        $mockModelSubscribe = Mockery::mock(SubscribeChampionship::class);
        $mockModelQuarters = Mockery::mock(QuarterFinals::class);
        $mockModelPoints = Mockery::mock(Points::class);
        $mockModelFinals = Mockery::mock(Finals::class);
        $mockModelSemiFinals = Mockery::mock(SemiFinals::class);
        $mockModelSecondPlace = Mockery::mock(SecondPlace::class);
        $mockModelThirdPlace = Mockery::mock(ThirdPlace::class);
        $mockModelChampion = Mockery::mock(Champion::class);
        $mockModelPlayThird = Mockery::mock(PlayThirdPlace::class);

        $mockController = new ChampionshipController(
            $mockModelChampionship,
            $mockModelTeams,
            $mockModelSubscribe,
            $mockModelQuarters,
            $mockModelPoints,
            $mockModelFinals,
            $mockModelSemiFinals,
            $mockModelSecondPlace,
            $mockModelChampion,
            $mockModelPlayThird,
            $mockModelThirdPlace
        );

        $playsMock = (array)[
            [
                "goals_team_1" => 1,
                "goals_team_2" => 1,
                "fk_team_1" => 1,
                "fk_team_2" => 2,
                "fk_championship" => 4
            ]
        ];

        $returnPointsMock = (array) [
            [
                "fk_team" => 1,
                "points" => 2
            ],
            [
                "fk_team" => 2,
                "points" => 1
            ]
        ];

        $mockModelPoints->shouldReceive('getPointsByArrayIdTeam')
            ->once()
            ->with([$playsMock[0]['fk_team_1'], $playsMock[0]['fk_team_2']], $playsMock[0]['fk_championship'])
            ->andReturn($returnPointsMock);

        $result = $mockController->getWinners($playsMock);

        $this->assertEquals($result[0], $playsMock[0]['fk_team_1']);
    }

    public function test_getWinnersExpectReturnValidArrayBySubscribe(): void
    {
        $mockModelChampionship = Mockery::mock(Championship::class);
        $mockModelTeams = Mockery::mock(Teams::class);
        $mockModelSubscribe = Mockery::mock(SubscribeChampionship::class);
        $mockModelQuarters = Mockery::mock(QuarterFinals::class);
        $mockModelPoints = Mockery::mock(Points::class);
        $mockModelFinals = Mockery::mock(Finals::class);
        $mockModelSemiFinals = Mockery::mock(SemiFinals::class);
        $mockModelSecondPlace = Mockery::mock(SecondPlace::class);
        $mockModelThirdPlace = Mockery::mock(ThirdPlace::class);
        $mockModelChampion = Mockery::mock(Champion::class);
        $mockModelPlayThird = Mockery::mock(PlayThirdPlace::class);

        $mockController = new ChampionshipController(
            $mockModelChampionship,
            $mockModelTeams,
            $mockModelSubscribe,
            $mockModelQuarters,
            $mockModelPoints,
            $mockModelFinals,
            $mockModelSemiFinals,
            $mockModelSecondPlace,
            $mockModelChampion,
            $mockModelPlayThird,
            $mockModelThirdPlace
        );

        $playsMock = (array)[
            [
                "goals_team_1" => 1,
                "goals_team_2" => 1,
                "fk_team_1" => 1,
                "fk_team_2" => 2,
                "fk_championship" => 4
            ]
        ];

        $returnPointsMock = (array) [
            [
                "fk_team" => 1,
                "points" => 1
            ],
            [
                "fk_team" => 2,
                "points" => 1
            ]
        ];

        $returnSubscribeMock = (array) [
            [
                "id" => 1,
                "fk_team" => 1
            ],
            [
                "id" => 2,
                "fk_team" => 2
            ]
        ];

        $mockModelPoints->shouldReceive('getPointsByArrayIdTeam')
            ->once()
            ->with([$playsMock[0]['fk_team_1'], $playsMock[0]['fk_team_2']], $playsMock[0]['fk_championship'])
            ->andReturn($returnPointsMock);

        $mockModelSubscribe->shouldReceive('getSubscribeByArrayTeams')
            ->once()
            ->with([$playsMock[0]['fk_team_1'], $playsMock[0]['fk_team_2']], $playsMock[0]['fk_championship'])
            ->andReturn($returnSubscribeMock);


        $result = $mockController->getWinners($playsMock);

        $this->assertEquals($result[0], $playsMock[0]['fk_team_1']);
    }

    public function test_createChampionshipExpectOk(): void
    {
        $mockModelChampionship = Mockery::mock(Championship::class);
        $mockModelTeams = Mockery::mock(Teams::class);
        $mockModelSubscribe = Mockery::mock(SubscribeChampionship::class);
        $mockModelQuarters = Mockery::mock(QuarterFinals::class);
        $mockModelPoints = Mockery::mock(Points::class);
        $mockModelFinals = Mockery::mock(Finals::class);
        $mockModelSemiFinals = Mockery::mock(SemiFinals::class);
        $mockModelSecondPlace = Mockery::mock(SecondPlace::class);
        $mockModelThirdPlace = Mockery::mock(ThirdPlace::class);
        $mockModelChampion = Mockery::mock(Champion::class);
        $mockModelPlayThird = Mockery::mock(PlayThirdPlace::class);

        $mockController = new ChampionshipController(
            $mockModelChampionship,
            $mockModelTeams,
            $mockModelSubscribe,
            $mockModelQuarters,
            $mockModelPoints,
            $mockModelFinals,
            $mockModelSemiFinals,
            $mockModelSecondPlace,
            $mockModelChampion,
            $mockModelPlayThird,
            $mockModelThirdPlace
        );

        $requestMock = new Request(
            []
        );

        $responseTeamsMock = [
            1,
            2,
            3,
            4,
            5,
            6,
            7,
            8
        ];

        $responseChampionshipMock = [1];

        $mockModelTeams->shouldReceive('readTeams')
            ->once()
            ->andReturn($responseTeamsMock);

        $mockModelChampionship->shouldReceive('createChampionship')
            ->once()
            ->with($requestMock)
            ->andReturn($responseChampionshipMock);

        $response = $mockController->createChampionship($requestMock);

        $this->assertEquals(200, $response->status());
    }

    public function test_createChampionshipExpectErrorSizeTeams(): void
    {
        $mockModelChampionship = Mockery::mock(Championship::class);
        $mockModelTeams = Mockery::mock(Teams::class);
        $mockModelSubscribe = Mockery::mock(SubscribeChampionship::class);
        $mockModelQuarters = Mockery::mock(QuarterFinals::class);
        $mockModelPoints = Mockery::mock(Points::class);
        $mockModelFinals = Mockery::mock(Finals::class);
        $mockModelSemiFinals = Mockery::mock(SemiFinals::class);
        $mockModelSecondPlace = Mockery::mock(SecondPlace::class);
        $mockModelThirdPlace = Mockery::mock(ThirdPlace::class);
        $mockModelChampion = Mockery::mock(Champion::class);
        $mockModelPlayThird = Mockery::mock(PlayThirdPlace::class);

        $mockController = new ChampionshipController(
            $mockModelChampionship,
            $mockModelTeams,
            $mockModelSubscribe,
            $mockModelQuarters,
            $mockModelPoints,
            $mockModelFinals,
            $mockModelSemiFinals,
            $mockModelSecondPlace,
            $mockModelChampion,
            $mockModelPlayThird,
            $mockModelThirdPlace
        );

        $requestMock = new Request(
            []
        );

        $responseTeamsMock = [
            1,
            2,
            3,
            4,
            5,
            6
        ];

        $mockModelTeams->shouldReceive('readTeams')
            ->once()
            ->andReturn($responseTeamsMock);

        $response = $mockController->createChampionship($requestMock);

        $this->assertEquals(404, $response->status());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['error' => 'Necessário ter cadastrado no mínimo 8 times para criar um campeonato!']),
            $response->getContent()
        );
    }

    public function test_readChampionshipIdExpectOk(): void
    {
        $mockModelChampionship = Mockery::mock(Championship::class);
        $mockModelTeams = Mockery::mock(Teams::class);
        $mockModelSubscribe = Mockery::mock(SubscribeChampionship::class);
        $mockModelQuarters = Mockery::mock(QuarterFinals::class);
        $mockModelPoints = Mockery::mock(Points::class);
        $mockModelFinals = Mockery::mock(Finals::class);
        $mockModelSemiFinals = Mockery::mock(SemiFinals::class);
        $mockModelSecondPlace = Mockery::mock(SecondPlace::class);
        $mockModelThirdPlace = Mockery::mock(ThirdPlace::class);
        $mockModelChampion = Mockery::mock(Champion::class);
        $mockModelPlayThird = Mockery::mock(PlayThirdPlace::class);

        $mockController = new ChampionshipController(
            $mockModelChampionship,
            $mockModelTeams,
            $mockModelSubscribe,
            $mockModelQuarters,
            $mockModelPoints,
            $mockModelFinals,
            $mockModelSemiFinals,
            $mockModelSecondPlace,
            $mockModelChampion,
            $mockModelPlayThird,
            $mockModelThirdPlace
        );

        $responseChampionshipMock = (array)[
            [
                "name" => "Brasileirao"
            ]
        ];

        $mockModelChampionship->shouldReceive('readChampionshipId')
            ->once()
            ->with(1)
            ->andReturn($responseChampionshipMock);

        $response = $mockController->readChampionshipId(1);

        $this->assertEquals(200, $response->status());
    }

    public function test_readChampionshipIdExpectError(): void
    {
        $mockModelChampionship = Mockery::mock(Championship::class);
        $mockModelTeams = Mockery::mock(Teams::class);
        $mockModelSubscribe = Mockery::mock(SubscribeChampionship::class);
        $mockModelQuarters = Mockery::mock(QuarterFinals::class);
        $mockModelPoints = Mockery::mock(Points::class);
        $mockModelFinals = Mockery::mock(Finals::class);
        $mockModelSemiFinals = Mockery::mock(SemiFinals::class);
        $mockModelSecondPlace = Mockery::mock(SecondPlace::class);
        $mockModelThirdPlace = Mockery::mock(ThirdPlace::class);
        $mockModelChampion = Mockery::mock(Champion::class);
        $mockModelPlayThird = Mockery::mock(PlayThirdPlace::class);

        $mockController = new ChampionshipController(
            $mockModelChampionship,
            $mockModelTeams,
            $mockModelSubscribe,
            $mockModelQuarters,
            $mockModelPoints,
            $mockModelFinals,
            $mockModelSemiFinals,
            $mockModelSecondPlace,
            $mockModelChampion,
            $mockModelPlayThird,
            $mockModelThirdPlace
        );

        $responseChampionshipMock = (array)[];

        $mockModelChampionship->shouldReceive('readChampionshipId')
            ->once()
            ->with(1)
            ->andReturn($responseChampionshipMock);

        $response = $mockController->readChampionshipId(1);

        $this->assertEquals(404, $response->status());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['error' => 'Campeonato não encontrado, tente novamente mais tarde!']),
            $response->getContent()
        );
    }

    public function test_readChampionshipsExpectOk(): void
    {
        $mockModelChampionship = Mockery::mock(Championship::class);
        $mockModelTeams = Mockery::mock(Teams::class);
        $mockModelSubscribe = Mockery::mock(SubscribeChampionship::class);
        $mockModelQuarters = Mockery::mock(QuarterFinals::class);
        $mockModelPoints = Mockery::mock(Points::class);
        $mockModelFinals = Mockery::mock(Finals::class);
        $mockModelSemiFinals = Mockery::mock(SemiFinals::class);
        $mockModelSecondPlace = Mockery::mock(SecondPlace::class);
        $mockModelThirdPlace = Mockery::mock(ThirdPlace::class);
        $mockModelChampion = Mockery::mock(Champion::class);
        $mockModelPlayThird = Mockery::mock(PlayThirdPlace::class);

        $mockController = new ChampionshipController(
            $mockModelChampionship,
            $mockModelTeams,
            $mockModelSubscribe,
            $mockModelQuarters,
            $mockModelPoints,
            $mockModelFinals,
            $mockModelSemiFinals,
            $mockModelSecondPlace,
            $mockModelChampion,
            $mockModelPlayThird,
            $mockModelThirdPlace
        );

        $responseMockChampionships = (array)[
            [
                "name" => "Brasileirao"
            ],
            [
                "name" => "Copa América"
            ]
        ];

        $mockModelChampionship->shouldReceive('readChampionships')
            ->once()
            ->andReturn($responseMockChampionships);

        $response = $mockController->readChampionships();

        $this->assertEquals(200, $response->status());
    }

    public function test_readChampionshipsExpectError(): void
    {
        $mockModelChampionship = Mockery::mock(Championship::class);
        $mockModelTeams = Mockery::mock(Teams::class);
        $mockModelSubscribe = Mockery::mock(SubscribeChampionship::class);
        $mockModelQuarters = Mockery::mock(QuarterFinals::class);
        $mockModelPoints = Mockery::mock(Points::class);
        $mockModelFinals = Mockery::mock(Finals::class);
        $mockModelSemiFinals = Mockery::mock(SemiFinals::class);
        $mockModelSecondPlace = Mockery::mock(SecondPlace::class);
        $mockModelThirdPlace = Mockery::mock(ThirdPlace::class);
        $mockModelChampion = Mockery::mock(Champion::class);
        $mockModelPlayThird = Mockery::mock(PlayThirdPlace::class);

        $mockController = new ChampionshipController(
            $mockModelChampionship,
            $mockModelTeams,
            $mockModelSubscribe,
            $mockModelQuarters,
            $mockModelPoints,
            $mockModelFinals,
            $mockModelSemiFinals,
            $mockModelSecondPlace,
            $mockModelChampion,
            $mockModelPlayThird,
            $mockModelThirdPlace
        );

        $responseMockChampionships = (array)[];

        $mockModelChampionship->shouldReceive('readChampionships')
            ->once()
            ->andReturn($responseMockChampionships);

        $response = $mockController->readChampionships();

        $this->assertEquals(404, $response->status());
    }

    public function test_initializeChampionshipExpectOk(): void
    {
        $mockModelChampionship = Mockery::mock(Championship::class);
        $mockModelTeams = Mockery::mock(Teams::class);
        $mockModelSubscribe = Mockery::mock(SubscribeChampionship::class);
        $mockModelQuarters = Mockery::mock(QuarterFinals::class);
        $mockModelPoints = Mockery::mock(Points::class);
        $mockModelFinals = Mockery::mock(Finals::class);
        $mockModelSemiFinals = Mockery::mock(SemiFinals::class);
        $mockModelSecondPlace = Mockery::mock(SecondPlace::class);
        $mockModelThirdPlace = Mockery::mock(ThirdPlace::class);
        $mockModelChampion = Mockery::mock(Champion::class);
        $mockModelPlayThird = Mockery::mock(PlayThirdPlace::class);

        $mockController = new ChampionshipController(
            $mockModelChampionship,
            $mockModelTeams,
            $mockModelSubscribe,
            $mockModelQuarters,
            $mockModelPoints,
            $mockModelFinals,
            $mockModelSemiFinals,
            $mockModelSecondPlace,
            $mockModelChampion,
            $mockModelPlayThird,
            $mockModelThirdPlace
        );

        $responseQuarterMock = [];

        $returnResponseSubscribedMock = [
            1,
            2,
            3,
            4,
            5,
            6,
            7,
            8
        ];

        $quarterFinalsResponseMock = (array)[
            [
                "goals_team_1" => 1,
                "goals_team_2" => 0,
                "fk_team_1" => 1,
                "fk_team_2" => 2,
                "fk_championship" => 2
            ],
            [
                "goals_team_1" => 1,
                "goals_team_2" => 0,
                "fk_team_1" => 3,
                "fk_team_2" => 4,
                "fk_championship" => 2
            ],
            [
                "goals_team_1" => 1,
                "goals_team_2" => 0,
                "fk_team_1" => 5,
                "fk_team_2" => 6,
                "fk_championship" => 2
            ],
            [
                "goals_team_1" => 1,
                "goals_team_2" => 0,
                "fk_team_1" => 7,
                "fk_team_2" => 8,
                "fk_championship" => 2
            ]
        ];

        $idChampionshipMock = 1;

        $mockModelQuarters->shouldReceive('readQuarterByIdChampionship')
            ->once()
            ->with($idChampionshipMock)
            ->andReturn($responseQuarterMock);

        $mockModelSubscribe->shouldReceive('readTeamsSubscribedByChampionshipId')
            ->once()
            ->with($idChampionshipMock)
            ->andReturn($returnResponseSubscribedMock);

        $mockModelQuarters->shouldReceive('createPlayQuarter')
            ->once()
            ->with($returnResponseSubscribedMock)
            ->andReturn($quarterFinalsResponseMock);

        $mockModelPoints->shouldReceive('incrementPoint')
            ->times(1)
            ->with($quarterFinalsResponseMock[0]['fk_team_1'], $quarterFinalsResponseMock[0]['fk_championship'], $quarterFinalsResponseMock[0]['goals_team_1']);

        $mockModelPoints->shouldReceive('decrementPoint')
            ->times(1)
            ->with($quarterFinalsResponseMock[0]['fk_team_2'], $quarterFinalsResponseMock[0]['fk_championship'], $quarterFinalsResponseMock[0]['goals_team_1']);

        $response = $mockController->initializeChampionship($idChampionshipMock);
    }
}
