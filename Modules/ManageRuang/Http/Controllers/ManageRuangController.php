<?php

namespace Modules\ManageRuang\Http\Controllers;

use App\Models\Ruang;
use App\Models\Divisi;
use App\Models\Lokasi;
use App\Models\Institusi;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Support\Renderable;

class ManageRuangController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    protected $menu = 'Ruang';
    public function index()
    {
        $data = $ruang = Ruang::all();
        $institusi = Institusi::all();
        return view('manageruang::index')->with([
            'ruang' => $ruang,
            'institusi' => $institusi, // Include 'institusi' if needed
            'menu' => $this->menu,
        ]);
    }

    public function detail(string $id_ruang)
    {
        $ruang = Ruang::findOrFail($id_ruang);
        $lokasi = Lokasi::where('id_lokasi', $ruang->id_lokasi)->get();
        return view("manageruang::detail")->with(['ruang' => $ruang,'lokasi' => $lokasi, 'menu' => $this->menu]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('manageruang::create');
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
            'nama_institusi' => 'nullable|string|',
            'nama_ruang' => 'nullable|string|',
            'nama_yayasan' => 'nullable|string|unique:ruangs,nama_ruang_yayasan',
            'nama_mikael' => 'nullable|string|unique:ruangs,nama_ruang_mikael',
            'nama_politeknik' => 'nullable|string|unique:ruangs,nama_ruang_politeknik',
            'nama_pt_atmi_solo' => 'nullable|string|unique:ruangs,nama_ruang_pt_atmi_solo',
            'image' => 'nullable|image|max:2048', // Validate the image
        ]);
    
        // Check if validation fails
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput(); // Redirect back with errors and input
        }
    
        // Determine the next ID to use
        $idToUse = Ruang::max('id_ruang') + 1;
    
        // Initialize image path
        $imagePath = null;
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'image_' . time() . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('foto/fixasetlist/' . $imageName); // Set the path
    
            // Move the uploaded file to the specified path
            $image->move(public_path('foto/fixasetlist'), $imageName);
        }
        // Determine the count of existing rooms with the same 'nama_institusi'
    $roomCount = Ruang::where('nama_institusi', $request->nama_institusi)->count();
    $kodeRuang = str_pad($roomCount + 1, 3, '0', STR_PAD_LEFT); // Increment count and format with leading zeros
        // Create the record
        $ruang = Ruang::create([
            'id_ruang' => $idToUse,
            'id_institusi' => $request->id_institusi,
            'nama_institusi' => $request->nama_institusi,
            'nama_ruang' => $request->nama_ruang,
            'nama_ruang_yayasan' => $request->nama_yayasan,
            'nama_ruang_mikael' => $request->nama_mikael,
            'nama_ruang_politeknik' => $request->nama_politeknik,
            'nama_ruang_pt_atmi_solo' => $request->nama_pt_atmi_solo,
            'foto_ruang' => $imagePath,
            'kode_ruang' => $kodeRuang,
        ]);

    
        // Update the record with the generated kode_ruang and default names
        $ruang->update([
            'kode_ruang' => $kodeRuang,
        ]);
    
        // Redirect back with success message
        return redirect()->back()->with('success', 'Data Ruang telah ditambahkan sukses!');
    }
    

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id_ruang)
    {
        $ruang = Ruang::findOrFail($id_ruang);
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Ruang',
            'data'    => $ruang
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('manageruang::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_ruang_yayasan' => 'required|string|max:255',
            'nama_ruang_mikael' => 'required|string|max:255',
            'nama_ruang_politeknik' => 'required|string|max:255',
            'gambar_ruang' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
        ]);
    
        // Jika validasi gagal, kembalikan kesalahan
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        // Temukan ruang berdasarkan ID
        $ruang = Ruang::findOrFail($id);
    
        // Handle image upload
        if ($request->hasFile('gambar_ruang')) {
            $image = $request->file('gambar_ruang');
            $imageName = 'image_' . time() . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('foto/fixasetlist');
            $image->move($imagePath, $imageName);
    
            // Update the image path in the database
            $ruang->foto_ruang = 'foto/fixasetlist/' . $imageName;
        }
    
        // Update data ruang
        $ruang->update([
            'nama_ruang_yayasan' => $request->nama_ruang_yayasan,
            'nama_ruang_mikael' => $request->nama_ruang_mikael,
            'nama_ruang_politeknik' => $request->nama_ruang_politeknik,
        ]);
    
        return redirect()->back()->with('success', 'Data ruang berhasil diupdate!');
    }
    

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
{
    // Find the record by its ID
    $record = Ruang::find($id);
    
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
