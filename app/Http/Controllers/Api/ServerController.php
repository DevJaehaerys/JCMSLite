<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use xPaw\SourceQuery\Exception\InvalidArgumentException;
use xPaw\SourceQuery\Exception\InvalidPacketException;
use xPaw\SourceQuery\Exception\SocketException;
use xPaw\SourceQuery\SourceQuery;

class ServerController extends Controller
{
    /**
     * @throws SocketException
     * @throws InvalidPacketException
     * @throws InvalidArgumentException
     */
    public function serverData(){
        $myconfig = config('game');
        $server = array(
            'host' => $myconfig['ip'],
            'port' => $myconfig['port'],
            'timeout' => 1,
        );

        $query = new SourceQuery();
        $query->Connect($server['host'], $server['port'], $server['timeout'], SourceQuery::SOURCE);
        $serverInfo = $query->GetInfo();
        return response()->json($serverInfo['Players']);
    }
}
