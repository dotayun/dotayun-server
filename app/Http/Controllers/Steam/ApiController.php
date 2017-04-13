<?php

namespace App\Http\Controllers\Steam;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

require(__ROOT__ . '/../vendor/autoload.php');
class ApiController extends BaseController {
    //
    private $steam_setting = null;
    private $steam_client  = null;
    private $steam_user    = null;

    public function __construct() {
        $this->steam_setting = config('app.steam_setting');
        try {
            $this->steam_client = new \Zyberspace\SteamWebApi\Client($this->steam_setting['web_api_key']);
            $this->steam_user   = new \Zyberspace\SteamWebApi\Interfaces\ISteamUser($this->steam_client);

        } catch (\Exception $e) {
            $ret = [
                'status'  => 0,
                'message' => "调用steam api失败：{$e->getMessage()}"
            ];
            return response()->json($ret);
        }
    }

    public function getPlayerSummariesV2(\Dingo\Api\Http\Request $request, $steam_id) {
        $steam_id = trim($steam_id);
        $response = $this->steam_user->GetPlayerSummariesV2($steam_id);
        return response()->json($response);
    }

    public function getFriendListV1(\Dingo\Api\Http\Request $request, $steam_id) {
        $steam_id = trim($steam_id);
        $response = $this->steam_user->GetFriendListV1($steam_id);
        return response()->json($response);
    }
}
