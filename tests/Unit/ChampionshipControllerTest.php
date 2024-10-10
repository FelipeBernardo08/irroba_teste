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

        $this->assertEquals($result, $returnResponseSubscribedMock[0]['fk_team']);
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

        $this->assertEquals($result, $returnResponseSubscribedMock[1]['fk_team']);
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

    public function test_getLosersExpectReturnValidArray(): void {}
}
