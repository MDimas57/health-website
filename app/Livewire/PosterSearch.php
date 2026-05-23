<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Post;
use App\Models\Category;

class PosterSearch extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $q = '';
    public $category = null;
    public $sort = 'latest';

    protected $queryString = [
        'q' => ['except' => ''],
        'category' => ['except' => ''],
        'sort' => ['except' => 'latest'],
    ];

    public function updatingQ()
    {
        $this->resetPage();
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function updatingSort()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Post::query()
            ->where('type', 'poster')
            ->where('status', 'published')
            ->with('category');

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($this->q) {

            $query->where(function ($q) {

                $q->where('title', 'like', '%' . $this->q . '%')
                  ->orWhere('content', 'like', '%' . $this->q . '%');

            });

        }

        /*
        |--------------------------------------------------------------------------
        | CATEGORY
        |--------------------------------------------------------------------------
        */

        if ($this->category) {

            $query->where('category_id', $this->category);

        }

        /*
        |--------------------------------------------------------------------------
        | SORT
        |--------------------------------------------------------------------------
        */

        if ($this->sort === 'oldest') {

            $query->oldest('published_at');

        } elseif ($this->sort === 'popular') {

            $query->orderByDesc('views');

        } else {

            $query->latest('published_at');

        }

        return view('livewire.poster-search', [

            'posters' => $query->paginate(12),

            'categories' => Category::latest()->get(),

        ]);
    }
}