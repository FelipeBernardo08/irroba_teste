<?php

namespace Tests\Unit;

use Illuminate\Http\Request;
use Tests\TestCase;
use App\Http\Controllers\SubscribeChampionshipController;
use App\Models\SubscribeChampionship;
use App\Models\Points;
use Mockery;

class SubscribeChampionshipControllerTest extends TestCase
{

    public function test_errorSubscribeMethod(): void
    {
        $mockModelSubscribe = Mockery::mock(SubscribeChampionship::class);
        $mockModelPoints = Mockery::mock(Points::class);
        $mockController = new SubscribeChampionshipController($mockModelSubscribe, $mockModelPoints);

        $mockMessage = 'Erro ao fazer requisicao';
        $response = $mockController->error($mockMessage);

        $this->assertEquals(404, $response->status());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['error' => $mockMessage]),
            $response->getContent()
        );
    }

    public function test_createSubscribeExpectOk(): void
    {
        $mockModelSubscribe = Mockery::mock(SubscribeChampionship::class);
        $mockModelPoints = Mockery::mock(Points::class);
        $mockController = new SubscribeChampionshipController($mockModelSubscribe, $mockModelPoints);

        $requestMock = new Request([
            "fk_championship" => 1,
            "teams" => [
                1,
            ]
        ]);

        $mockModelSubscribe->shouldReceive('createSubscribe')
            ->with($requestMock['teams'][0], $requestMock['fk_championship'])
            ->times(count($requestMock['teams']))
            ->andReturn([1]);

        $mockModelPoints->shouldReceive('createPoints')
            ->with($requestMock['teams'][0], $requestMock['fk_championship'])
            ->times(count($requestMock['teams']));

        $response = $mockController->createSubscribe($requestMock);

        $this->assertEquals(200, $response->status());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['msg' => 'Times inscritos com sucesso']),
            $response->getContent()
        );
    }

    public function test_createSubscribeExpectError()
    {
        $mockModelSubscribe = Mockery::mock(SubscribeChampionship::class);
        $mockModelPoints = Mockery::mock(Points::class);
        $mockController = new SubscribeChampionshipController($mockModelSubscribe, $mockModelPoints);

        $requestMock = new Request([
            "fk_championship" => 1,
            "teams" => [
                1
            ]
        ]);

        $mockModelSubscribe->shouldReceive('createSubscribe')
            ->with($requestMock['teams'][0], $requestMock['fk_championship'])
            ->times(count($requestMock['teams']))
            ->andReturn([]);

        $mockModelPoints->shouldReceive('createPoints')
            ->times(0);

        $response = $mockController->createSubscribe($requestMock);

        $this->assertEquals(404, $response->status());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['error' => 'Erro ao inscrever times']),
            $response->getContent()
        );
    }
}
