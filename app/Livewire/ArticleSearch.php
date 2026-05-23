<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Article;
use App\Models\Category;

class ArticleSearch extends Component
{
    use WithPagination;

    public $q = '';
    public $category = null;
    public $sort = 'latest';

    protected $updatesQueryString = [
        'q',
        'category',
        'sort'
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
        $query = Article::with(['category', 'user'])
            ->where('status', 'published');

        // SEARCH
        if ($this->q) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->q . '%')
                  ->orWhere('content', 'like', '%' . $this->q . '%');
            });
        }

        // CATEGORY
        if ($this->category) {
            $query->where('category_id', $this->category);
        }

        // SORT
        if ($this->sort === 'popular') {
            $query->orderByDesc('views');
        } elseif ($this->sort === 'oldest') {
            $query->oldest('published_at');
        } else {
            $query->latest('published_at');
        }

      return view('livewire.article-search', [
            'articles' => $query->paginate(9),
            'categories' => Category::all()
        ]);
    }
}