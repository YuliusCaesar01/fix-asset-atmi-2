<?php

namespace Modules\ManageTipe\Http\Controllers;

use App\Models\Kelompok;
use App\Models\Tipe;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule; // Make sure to import this at the top of your controller

class ManageTipeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    protected  $menu = 'Tipe';

    public function index()
    {
        $data = Tipe::get();
        return view('managetipe::index')->with(['tipe' => $data, 'menu' => $this->menu]);
    }

    public function detail($id_tipe)
    {
        $data = Tipe::findOrFail($id_tipe);
        $kelompok = Kelompok::where('id_tipe', $id_tipe)->get();
        return view("managetipe::detail")->with(['tipe' => $data, 'kelompok' => $kelompok, 'menu' => $this->menu]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('managetipe::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_tipe' => 'required|unique:tipes,nama_tipe_yayasan',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image if provided
        ]);
    
        // Check if validation fails
        if ($validator->fails()) {
            dd('error');// Redirect back with errors and input
        }
    
        // Generate new kode_tipe
        $kode_max = Tipe::max('kode_tipe') ?? 0; // Ensure $kode_max is initialized
        $kode_baru = str_pad($kode_max + 1, 2, '0', STR_PAD_LEFT);
    
        // Handle image upload
        $path = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'image_' . time() . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('foto/fixasetlist'); // Change to your desired path
            $image->move($imagePath, $imageName);
            $path = 'foto/fixasetlist/' . $imageName; // Store image path
        }
    
        // Create new Tipe
        $tipe = Tipe::create([
            'nama_tipe_yayasan' => $request->nama_tipe,
            'kode_tipe' => $kode_baru,
            'foto_tipe' => $path // Ensure this column exists in the database
        ]);
    
        return back()->with('success', 'Tipe data created successfully!');
    }
    

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($kode_tipe)
    {
        $tipe = Tipe::findOrFail($kode_tipe);
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Tipe',
            'data'    => $tipe
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('managetipe::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id_tipe)
{
    // Find the tipe by id_tipe
    $tipe = Tipe::findOrFail($id_tipe);

    // Validate input
    $request->validate([
        'nama_tipe' => [
            'required',
            'string',
            'max:255',
            Rule::unique('tipes', 'nama_tipe_yayasan')->ignore($id_tipe, 'id_tipe'), // Use 'id_tipe' for uniqueness validation
        ],
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image if provided
    ]);

    // Update tipe
    $tipe->nama_tipe_yayasan = $request->nama_tipe;

    // Handle image upload if provided
    if ($request->hasFile('image')) {
        // Remove old image if necessary (optional)
        // if ($tipe->foto_tipe && file_exists(public_path($tipe->foto_tipe))) {
        //     unlink(public_path($tipe->foto_tipe));
        // }

        $image = $request->file('image');
        $imageName = 'image_' . time() . '.' . $image->getClientOriginalExtension();
        $imagePath = public_path('foto/fixasetlist');
        $image->move($imagePath, $imageName);
        $tipe->foto_tipe = 'foto/fixasetlist/' . $imageName; // Update the path in the model
    }

    // Save changes to the database
    $tipe->save();

    // Redirect to the index page with a success message
    return back()->with('success', 'Data Tipe Berhasil Diubah.');
}

    
    
    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        // Find the record by its ID
        $record = Tipe::find($id);
        
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
