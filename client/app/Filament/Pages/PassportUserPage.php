<?php

namespace App\Filament\Pages;

use Barryvdh\Debugbar\Facades\Debugbar;
use Filament\Pages\Page;
use GuzzleHttp\Client;

class PassportUserPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static string $view = 'filament.pages.passport-user-page';

    protected static ?string $title = 'Passport User';

    public $user = null;
    public $connected = true;

    public function mount()
    {

        if(!auth()->user()->token){
            $this->connected = false;
            return;
        }


        $http = new Client();

        try {
            $response = $http->get(env('API_URL') . '/v1/user', [
                'headers' =>
                [
                    'Authorization' => "Bearer " . auth()->user()->token,
                ]
            ]);
            $apiResponse = json_decode((string) $response->getBody(), true);
            // $this->user = ((string) $response->getBody());
            $this->user = $apiResponse;
            if(!$apiResponse){
                auth()->logout();
                session()->forget('password_hash_web');
            }

        } catch (\Exception $e) {
            auth()->logout();
            session()->forget('password_hash_web');

        }
    }
}
