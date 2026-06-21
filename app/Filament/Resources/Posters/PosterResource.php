<?php

namespace App\Filament\Resources\Posters;

use App\Models\Poster;
use Filament\Resources\Resource;
use App\Filament\Resources\Posters\Pages;
use App\Filament\Resources\Posters\Schemas\PosterForm;
use App\Filament\Resources\Posters\Tables\PostersTable;

use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

use UnitEnum;
use BackedEnum;

class PosterResource extends Resource
{
    protected static ?string $model = Poster::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-photo';

    protected static string|UnitEnum|null $navigationGroup = 'Konten';

    protected static ?string $navigationLabel = 'Poster';

    public static function form(Schema $schema): Schema
    {
        return PosterForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PostersTable::configure($table);
    }
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (auth()->user()->hasRole('super_admin')) {
            return $query;
        }

        return $query->where(
            'category_id',
            auth()->user()->category_id
        );
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosters::route('/'),
            'create' => Pages\CreatePoster::route('/create'),
            'edit' => Pages\EditPoster::route('/{record}/edit'),
        ];
    }
}