<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Http\Controllers\Controller;
use App\Http\Requests\SetConfigRequest;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.config.create', ['config' => Config::first()]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function store(SetConfigRequest $request)
    {
        $config = Config::first();
        $config->about_me = $request->about_me;
        $config->save();
    }
}
