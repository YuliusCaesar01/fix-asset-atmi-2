<?php

namespace Modules\ManageFixaset\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use App\Models\PermintaanFixedAsset;


class ManageFixasetController extends Controller
{
    /**
     * Display a listing of the resource.
     */    protected  $menu = 'FixAset';

    public function index()
    {
        $data = PermintaanFixedAsset::get();

        return view('managefixaset::index')->with(['fixedaset' => $data,'menu' => $this->menu]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('managefixaset::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('managefixaset::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('managefixaset::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
