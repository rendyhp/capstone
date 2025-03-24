<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Dataset;
use App\Models\Publication;
use Livewire\WithPagination;


class MainController extends Controller
{
    use WithPagination;

    public $search;

    protected $updatesQueryString = [
        ['search' => ['except' => '']]
    ];

    public function mount()
    {
        $this->search = request()->query('search', $this->search);
    }

    public function index()
    {
        return view('pages.guest.main.index');
    }

    public function dataset(Request $request)
    {
        $tagIds = $request->input('tags');
        $tagAll = Tag::all();

        $countDataset = Dataset::count();

        // if (!isset($tagIds)) {
        //     // Handle jika tagIds adalah null
        //     $datasets = Dataset::whereNull('deleted_at')
        //         ->join('tags', 'datasets.tag_id', '=', 'tags.id')
        //         ->select('datasets.*', 'tags.tag', 'tags.definition')
        //         ->orderBy('data_year', 'desc')
        //         ->orderBy('updated_at', 'desc')
        //         ->paginate(10);
        // } else {
        //     // Filter data berdasarkan tag yang dipilih
        //     $datasets = Dataset::whereNull('deleted_at')
        //         ->join('tags', 'datasets.tag_id', '=', 'tags.id')
        //         ->select('datasets.*', 'tags.tag', 'tags.definition')
        //         ->whereIn('tags.id', $tagIds)
        //         ->orderBy('data_year', 'desc')
        //         ->orderBy('updated_at', 'desc')
        //         ->paginate(10);
        // }

        $datasets = $this->search === null ?
            Dataset::whereNull('deleted_at')
            ->join('tags', 'datasets.tag_id', '=', 'tags.id')
            ->select('datasets.*', 'tags.tag', 'tags.definition')
            ->orderBy('updated_at', 'desc')
            ->orderBy('data_year', 'desc')
            ->paginate(10) :
            Dataset::whereNull('deleted_at')
            ->join('tags', 'datasets.tag_id', '=', 'tags.id')
            ->select('datasets.*', 'tags.tag', 'tags.definition')
            ->orderBy('updated_at', 'desc')
            ->orderBy('data_year', 'desc')
            ->where('title', 'like', '%' . $this->search . '%')->paginate(10);

        return view('pages.guest.main.dataset', [
            'datasets' => $datasets,
            'tags' => $tagAll,
            'countDataset' => $countDataset
        ]);
    }

    public function cariDataset(Request $request)
    {
        $tagAll = Tag::all();
        $countDataset = Dataset::count();

        $datasets = Dataset::whereNull('deleted_at')
            ->join('tags', 'datasets.tag_id', '=', 'tags.id')
            ->select('datasets.*', 'tags.tag', 'tags.definition')
            ->orderBy('updated_at', 'desc')
            ->orderBy('data_year', 'desc')
            ->where('title', 'like', '%' . $request->keyword . '%')
            ->orWhere('tag', 'like', '%' . $request->keyword . '%')
            ->orWhere('data_year', 'like', '%' . $request->keyword . '%')
            ->paginate(10);

        return view(
            'pages.guest.main.dataset',
            ['datasets' => $datasets, 'tags' => $tagAll, 'countDataset' => $countDataset, 'keyword' => $request->keyword]

        );
    }

    public function datasetShow($slug)
    {
        $datasetsRec = Dataset::whereNull('deleted_at')
            ->join('tags', 'datasets.tag_id', '=', 'tags.id')
            ->select('datasets.*', 'tags.tag', 'tags.definition')
            ->orderBy('updated_at', 'desc')
            ->paginate(6);

        $datasets = Dataset::where('slug', $slug)
            ->join('tags', 'datasets.tag_id', '=', 'tags.id')
            ->select('datasets.*', 'tags.tag', 'tags.definition')
            ->first();

        return view('pages.guest.main.showDataset', [
            'datasets' => $datasets, 'latestData' => $datasetsRec
        ]);
    }

    public function publication()
    {
        $publications = $this->search === null ?
            Publication::whereNull('deleted_at')
            ->orderBy('data_year', 'desc')
            ->orderBy('updated_at', 'desc')
            ->paginate(10) :
            Publication::whereNull('deleted_at')
            ->orderBy('data_year', 'desc')
            ->orderBy('updated_at', 'desc')
            ->where('title', 'like', '%' . $this->search . '%')->paginate(10);

        return view('pages.guest.main.publication', [
            'publications' => $publications
        ]);
    }

    public function publicationShow($slug)
    {
        $publicationsRec = Publication::whereNull('deleted_at')
            ->orderBy('updated_at', 'desc')
            ->paginate(6);
        $publications = Publication::where('slug', $slug)
            ->first();

        return view('pages.guest.main.showPublication', [
            'publications' => $publications, 'latestData' => $publicationsRec
        ]);
    }
}
