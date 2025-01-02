<?php

namespace Modules\ManageUser\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Userdetail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    protected $menu = "Dashboard";
    public function index()
    {
        return view('manageuser::myprofile')->with(['menu' => $this->menu]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('manageuser::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function changePassword(Request $request)
    {
        // Validasi input
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed', // 'confirmed' otomatis akan mengecek password baru dan confirm password sama
        ]);

        // Ambil user yang sedang login
        $user = User::find($request->user_id);

        // Cek apakah password lama sesuai
        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->withErrors(['old_password' => 'Old password does not match our records.']);
        }

        // Update password baru
        $user->password = Hash::make($request->new_password);
        $user->save();
        return redirect()->back()->with('success', 'Password has been changed successfully!');

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('manageuser::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $user = Userdetail::find($id);
        if (!$user) {
            return redirect()->back()->withErrors('User not found');
        }
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request)
    {
        // Validate the request
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'nullable|in:laki-laki,perempuan',
            'no_induk_karyawan' => [
                'required',
                'string',
                'max:255',
                Rule::unique('userdetails')->ignore($request->input('id_user'), 'id_user'), // Tambahkan aturan ini
            ],
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Prepare the data for update or create
        $data = [
            'nama_lengkap' => $request->input('nama_lengkap'),
            'jenis_kelamin' => $request->input('jenis_kelamin'),
            'no_induk_karyawan' => $request->input('no_induk_karyawan'),
            'foto' => $this->handlePhotoUpload($request) ?? '' // Handle file upload
        ];
    
        // Update or create user details
        Userdetail::updateOrCreate(
            ['id_user' => $request->input('id_user')],
            $data
        );
    
        return redirect()->back()->with('success', 'User profile updated successfully!');
    }
    
    private function handlePhotoUpload(Request $request)
    {
        if ($request->hasFile('foto')) {
            $userDetails = Userdetail::find($request->input('id_user'));
    
            // Hapus foto lama jika ada
            if ($userDetails && $userDetails->foto && Storage::exists('public/photos/' . $userDetails->foto)) {
                Storage::delete('public/photos/' . $userDetails->foto);
            }
            
            // Simpan foto baru
            $file = $request->file('foto');
            $fileName = time() . '_' . $file->getClientOriginalName(); // Nama file unik dengan timestamp
            $file->storeAs('public/photos', $fileName); // Simpan ke folder 'public/photos'
    
            // Kembalikan nama file saja untuk disimpan di database
            return $fileName;
        }
    
        return null; // Kembalikan null jika tidak ada foto yang diunggah
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
