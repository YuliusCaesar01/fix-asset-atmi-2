<?php

namespace Modules\ManageUser\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Userdetail;
use App\Models\User;
use App\Models\Notification;

use Illuminate\Support\Str; // Import Str class
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail; // Import your mailable class
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ManageUserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     
     */
    protected $menu = 'fixasetuser';
    protected $menu2 = 'nonfixasetuser';
    protected $menu3 = 'notifprofile';


    public function index(Request $request)
    {
// Ambil parameter 'type' dari query string

                $type = $request->input('type');

                // Filter pengguna berdasarkan tipe
                if ($type == 'fixaset') {
                    // Mengambil pengguna dengan role fixaset, misalnya role_id 14
                    $users = User::whereIn('role_id', [5,14,15,16,17,18,19])->get();
                    $navmenu = $this->menu;
                } else {
                    // Mengambil pengguna non-fixaset, role selain 14
                    $users = User::WhereNotIn('role_id', [14, 15, 16, 17, 18, 19])->get();
                    $navmenu = $this->menu2;

                    
                }
                

                // Kirim data pengguna ke view
                return view('manageuser::index', compact('users'))->with(['menu' => $navmenu ]);

}

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function lupapassword()
    {
        return view('manageuser::forgot_password'); // Optionally, you can just use the modal in your existing view.
    }

    // Handle the password reset link request
    public function sendResetLinkEmail(Request $request)
{
    // Validasi email input
    $request->validate([
        'email' => 'required|email',
    ]);

    // Cek apakah email ada di database
    $user = User::where('email', $request->email)->first();

    if (!$user) {
        // Jika tidak ada, kembalikan error
        return back()->withErrors(['email' => 'Email tidak ditemukan.']);
    }

    // Generate a random token
    $token = mt_rand(1000, 9999);
    
    // Simpan token ke kolom remember_token
    $user->remember_token = $token;
    $user->save();

    // Kirim email reset password dengan token
    Mail::to($user->email)->send(new ResetPasswordMail($user, $token));

    // Kembalikan dengan pesan sukses
    return back()->with('status', 'Link reset password telah dikirim ke email Anda.');
}
    
public function reset(Request $request)
{
    // Validate the request
    $request->validate([
        'password' => 'required|confirmed|min:8',
        'token' => 'required'
    ]);

    // Find the user associated with the token
    $userdata = User::where('remember_token', $request->token)->first();

    // If user not found, return an error
    if (!$userdata) {
        return back()->withErrors(['token' => __('Invalid token or user not found.')]);
    }

    // Update the user's password
    $userdata->password = bcrypt($request->password);
    $userdata->remember_token = null; // Clear the remember_token
    $userdata->save();

    // Redirect with success message
    return redirect()->route('login')->with('status', __('Password has been reset!'));
}




    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
{
    // Validate the request data
    $request->validate([
        'username' => 'required|string|max:255', // Add validation for username
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'role_id' => 'required|exists:roles,id',
        'divisi_id' => 'required|exists:divisis,id_divisi', // Ensure this matches your database
    ]);

    // Create a new user
    $user = User::create([
        'username' => $request->username, // Add username to the user creation
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role_id' => $request->role_id,
        'id_divisi' => $request->divisi_id // Add divisi_id here
    ]);

    // Optionally assign roles if using Spatie
    $user->assignRole($request->role_id);

    // Redirect or return a response
    return redirect()->route('manage-user.index')->with('success', 'User created successfully.');
}



    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function userdetails($id)
    {
        // Assuming userdetails is the model name, typically in PascalCase
        $userDetail = Userdetail::find($id);
    
        // Check if the user was found
        if (!$userDetail) {
            return redirect()->back()->with('error', 'User not found');
        }
    
        return view('manageuser::userdetails', [
            'menu' => $this->menu,
            'userdetailed' => $userDetail // Pass user details to the view
        ]);
    }
    

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edituserdetails(Request $request, $id)
{
    // Validate incoming request data
    $validatedData = $request->validate([
        'nama_lengkap' => 'required|string|max:255',
        'jenis_kelamin' => 'required|in:laki-laki,perempuan',
        'no_induk_karyawan' => 'required|string|max:50|unique:userdetails,no_induk_karyawan,' . $id . ',id_userdetail', // Unique validation
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Check if the user is being created or updated
    if ($id == 0) {
        // Create a new user detail
        $userDetail = new Userdetail();
        $userDetail->id_user = auth()->user()->id; // Get the authenticated user's ID
    } else {
        // Find the user by ID using the correct primary key
        $userDetail = Userdetail::where('id_userdetail', $id)->firstOrFail();
    }

    // Handle file upload for the photo
    if ($request->hasFile('foto')) {
        $file = $request->file('foto');
        // Generate a unique file name with timestamp
        $fileName = time() . '_' . $file->getClientOriginalName();

        // Move the file to the public/uploads/photos directory
        $file->move(public_path('uploads/photos'), $fileName);

        // Save the file path to the database (relative path)
        $userDetail->foto = 'uploads/photos/' . $fileName; 
    }

    // Update user details
    $userDetail->nama_lengkap = $validatedData['nama_lengkap'];
    $userDetail->jenis_kelamin = $validatedData['jenis_kelamin'];
    $userDetail->no_induk_karyawan = $validatedData['no_induk_karyawan'];

    // Save the changes
    $userDetail->save();

    // Redirect back with a success message
    return redirect()->route('manage-user.userdetails', $userDetail->id_userdetail)->with('success', 'User details updated successfully.');
}

    
    
public function send(Request $request)
{
    // Validate the input data (if needed)
    $request->validate([
        'id_user_pengirim' => 'required|exists:users,id',
        'id_user_penerima' => 'required|exists:users,id',
        'id_pengajuan' => 'nullable|exists:permintaan_fixed_assets,id_permintaan_fa',
        'keterangan_notif' => 'required|string|max:255',
        'jenis_notif' => 'required|string|max:50', // Validasi jenis_notif
    ]);

    // Create a new notification
    Notification::create([
        'id_user_pengirim' => $request->id_user_pengirim,
        'id_user_penerima' => $request->id_user_penerima,
        'id_pengajuan' => $request->id_pengajuan,
        'keterangan_notif' => $request->keterangan_notif,
        'jenis_notif' => $request->jenis_notif, // Menggunakan input dari request
    ]);

    // Redirect back with success message
    return back()->with('success', 'Notification sent successfully!');
}
    
    

    
public function deleteOldNotifications()
{
    $deletedCount = Notification::whereNotNull('read_at')
    ->where('read_at', '<=', now()->subDays(30))
    ->forceDelete();


}
public function getNotificationsCount() {
    $unreadCount = Notification::where('id_user_penerima', auth()->user()->id)
    ->where('read_at', null) // Assuming you have a read_at column
    ->count();
    
    return response()->json(['unreadCount' => $unreadCount]);
}

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function notifprofil()
    {

        $this->getNotificationsCount();
        $this->deleteOldNotifications();

        $user = Auth::user();
        // Fetch notifications for the user
        $notifications = Notification::where('id_user_penerima', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
    
        // Check if notifications exist and update read_at
        if ($notifications->isNotEmpty()) {
            foreach ($notifications as $notification) {
                // Only update if not already marked as read
                if (is_null($notification->read_at)) {
                    $notification->read_at = now(); // Set read_at to current timestamp
                    $notification->save(); // Save the notification
                }
            }
        }
    
        return view('manageuser::profilnotif')->with(['menu' => $this->menu3, 'notifications' => $notifications]);
    }

   

    public function notifdelete($id)
    {
        // Cari notifikasi berdasarkan id
        $notification = Notification::find($id);

        // Pastikan notifikasi ada dan milik user yang sedang login
        if (!$notification || $notification->id_user_penerima !== Auth::id()) {
dd('error');     
   }

        // Hapus notifikasi
        $notification->delete();

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Notifikasi berhasil dihapus.');
    }

    public function changeEmail(Request $request)
{
    // Validate the request
    $validator = Validator::make($request->all(), [
        'user_id' => 'required|exists:users,id',
        'old_email' => 'required|email|exists:users,email',
        'new_email' => 'nullable|email|unique:users,email', // Change to nullable
        'ttd' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // optional signature upload
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Update email if new_email is provided
    $user = Auth::user();
    
    // Only update email if new_email is not null
    if ($request->filled('new_email')) {
        $user->email = $request->new_email;
    }

    // Optionally, handle the uploaded signature
    if ($request->hasFile('ttd')) {
        // Define the path where you want to save the uploaded file
        $destinationPath = public_path('signatures'); // Public directory

        // Generate a unique file name for the uploaded file
        $fileName = time() . '_' . $request->file('ttd')->getClientOriginalName();

        // Move the uploaded file to the public directory
        $request->file('ttd')->move($destinationPath, $fileName);

        // Save the file path to the user's record
        $user->ttd = 'signatures/' . $fileName; // Assuming you want to store the relative path
    }

    $user->save();

    return redirect()->back()->with('success', 'Email has been changed successfully!');
}

    
    
    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function deleteUser($id) {
        // Find the user by ID
        $user = User::find($id);
    
        // Check if the user exists
        if (!$user) {
            return redirect()->back()->with('error', 'Data Akun Not Found!');
        }
    
        // Find the user details associated with the user
        $userDetail = UserDetail::where('id_userdetail', $id)->first();
    
        // If user details exist, delete them
        if ($userDetail) {
            $userDetail->delete();
        }
    
        // Delete the user
        $user->delete();
    
        return redirect()->back()->with('success', 'Data Akun Terhapus!');
    }
    
    
}
