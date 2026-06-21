<?php

namespace App\Filament\Resources\Articles;

use App\Models\Article;
use Filament\Resources\Resource;
use App\Filament\Resources\Articles\Pages;
use App\Filament\Resources\Articles\Schemas\ArticleForm;
use App\Filament\Resources\Articles\Tables\ArticlesTable;
use Illuminate\Database\Eloquent\Builder;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

use UnitEnum;
use BackedEnum;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static string|UnitEnum|null $navigationGroup = 'Konten';

    protected static ?string $navigationLabel = 'Artikel';

    public static function form(Schema $schema): Schema
    {
        return ArticleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ArticlesTable::configure($table);
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
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}