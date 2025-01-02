<?php

namespace Modules\ManageKelompok\Http\Controllers;

use App\Models\Jenis;
use App\Models\Kelompok;
use App\Models\Tipe;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class ManageKelompokController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    protected $menu = 'Kelompok';
    public function index()
    {
        $data = Kelompok::all();
        $tipe = Tipe::all();
        return view('managekelompok::index')->with(['kelompok' => $data, 'tipe' => $tipe, 'menu' => $this->menu]);
    }

    public function detail(string $id_kelompok)
    {
        $kelompok = Kelompok::findOrFail($id_kelompok);
        $tipe = $kelompok->tipe;
        return view("managekelompok::detail")->with(['kelompok' => $kelompok, 'tipe' => $tipe, 'menu' => $this->menu]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('managekelompok::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
{
    // Define the validation rules
    $validator = Validator::make($request->all(), [
        'nama_kelompok' => 'required|string|max:255|unique:kelompoks,nama_kelompok_yayasan', // Ensure unique nama_kelompok in kelompok table
        'tipe_kelompok' => 'required|exists:tipes,id_tipe',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        // Log the detailed validation errors
        \Log::error('Validation errors:', $validator->errors()->toArray());

        // Optionally dump the errors
        // dd($validator->errors()->toArray());

        return back()->withErrors($validator)->withInput(); // Redirect back with errors and input
    }

    try {
        $idToUse = Kelompok::max('id_kelompok') + 1;

        // Handle image upload
        $imagePath = null; // Initialize imagePath
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'image_' . time() . '.' . $image->getClientOriginalExtension();
            $imagePath = 'foto/fixasetlist/' . $imageName; // Set the relative path

            // Move the uploaded file to the specified path
            $image->move(public_path('foto/fixasetlist'), $imageName);
        }

        $kelompok = Kelompok::create([
            'id_kelompok' => $idToUse,
            'nama_kelompok_yayasan' => $request->nama_kelompok,
            'id_tipe' => $request->tipe_kelompok,
            'foto_kelompok' => $imagePath // Ensure the database column exists
        ]);

        // Generate kode_kelompok from the id
        $kode_kelompok = str_pad($kelompok->id_kelompok, 2, '0', STR_PAD_LEFT); // Pad with zeros to make it 2 digits

        // Update the Kelompok with the generated kode_kelompok
        $kelompok->update(['kode_kelompok' => $kode_kelompok]);

        // Return a successful response
        return redirect()->back()->with('success', 'Data kelompok telah ditambahkan!');

    } catch (\Exception $e) {
        // Handle any unexpected errors
        return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
    }
}


    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id_kelompok)
    {
        $kelompok = Kelompok::findOrFail($id_kelompok);
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Kelompok',
            'data'    => $kelompok
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('managekelompok::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id_kelompok)
    {
        // Mencari data kelompok berdasarkan ID
        $kelompok = Kelompok::findOrFail($id_kelompok);
    
        // Validasi input
        $request->validate([
            'nama_kelompok' => 'required|string|max:255',
        ]);
    
        // Update data kelompok
        $kelompok->update([
            'nama_kelompok' => $request->nama_kelompok,
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
        $record = Kelompok::find($id);
        
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
