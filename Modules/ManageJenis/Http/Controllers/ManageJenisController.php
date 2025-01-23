<?php

namespace Modules\ManageJenis\Http\Controllers;

use Log;
use App\Models\Jenis;
use App\Models\Kelompok;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Support\Renderable;

class ManageJenisController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    protected $menu = 'Jenis';

    public function index()
    {
        $data = Jenis::orderBy('id_jenis', 'asc')->get();
        $kelompok = Kelompok::get();
        return view('managejenis::index')->with(['jenis' => $data, 'kelompok' => $kelompok, 'menu' => $this->menu]);
    }

    public function detail(string $id_jenis)
    {
        $jenis = Jenis::findOrFail($id_jenis);
        $kelompok = $jenis->kelompok;
        return view("managejenis::detail")->with(['jenis' => $jenis, 'kelompok' => $kelompok, 'menu' => $this->menu]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('managejenis::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    
     public function store(Request $request)
{
    try {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'id_kelompok' => 'required|exists:kelompoks,id_kelompok',
            'nama_jenis_yayasan' => 'required|string|unique:jenis,nama_jenis_yayasan',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Get the next id_jenis
        $idToUse = Jenis::max('id_jenis') + 1;

        // Get kelompok data
        $kelompok = Kelompok::find($request->id_kelompok);

        // Add debugging
        \Log::info('Attempting to create Jenis with:', [
            'id_jenis' => $idToUse,
            'id_kelompok' => $request->id_kelompok,
            'nama_kelompok_yayasan' => $kelompok->nama_kelompok_yayasan,
            'nama_jenis_yayasan' => $request->nama_jenis_yayasan,
        ]);

        // Create a new record in the jenis table
        $jenis = new Jenis();
        $jenis->id_jenis = $idToUse;
        $jenis->id_kelompok = $request->id_kelompok;
        $jenis->nama_kelompok_yayasan = $kelompok->nama_kelompok_yayasan;
        $jenis->nama_jenis_yayasan = $request->nama_jenis_yayasan;
        
        if (!$jenis->save()) {
            \Log::error('Failed to save Jenis');
            return back()->with('error', 'Failed to save data')->withInput();
        }

        Log::info('Jenis created successfully with ID: ' . $jenis->id_jenis);

        return redirect()->back()->with('success', 'Data jenis telah ditambahkan!');

    } catch (\Exception $e) {
        \Log::error('Error creating Jenis: ' . $e->getMessage());
        \Log::error($e->getTraceAsString());
        return back()->with('error', 'An error occurred while saving the data: ' . $e->getMessage())->withInput();
    }
}

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id_jenis)
    {
        $jenis = Jenis::findOrFail($id_jenis);
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Jenis',
            'data'    => $jenis
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('managejenis::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id_jenis)
    {
        $jenis = Jenis::findOrFail($id_jenis);
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nama_jenis' => 'required',
        ]);

        //check validation 
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //update jenis
        $jenis->update([
            'nama_jenis_yayasan' => $request->nama_jenis,
        ]);

        return redirect()->back()->with('success', 'Data jenis telah diupdate!');

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        // Find the record by its ID
        $record = Jenis::find($id);
        
        // Check if the record exists
        if ($record) {
            // Delete the record
            $record->delete();
            
            // Redirect back with a success message
            return redirect()->back()->with('success', 'Data telah dihapus.');
        }
    
        // If the record doesn't exist, redirect back with an error message
        return redirect()->back()->with('error', 'Data tidak ditemukan.');
    }
}
