<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Field;

class TableEditor extends Field
{
    protected string $view = 'filament.forms.components.table-editor';

    protected function setUp(): void
    {
        parent::setUp();

        $this->default([
            'headers' => [
                'Kolom 1',
                'Kolom 2',
                'Kolom 3',
            ],

            'rows' => [
                ['', '', ''],
                ['', '', ''],
                ['', '', ''],
            ],
        ]);
    }
}