<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WSController extends Controller
{
//    public function startRealTime(Request $request)
//    {
//        $server = $request->server;
//
//        $options = [
//            'cors' => true,
//        ];
//
//        $io = \Illuminate\Support\Facades\Redis::connection('default')->pubsub();
//
//        $io->on('connection', function ($client) use ($io) {
//            Log::info('Connected admin');
//
//            $client->on('presence', function ($data) use ($io) {
//                event(new PresenceEvent($data));
//                $this->addPresence($data)
//                    ->then(function () use ($io, $data) {
//                        $io->emit('success-scan', $data);
//                    })
//                    ->catch(function ($err) use ($io, $data) {
//                        Log::error($err);
//                        $io->emit('error-scan', $data);
//                    });
//            });
//        });
//
//        return response()->json(['success' => true]);
//    }
}
