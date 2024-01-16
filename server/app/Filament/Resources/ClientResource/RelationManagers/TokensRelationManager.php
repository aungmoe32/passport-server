<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use App\Models\AccessToken;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Laravel\Passport\RefreshTokenRepository;
use Laravel\Passport\TokenRepository;

class TokensRelationManager extends RelationManager
{
    protected static string $relationship = 'tokens';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('id')->limit(5),
                Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\TextColumn::make('created_at')
    // ->since()
    ->sortable(),
                Tables\Columns\IconColumn::make('revoked')->boolean(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('revoke')
                    ->hidden(fn (AccessToken $record): bool => $record->revoked)
                    ->action(function (AccessToken $record) {
                        // $record->revoked = !$record->revoked;
                        // $record->save();
                        if ($record->user->id === auth()->id()) {
                            $tokenId = $record->id;
                            $tokenRepository = app(TokenRepository::class);
                            $refreshTokenRepository = app(RefreshTokenRepository::class);
                            $tokenRepository->revokeAccessToken($tokenId);
                            $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($tokenId);
                        }
                    })
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
