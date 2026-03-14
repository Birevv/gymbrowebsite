<?php

namespace App\Filament\Resources\Levels;

use App\Filament\Resources\Levels\Pages\CreateLevel;
use App\Filament\Resources\Levels\Pages\EditLevel;
use App\Filament\Resources\Levels\Pages\ListLevels;
use App\Filament\Resources\Levels\Schemas\LevelForm;
use App\Filament\Resources\Levels\Tables\LevelsTable;
use App\Models\Level;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class LevelResource extends Resource
{
    protected static ?string $model = Level::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Level';

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLevels::route('/'),
            'create' => CreateLevel::route('/create'),
            'edit' => EditLevel::route('/{record}/edit'),
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Input Nama Level (Wajib)
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Level Name'),

                // Input Urutan Level (Untuk mengurutkan dari termudah ke tersulit)
                TextInput::make('order_priority')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->label('Order Priority'),

                // Input Deskripsi (Opsional)
                Textarea::make('description')
                    ->label('Level Description')
                    ->columnSpanFull(),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Menampilkan Nama Level
                TextColumn::make('name')
                    ->label('Level Name')
                    ->searchable()  // Membuat kolom ini bisa dicari di kotak pencarian
                    ->sortable(),   // Membuat kolom ini bisa diurutkan (A-Z)

                // Menampilkan Urutan Prioritas
                TextColumn::make('order_priority')
                    ->label('Order')
                    ->sortable()
                    ->badge(),      // Opsional: Membuat tampilannya seperti label/badge

                // Menampilkan Deskripsi (dibatasi 50 karakter agar tabel tidak kepanjangan)
                TextColumn::make('description')
                    ->label('Description')
                    ->limit(50)
                    ->searchable(),
            ])
            ->filters([
                // ... biarkan bawaannya ...
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
