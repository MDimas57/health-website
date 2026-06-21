<?php

namespace App\Filament\Resources\Videos;

use App\Models\Video;
use Filament\Resources\Resource;
use App\Filament\Resources\Videos\Pages;
use App\Filament\Resources\Videos\Schemas\VideoForm;
use App\Filament\Resources\Videos\Tables\VideosTable;

use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

use UnitEnum;
use BackedEnum;

class VideoResource extends Resource
{
    protected static ?string $model = Video::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-play-circle';

    protected static string|UnitEnum|null $navigationGroup = 'Konten';

    protected static ?string $navigationLabel = 'Video';

    public static function form(Schema $schema): Schema
    {
        return VideoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VideosTable::configure($table);
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
            'index' => Pages\ListVideos::route('/'),
            'create' => Pages\CreateVideo::route('/create'),
            'edit' => Pages\EditVideo::route('/{record}/edit'),
        ];
    }
}