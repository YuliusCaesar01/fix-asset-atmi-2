<?php

namespace Modules\ManageDivisi\Http\Controllers;

use App\Models\Divisi;
use App\Models\Institusi;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class ManageDivisiController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    protected  $menu = 'Divisi';
    public function index()
    {
        $data = Divisi::orderBy('id_institusi')->get();
        $institusi = Institusi::get();
        return view('managedivisi::index')->with(['divisi' => $data, 'institusi' => $institusi, 'menu' => $this->menu]);
    }

    public function detail(string $id_divisi)
    {
        $divisi = Divisi::findOrFail($id_divisi);
        $user = User::where('id_divisi', $id_divisi)->get();

        return view("managedivisi::detail")->with(['divisi' => $divisi, 'user' => $user, 'menu' => $this->menu]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('managedivisi::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_divisi' => 'required',
            'id_institusi' => 'required'
        ]);

        //check validation 
        if ($validator->fails()) {
            return response()->json($validator->error(), 422);
        }

        //kode tipe bertambah sesuai nomor max di tabel
        $kode_max = Divisi::where('id_institusi', $request->id_institusi)->max('kode_divisi');
        $kode_baru = str_pad($kode_max + 1, 2, '0', STR_PAD_LEFT);

        $divisi = Divisi::create([
            'nama_divisi' => $request->nama_divisi,
            'kode_divisi' => $kode_baru,
            'id_institusi' => $request->id_institusi,
        ]);

        //return response 
        return response()->json([
            'success' => true,
            'message' => 'Data divisi Berhasil Disimpan.',
            'data'    => $divisi
        ]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id_divisi)
    {
        $divisi = Divisi::findOrFail($id_divisi);
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Divisi',
            'data'    => $divisi
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('managedivisi::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id_divisi)
    {
        $divisi = Divisi::findOrFail($id_divisi);
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nama_divisi' => 'required',
        ]);

        //check validation 
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //update divisi
        $divisi->update([
            'nama_divisi' => $request->nama_divisi,
        ]);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data divisi Berhasil Diubah.',
            'data'    => $divisi
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
