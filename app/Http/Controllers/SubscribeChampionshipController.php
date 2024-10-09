<?php

namespace App\Http\Controllers;

use App\Models\SubscribeChampionship;
use App\Models\Points;
use Exception;
use Illuminate\Http\Request;

class SubscribeChampionshipController extends Controller
{
    private $subscribe;
    private $points;

    public function __construct(
        SubscribeChampionship $subscribeChampionship,
        Points $point
    ) {
        $this->subscribe = $subscribeChampionship;
        $this->points = $point;
    }

    public function createSubscribe(Request $request): object
    {
        try {
            $responseSubscribe = $this->subscribe->createSubscribe($request);
            if (count($responseSubscribe) != 0) {
                $this->points->createPoints($responseSubscribe);
                return $this->responseOK($responseSubscribe);
            }
            return $this->error('Inscrição do time não pode ser concluída, tente novamnte mais tarde!');
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
