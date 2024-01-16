<?php

namespace App\Filament\Pages;

// use Filament\Pages\Page;
use Filament\Forms\Form;
use Filament\Pages\Auth\Login;

use Filament\Forms\Components\TextInput;

class LoginPage extends Login
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    // protected static string $view = 'filament.pages.login-page';
    
    // public function form(Form $form): Form
    // {

    //     return $form
    //         ->schema([
    //             TextInput::make('username')
    //                 ->required()
    //                 ->maxLength(255),
    //         ]);
    // }
}
