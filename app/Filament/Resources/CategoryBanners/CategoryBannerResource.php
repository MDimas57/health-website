<?php

namespace App\Filament\Resources\CategoryBanners;

use App\Filament\Resources\CategoryBanners\Pages\CreateCategoryBanner;
use App\Filament\Resources\CategoryBanners\Pages\EditCategoryBanner;
use App\Filament\Resources\CategoryBanners\Pages\ListCategoryBanners;
use App\Filament\Resources\CategoryBanners\Schemas\CategoryBannerForm;
use App\Filament\Resources\CategoryBanners\Tables\CategoryBannersTable;
use App\Models\CategoryBanner;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;


class CategoryBannerResource extends Resource
{
    protected static ?string $model = CategoryBanner::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $navigationLabel = 'Banner Kategori';
    protected static string | \UnitEnum | null $navigationGroup = 'Banner Kategori';
    protected static ?string $recordTitleAttribute = 'categorybanner';

    public static function form(Schema $schema): Schema
    {
        return CategoryBannerForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CategoryBannersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
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
            'index' => ListCategoryBanners::route('/'),
            'create' => CreateCategoryBanner::route('/create'),
            'edit' => EditCategoryBanner::route('/{record}/edit'),
        ];
    }
}
