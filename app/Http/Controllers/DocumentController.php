<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Daftar Dokumen
     */
    public function index(Request $request)
    {
        $query = Document::with([
                'category',
                'user',
            ])
            ->where('status', 'published');

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $query->where(function ($q) use ($request) {

                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');

            });

        }

        /*
        |--------------------------------------------------------------------------
        | Filter Kategori
        |--------------------------------------------------------------------------
        */

        if ($request->filled('category')) {

            $query->whereHas('category', function ($q) use ($request) {

                $q->where('slug', $request->category);

            });

        }

        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */

        switch ($request->sort) {

            case 'oldest':

                $query->oldest('published_at');

                break;

            case 'popular':

                $query->orderByDesc('download_count');

                break;

            default:

                $query->latest('published_at');

                break;
        }

        $documents = $query
            ->paginate(12)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view(
            'public.documents.index',
            compact(
                'documents',
                'categories'
            )
        );
    }

    /**
     * Detail Dokumen
     */
    public function show($slug)
    {
        $document = Document::with([
                'category',
                'user',
            ])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $relatedDocuments = Document::with([
                'category',
                'user',
            ])
            ->where('category_id', $document->category_id)
            ->where('id', '!=', $document->id)
            ->where('status', 'published')
            ->latest('published_at')
            ->take(4)
            ->get();

        return view(
            'public.documents.show',
            compact(
                'document',
                'relatedDocuments'
            )
        );
    }

    /**
     * Download Dokumen
     */
    public function download($slug)
    {
        $document = Document::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Tambah jumlah download
        $document->increment('download_count');

        return Storage::disk('public')->download(
            $document->document_file,
            $document->title . '.' . pathinfo($document->document_file, PATHINFO_EXTENSION)
        );
    }
    public function preview($slug)
{
    $document = Document::where('slug', $slug)
        ->where('status', 'published')
        ->firstOrFail();

    $extension = strtolower(pathinfo($document->document_file, PATHINFO_EXTENSION));

    return view('public.documents.preview', compact(
        'document',
        'extension'
    ));
}
}