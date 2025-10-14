<?php

namespace App\Http\Controllers;

use App\Models\PublicSeoTag;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSeoTagRequest;
use Illuminate\Support\Facades\Redirect;

class PublicSeoTagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.public_seo_tag.list', ['items' => PublicSeoTag::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.public_seo_tag.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateSeoTagRequest $request)
    {
        PublicSeoTag::create($request->toArray());
        return Redirect::route('public_seo_tags.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PublicSeoTag $publicSeoTag)
    {
        $publicSeoTag->delete();
    }
}
