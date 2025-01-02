<?php

namespace Modules\ManageLokasi\Http\Controllers;

use App\Models\Lokasi;
use App\Models\Ruang;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class ManageLokasiController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    protected $menu = 'Lokasi';
    public function index()
    {
        $data = Lokasi::get();
        return view('managelokasi::index')->with(['lokasi' => $data, 'menu' => $this->menu]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('managelokasi::create');
    }

    public function detail(string $id_lokasi)
    {
        $lokasi = Lokasi::findOrFail($id_lokasi);
        $ruang = Ruang::where('id_lokasi', $id_lokasi)->get();
        return view("managelokasi::detail")->with(['lokasi' => $lokasi, 'ruang' => $ruang, 'menu' => $this->menu]);
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
            'nama_lokasi' => 'required|string|unique:lokasis,nama_lokasi_yayasan',
            'keterangan_lokasi' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
        ]);
    
        // Check if validation fails
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput(); // Redirect back with errors and input
        }
    
        $idToUse = Lokasi::max('id_lokasi') + 1;
    
     
    
         // Handle image upload
         if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'image_' . time() . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('foto/fixasetlist/' . $imageName); // Set the path
    
            // Move the uploaded file to the specified path
            $image->move(public_path('foto/fixasetlist'), $imageName);
        }
    
    
        // Create a new location record
        $lokasi = Lokasi::create([
            'id_lokasi' => $idToUse,
            'nama_lokasi_yayasan' => $request->nama_lokasi,
            'keterangan_lokasi' => $request->keterangan_lokasi,
            'kode_lokasi' => '', // Temporary default value
            'foto_lokasi' => $imagePath // Ensure the database column exists
        ]);
    
        // Generate kode_lokasi based on the ID
        $kodeLokasi = str_pad($lokasi->id_lokasi, 2, '0', STR_PAD_LEFT); // Pad with leading zeros if needed
    
        // Update the record with the generated kode_lokasi
        $lokasi->update([
            'kode_lokasi' => $kodeLokasi,
        ]);
    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Data lokasi telah ditambahkan!');
    }
    

    
    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id_lokasi)
    {
        $lokasi = lokasi::find($id_lokasi);
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Lokasi',
            'data'    => $lokasi
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('managelokasi::edit');
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
        $validatedData = $request->validate([
            'nama_lokasi' => [
                'required',
                'string',
                'max:255',
                'unique:lokasis,nama_lokasi_yayasan,' . $id . ',id_lokasi',
            ],
            'keterangan_lokasi' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
        ]);
    
        // Cari lokasi berdasarkan ID
        $lokasi = Lokasi::findOrFail($id);
    
        // Update data lokasi
        $lokasi->nama_lokasi_yayasan = $validatedData['nama_lokasi'];
        $lokasi->keterangan_lokasi = $validatedData['keterangan_lokasi'] ?? $lokasi->keterangan_lokasi; // Keep old if not provided
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'image_' . time() . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('foto/fixasetlist');
            $image->move($imagePath, $imageName);
            $lokasi->foto_lokasi = 'foto/fixasetlist/' . $imageName; // Update image path
        }
    
        // Simpan perubahan ke database
        $lokasi->save();
    
        return redirect()->back()->with('success', 'Data lokasi telah diupdate!');
    }
    

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        // Find the record by its ID
        $record = Lokasi::find($id);
        
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
