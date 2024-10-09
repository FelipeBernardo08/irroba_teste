<?php

namespace App\Http\Controllers;

use App\Models\SubscribeChampionship;
use Exception;
use Illuminate\Http\Request;

class SubscribeChampionshipController extends Controller
{
    private $subscribe;

    public function __construct(SubscribeChampionship $subscribeChampionship)
    {
        $this->subscribe = $subscribeChampionship;
    }

    public function createSubscribe(Request $request): object
    {
        try {
            $responseSubscribe = $this->subscribe->createSubscribe($request);
            if (count($responseSubscribe) != 0) {
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
