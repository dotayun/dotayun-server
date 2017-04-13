<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get(
    '/',
    function () use ($app) {
        return $app->version();
    }
);
$app->group(
    [
        'prefix'    => 'steam',
        'namespace' => 'App\Http\Controllers\Steam'
    ],
    function () use ($app) {

        $app->get(
            'getPlayerSummariesV2',
            [
                'as'   => 'getPlayerSummariesV2',
                'uses' => 'ApiController@getPlayerSummariesV2'
            ]
        );
    }
);

$api = app('Dingo\Api\Routing\Router');
$api->group(
    [
        'version'   => 'v1',
        'prefix'    => 'steam',
        'namespace' => 'App\Http\Controllers\Steam'
    ],
    function () use ($api) {
        $api->get(
            'getPlayerSummaries/{steam_id}',
            [
                'as'   => 'getPlayerSummariesV2',
                'uses' => 'ApiController@getPlayerSummariesV2'
            ]
        );
        $api->get(
            'getFriendListV1/{steam_id}',
            [
                'as'   => 'GetFriendListV1',
                'uses' => 'ApiController@GetFriendListV1'
            ]
        );
    }
);


$app->post(
    'oauth/access_token',
    function () {
        return response()->json(app('oauth2-server.authorizer')->issueAccessToken());
    }
);
$api = app('Dingo\Api\Routing\Router');

$api->version(
    'v1',
    ['middleware' => 'api.auth'],
    function ($api) {
        $api->get(
            'users/~me',
            function () {
                $user = app('Dingo\Api\Auth\Auth')->user();
                return $user;
            }
        );
    }
);