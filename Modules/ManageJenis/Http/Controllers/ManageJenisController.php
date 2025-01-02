<?php

namespace Modules\ManageJenis\Http\Controllers;

use App\Models\Jenis;
use App\Models\Kelompok;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

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
         // Validate the incoming request data
         $validator = Validator::make($request->all(), [
             'id_kelompok' => 'required|exists:kelompoks,id_kelompok', // Ensure it exists in the kelompok table
             'nama_jenis_yayasan' => 'required|string|unique:jenis,nama_jenis_yayasan', // Ensure it is unique in jenis table
         ]);
              // Check if validation fails
    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput(); // Redirect back with errors and input
    }
           $idToUse = Jenis::max('id_jenis') + 1;
   
         // Create a new record in the jenis table
          $jenis = Jenis::create([
             'id_jenis' => $idToUse,
             'id_kelompok' => $request->id_kelompok,
             'nama_jenis_yayasan' => $request->nama_jenis_yayasan,
             'kode_jenis' => '' // Initial empty value for kode_jenis
         ]);
 
         // Generate kode_jenis based on the newly created id
         $kodeJenis = str_pad($jenis->id_jenis, 3, '0', STR_PAD_LEFT); // Pad with zeros to a length of 2
         $jenis->update(['kode_jenis' => $kodeJenis]); // Update the record with the generated kode_jenis
 
         // Redirect back with a success message
         return redirect()->back()->with('success', 'Data jenis telah ditambahkan!');
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
