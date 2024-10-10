<?php

use Illuminate\Http\Request;
use Tests\TestCase;
use App\Http\Controllers\TeamsController;
use App\Models\Teams;

class TeamsControllerTest extends TestCase
{
    public function test_responseOkMethod(): void
    {
        $mockModel = Mockery::mock(Teams::class);
        $mockController = new TeamsController($mockModel);

        $mockResponse = ["msg" => "Response OK"];
        $response = $mockController->responseOK($mockResponse);

        $this->assertEquals(200, $response->status());
        $this->assertJsonStringEqualsJsonString(
            json_encode($mockResponse),
            $response->getContent()
        );
    }

    public function test_errorMethod(): void
    {
        $mockModel = Mockery::mock(Teams::class);
        $mockController = new TeamsController($mockModel);

        $mockMessage = 'Erro ao fazer requisicao';
        $response = $mockController->error($mockMessage);

        $this->assertEquals(404, $response->status());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['error' => $mockMessage]),
            $response->getContent()
        );
    }

    public function test_readTeamIdExpectOk(): void
    {
        $id = 1;
        $mockResponse = ['teste'];

        $mockModel = Mockery::mock(Teams::class);
        $mockModel->shouldReceive('readTeamId')
            ->with($id)
            ->once()
            ->andReturn($mockResponse);

        $mockController = new TeamsController($mockModel);
        $response = $mockController->readTeamId($id);

        $this->assertEquals(200, $response->status());
        $this->assertJsonStringEqualsJsonString(
            json_encode($mockResponse),
            $response->getContent()
        );
    }

    public function test_readTeamsExpectOk(): void
    {
        $mockResponse = ['teste', 'teste2'];

        $mockModel = Mockery::mock(Teams::class);
        $mockModel->shouldReceive('readTeams')
            ->once()
            ->andReturn($mockResponse);

        $mockController = new TeamsController($mockModel);
        $response = $mockController->readTeams();

        $this->assertEquals(200, $response->status());
        $this->assertJsonStringEqualsJsonString(
            json_encode($mockResponse),
            $response->getContent()
        );
    }

    public function test_createTeamsExpectOk(): void
    {
        $mockRequest = new Request([
            "teams" => [
                "time1",
                "time2"
            ]
        ]);
        $mockModel = Mockery::mock(Teams::class);
        $mockModel->shouldReceive('createTeams')
            ->with($mockRequest['teams'])
            ->once()
            ->andReturn(true);
        $mockController = new TeamsController($mockModel);
        $response = $mockController->createTeams($mockRequest);

        $this->assertEquals(200, $response->status());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['msg' => 'Times registrados com sucesso!']),
            $response->getContent()
        );
    }

    public function test_readTeamIdExpectError(): void
    {
        $id = 1;
        $mockResponse = [];

        $mockModel = Mockery::mock(Teams::class);
        $mockModel->shouldReceive('readTeamId')
            ->with($id)
            ->once()
            ->andReturn($mockResponse);

        $mockController = new TeamsController($mockModel);
        $response = $mockController->readTeamId($id);

        $this->assertEquals(404, $response->status());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['error' => 'Time não encontrado, tente novamente mais tarde!']),
            $response->getContent()
        );
    }

    public function test_readTeamsExpectError(): void
    {
        $mockResponse = [];

        $mockModel = Mockery::mock(Teams::class);
        $mockModel->shouldReceive('readTeams')
            ->once()
            ->andReturn($mockResponse);

        $mockController = new TeamsController($mockModel);
        $response = $mockController->readTeams();

        $this->assertEquals(404, $response->status());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['error' => 'Times não encontrados, tente novamente mais tarde!']),
            $response->getContent()
        );
    }

    public function test_createTeamsExpectError(): void
    {
        $mockRequest = new Request([
            "teams" => []
        ]);

        $mockModel = Mockery::mock(Teams::class);
        $mockModel->shouldReceive('createTeams')
            ->with($mockRequest['teams'])
            ->once()
            ->andReturn(false);
        $mockController = new TeamsController($mockModel);
        $response = $mockController->createTeams($mockRequest);

        $this->assertEquals(404, $response->status());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['error' => 'Times não puderam ser cadastrados, tente novamente mais tarde!']),
            $response->getContent()
        );
    }
}
