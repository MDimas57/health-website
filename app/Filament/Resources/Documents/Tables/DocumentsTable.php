<?php

namespace App\Filament\Resources\Documents\Tables;

use Filament\Tables\Table;

use App\Models\Category;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;

use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;
class DocumentsTable
{
    public static function configure(Table $table): Table
    {
        return $table

            ->columns([

                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(40)
                    ->weight('bold'),

                TextColumn::make('document_file')
                    ->label('Tipe Dokumen')
                    ->alignCenter()
                    ->formatStateUsing(function ($state) {

                        $extension = strtolower(pathinfo($state, PATHINFO_EXTENSION));

                        return match ($extension) {

                            'pdf' => 'pdf',

                            'doc',
                            'docx' => 'doc',

                            'ppt',
                            'pptx' => 'ppt',

                            default => '📄',

                        };

                    }),

                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->sortable()
                    ->searchable(),

                TextColumn::make('download_count')
                    ->label('Download')
                    ->sortable()
                    ->badge()
                    ->color('success'),

                TextColumn::make('status')
                    ->badge()
                    ->colors([

                        'gray' => 'draft',

                        'success' => 'published',

                        'danger' => 'archived',

                    ]),
                TextColumn::make('published_at')
                    ->label('Publish')
                    ->dateTime('d M Y')
                    ->sortable(),

            ])

            ->filters([

                SelectFilter::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name'),

                SelectFilter::make('status')
                    ->options([

                        'draft' => 'Draft',

                        'published' => 'Published',

                        'archived' => 'Archived',

                    ]),

            ])

            ->recordActions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])

            ->toolbarActions([

                BulkActionGroup::make([

                    DeleteBulkAction::make(),

                ]),

            ]);
    }
}