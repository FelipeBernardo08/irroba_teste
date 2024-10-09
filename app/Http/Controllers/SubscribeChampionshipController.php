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
            foreach ($request['teams'] as $key => $team) {
                $responseSubscribe = $this->subscribe->createSubscribe($team, $request->fk_championship);
                if (count($responseSubscribe) != 0) {
                    $this->points->createPoints($team, $request->fk_championship);
                }
                if (($key + 1) == count($request['teams'])) {
                    return response()->json(['msg' => 'Times inscritos com sucesso'], 200);
                }
            }
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
