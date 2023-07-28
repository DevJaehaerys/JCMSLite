<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
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
        return response()->json($serverInfo);
    }

    public function leaders(Request $request)
    {
        $sort = $request->input('sort', 'UserID');
        $order = $request->input('order', 'asc');
        $search = $request->input('search', '');
        $exclude = ['Admin'];

        $limit = $request->input('limit', 10);

        if (!in_array($sort, $exclude)) {
            $players = DB::table('playerranksdb')
                ->orderBy($sort, $order);

            if (!empty($search)) {
                $players->where(function($query) use ($search) {
                    $query->where('UserID', 'LIKE', '%'.$search.'%')
                        ->orWhere('Name', 'LIKE', '%'.$search.'%');
                });
            }

            foreach ($exclude as $column) {
                $players->select(array_diff((array)DB::raw('playerranksdb.*'), [$column]));
            }

            $players = $players->paginate($limit);

            return response()->json($players);
        } else {
            return response()->json(['error' => 'Invalid sorting column.'], 400);
        }
    }

}
