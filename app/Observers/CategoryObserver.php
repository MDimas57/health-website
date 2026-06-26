<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {
        // Tidak melakukan apa pun.
    }

    public function updated(Category $category): void
    {
        //
    }

    public function deleted(Category $category): void
    {
        //
    }

    public function restored(Category $category): void
    {
        //
    }

    public function forceDeleted(Category $category): void
    {
        //
    }
}