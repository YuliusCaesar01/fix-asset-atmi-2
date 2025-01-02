<?php

namespace Modules\ManagePermintaanNFA\app\Http\Controllers;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Institusi; 
use Illuminate\Routing\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\PermintaanNonFixedAsset;
use Illuminate\Support\Facades\Auth;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

use DataTables;

class ManagePermintaanNFAController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    
    protected $role;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            // Check if the user is authenticated
            if (!Auth::check()) {
                // If not authenticated, redirect to the login form
                return redirect()->route('login');
            }

            // Get user roles and store them in $this->role
            $user = Auth::user();
            $this->role = implode(', ', $user->getRoleNames()->toArray());
        
            return $next($request);
        
        });
    }


    public function index()
    {
        $menu = 'FixAset';
        $permintaannfa = PermintaanNonFixedAsset::all();
        return view('managepermintaannfa::index', ['role' => $this->role, 'menu' => $menu, 'data' => $permintaannfa]);
    }


    public function data()
    {
        $permintaannfa = PermintaanNonFixedAsset::all();

        return DataTables::of($permintaannfa)
            ->addColumn('action', function ($permintaan) {
                // Add your action buttons here
                return '<button class="btn btn-info btn-sm">Action</button>';
            })
            ->make(true);
    }


     protected function extractText($html) {
        $dom = new DOMDocument();
        @$dom->loadHTML($html); // Suppress warnings when loading HTML
        return trim($dom->textContent);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {      
        $menu = 'FixAset';
        $institusis = Institusi::all(); // Ambil semua data institusi dari tabel
        return view('managepermintaannfa::create', ['role' => $this->role, 'menu' => $menu, 'institusis' => $institusis]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
       
            // Validate request data
        $validatedData = $request->validate([
            'id_institusi' => 'required|integer',
            'des_barang' => 'required|string',
            'jenislayanan' => 'required|string',
            'butuhbarang' => 'sometimes|string',
            'butuhsubcon' => 'sometimes|string',
            'email' => 'required|email|distinct',

        ]);

        // Create a new PermintaanNFA
        $permintaan = new PermintaanNonFixedAsset();
        $permintaan->id_institusi = $validatedData['id_institusi'];
        $permintaan->deskripsi_pengajuan = strip_tags($validatedData['des_barang']);
        $permintaan->jenis_pelayanan = $validatedData['jenislayanan'];
        $permintaan->email_karyawan = $validatedData['email'];

        if (array_key_exists('butuhsubcon', $validatedData)) {
            if ($validatedData['butuhsubcon'] == 'Tidak') {
                $permintaan->kebutuhan = 'non_subcon';
                $permintaan->vendor = 'vendor_terkait';

            } elseif ($validatedData['butuhsubcon'] == 'Ya') {
                $permintaan->kebutuhan = 'subcon';
                $permintaan->vendor = 'belum_ada_vendor';

            } else {
                $permintaan->kebutuhan = 'tidak_ada'; // Atau nilai default lainnya
            }
        } else {
            // Handle the case where 'butuhsubcon' is not present
            $permintaan->kebutuhan = 'tidak_ada'; // Default value
        }
        

        
        $permintaan->id_user = auth()->id();
        $permintaan->status = 'menunggu'; // Default status
        $permintaan->save();

       // Set a success message in the session
         session()->flash('notification', [
        'success' => true, // Indicate success
        'message' => 'Permintaan berhasil diajukan!', // Your success message
           ]); 


        // Redirect with a success message
         return redirect()->route('managepermintaannfa.index');
        
    
            
    }
    

    /**
     * Show the specified resource.
     */
    public function approve()
    {
        $menu = 'approve';
        $roleId = Auth::user()->role_id;

    switch ($roleId) {
        case 1:
            $permintaannfa = PermintaanNonFixedAsset::all();
            $count = $permintaannfa->count();
            return view('managepermintaannfa::approve', ['role' => $this->role, 'menu' => $menu,'data' => $permintaannfa, 'count' => $count]);    
            break;

        case 6:
           $permintaannfa = PermintaanNonFixedAsset::where('validasi_kabeng', 'menunggu')->where('status', 'menunggu')->get();
             $count = $permintaannfa->count();
            return view('managepermintaannfa::approve', ['role' => $this->role, 'menu' => $menu,'data' => $permintaannfa, 'count' => $count]);    
            break;

        case 5:
            $permintaannfa = PermintaanNonFixedAsset::where('validasi_kabeng', 'setuju')->where('validasi_kaprodi', 'menunggu')->where('status', 'menunggu')->get();
              $count = $permintaannfa->count();
            return view('managepermintaannfa::approve', ['role' => $this->role, 'menu' => $menu,'data' => $permintaannfa, 'count' => $count]);    
            break;
        case 10:
                $permintaannfa = PermintaanNonFixedAsset::where('validasi_kaprodi', 'setuju')->where('validasi_corp', 'menunggu')->where('status', 'menunggu')->get();
                $count = $permintaannfa->count();
                return view('managepermintaannfa::approve', ['role' => $this->role, 'menu' => $menu,'data' => $permintaannfa, 'count' => $count]);    
            break;
        case 11:
                    $permintaannfa = PermintaanNonFixedAsset::where('validasi_corp', 'setuju')->where('kebutuhan', 'subcon')->where('status', 'menunggu')->get();
                    $count = $permintaannfa->count();
                    return view('managepermintaannfa::approve', ['role' => $this->role, 'menu' => $menu,'data' => $permintaannfa, 'count' => $count]);    
            break;
        default:
        $permintaannfa = PermintaanNonFixedAsset::where('status', 'menunggu')->get();
        $count = $permintaannfa->count();
        return view('managepermintaannfa::approve', ['role' => $this->role, 'menu' => $menu,'data' => $permintaannfa, 'count' => $count]);    
        break;
    }
    }
    

   // PermintaanController.php
   public function action($aksi, $id)
   {
       // Find the request by ID
       $permintaan = PermintaanNonFixedAsset::findOrFail($id);
       $roleId = Auth::user()->role_id;

       switch ($aksi) {
           case 'approve':
            switch ($roleId) {
                case 10:
                    $permintaan->validasi_corp = 'setuju';
                    session()->flash('notification', [
                        'success' => true,
                        'message' => 'Request approved successfully!',
                    ]);
                    break;
        
                    
                case 6:
                    $permintaan->validasi_kabeng = 'setuju';
                    session()->flash('notification', [
                        'success' => true,
                        'message' => 'Request approved successfully!',
                    ]);
                    break;
        
                   
        
                case 5:
                    $permintaan->validasi_kaprodi = 'setuju';
                    session()->flash('notification', [
                        'success' => true,
                        'message' => 'Request approved successfully!',
                    ]);
                    break;
              case 5:
                    $permintaan->validasi_kaprodi = 'setuju';
                    session()->flash('notification', [
                        'success' => true,
                        'message' => 'Request approved successfully!',
                    ]);
                    break;
                  
                case 13:
                    $permintaan->validasi_finance = 'setuju';
                    session()->flash('notification', [
                        'success' => true,
                        'message' => 'Request approved successfully!',
                    ]);
                    break;
        
                   
                case 11:
                     $permintaan->validasi_procecurement = 'setuju';
                     session()->flash('notification', [
                        'success' => true,
                        'message' => 'Request approved successfully!',
                    ]);
                    break;
        
                   
                default:
               
                break;
            }
            
            break;
         case 'reject':
               $rejectReason = request()->input('reject_reason');

               switch ($roleId) {
                case 1:
                    $permintaan->validasi_corp = 'ditolak';
                    $permintaan->status = 'ditolak';
                   
                    break;
        
                case 6:
                    $permintaan->validasi_kabeng = 'ditolak';
                    $permintaan->status = 'ditolak';
                  
                    break;
        
                case 5:
                    $permintaan->validasi_kaprodi = 'ditolak';
                    $permintaan->status = 'ditolak';
                   
                    break;
                case 13:
                    $permintaan->validasi_finance = 'ditolak';
                    $permintaan->status = 'ditolak';
                   
                    break;
                case 11:
                     $permintaan->validasi_procecurement = 'ditolak';
                     $permintaan->status = 'ditolak';
                    
                     break;
                default:
               
                break;

                    

            }
              
            $permintaan->catatan = $rejectReason; // Assuming you have this column
            session()->flash('notification', [
                'success' => true,
                'message' => 'Request rejected successfully!',
            ]);
               break;
    case 'selesai':

        $permintaan->status = 'selesai';
        session()->flash('notification', [
            'success' => true,
            'message' => 'Request finished successfully!',
        ]);

        break;

           default:
             break;

       }
   
       // Save the updated status
       $permintaan->save();
   
       // Redirect back or to a specific route
       return redirect()->route('managepermintaannfa.approve');
   }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $permintaannfa = PermintaanNonFixedAsset::where('id_permintaan_nfa', $id)->first();
    
        switch ($this->role) {
            case 'manager':
                if ($permintaannfa->validasi_atasan != 'setuju') {
                    return redirect()->back()->with('waiting', 'You should wait for someone to validate.');
                }
                break;
            case 'finance':
                if ($permintaannfa->validasi_availability != 'setuju') {
                    return redirect()->back()->with('waiting', 'You should wait for someone to validate.');
                }
                break;
            case 'staff':
                return view('managepermintaannfa::edit', [
                    'datauser' => $permintaannfa,
                    'role' => $this->role,
                    'menu' => $this->menu
                ]);
            default:
                $enumavailability = PermintaanNonFixedAsset::groupBy('validasi_availability')->pluck('validasi_availability');
                $enumatasan = PermintaanNonFixedAsset::groupBy('validasi_atasan')->pluck('validasi_atasan');
                
                return view('managepermintaannfa::edit', [
                    'datauser' => $permintaannfa,
                    'role' => $this->role,
                    'menu' => $this->menu,
                    'enumatasan' => $enumatasan,
                    'enumavailability' => $enumavailability
                ]);
        }
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi form data
        return ['message' => 'ok'];
    }

    public function validasiatasan(Request $request, $id)
{    
    $savedata = PermintaanNonFixedAsset::findOrFail($id);;
    
    switch ($this->role) {

        case 'kepalaunit':
            $validator = Validator::make($request->all(), [
                'approval_status' => 'required|in:approve,reject,revise',
                'revision_comment' => 'nullable|string',
            ]);

            $approvalStatus = $request->input('approval_status');
            $revisionComment = $request->input('revision_comment');
            $keteranganteknisComment = $request->input('keteranganteknis_comment');
            // Now you can use $approvalStatus, $revisionComment, $keteranganteknisComment in your logic
            
            $savedata->validasi_atasan = $request->input('approval_status');
            $savedata->catatan = $revisionComment ?? $savedata->catatan;
            $savedata->status = $request->input('approval_status');
            
            $savedata->update();

            $jenis_pelayanan = $savedata->jenis_pelayanan;
            $deskripsi_pengajuan = $savedata->deskripsi_pengajuan;
            Mail::to("danieldeniss92@gmail.com")->send(new SendEmail($jenis_pelayanan, $deskripsi_pengajuan));
            
            session()->flash('notification', [
                'success' => true,
                'message' => 'Form submitted successfully',
            ]);
    
            // Redirect to the index page or any other page as needed
            return redirect()->route('managepermintaannfa.index');
            break;

        case 'manager':
            $validator = Validator::make($request->all(), [
                'availability_status' => 'required|in:approve,reject,revise',
                'revision_comment2' => 'nullable|string',
                'keteranganteknis_comment' => 'nullable|string',
            ]);
            $savedata->validasi_availability = $request->input('availability_status') ?? $savedata->validasi_availability ;
            $savedata->catatan = $request->input('revision_comment2') ?? $savedata->catatan;

            if($savedata->jenis_pelayanan != 'barang'){
                $savedata->status = 'proses';
            }else{

            }
            $savedata->status = $request->input('availability_status') ?? $savedata->validasi_availability ;
            $savedata->keteranganteknis = $request->input('keteranganteknis_comment') ?? $savedata->keteranganteknis;
            $savedata->update();

            $jenis_pelayanan = $savedata->jenis_pelayanan;
            $deskripsi_pengajuan = $savedata->deskripsi_pengajuan;
            Mail::to("danieldeniss92@gmail.com")->send(new SendEmail($jenis_pelayanan, $deskripsi_pengajuan));
            
            session()->flash('notification', [
                'success' => true,
                'message' => 'Form submitted successfully',
            ]);
    
            // Redirect to the index page or any other page as needed
            return redirect()->route('managepermintaannfa.index');

            break;
        case 'finance':
            $validator = Validator::make($request->all(), [
                'finance_status' => 'required|in:approve,reject,revise',
                'revision_comment3' => 'nullable|string',
            ]);
            $savedata->validasi_finance = $request->input('finance_status') ?? $savedata->validasi_finance;
            $savedata->catatan = $request->input('revision_comment3') ?? $savedata->catatan;
            $savedata->update();

            $jenis_pelayanan = $savedata->jenis_pelayanan;
            $deskripsi_pengajuan = $savedata->deskripsi_pengajuan;
            Mail::to("danieldeniss92@gmail.com")->send(new SendEmail($jenis_pelayanan, $deskripsi_pengajuan));

            session()->flash('notification', [
                'success' => true,
                'message' => 'Form submitted successfully',
            ]);
    
            // Redirect to the index page or any other page as needed
            return redirect()->route('managepermintaannfa.index');
        break;
        case 'staff':
            dd('iya si');
        break;

        default:
            // Handle the case where $this->role is neither 'kepalaunit' nor 'manager'
            abort(403, 'Unauthorized');
    }
}



    public function updatePengajuan(Request $request, $id)
    {
        // Validate the request data if needed
    $validatedData = $request->validate([
        'des_barang' => 'required|string',
        // Add more validation rules as needed
    ]);

    // Assuming you have a model called PermintaanNonFixedAsset to update
    $permintaan = PermintaanNonFixedAsset::findOrFail($id);
    $permintaan->deskripsi_pengajuan = $validatedData['des_barang'];
    switch (true) {
        case $permintaan->validasi_atasan === 'revisi':
            $permintaan->validasi_atasan = 'menunggu';
            
            break;
        case $permintaan->validasi_availability === 'revisi':
            $permintaan->validasi_availability = 'menunggu';

            break;
        default:

            break;
    }
   $permintaan->save(); 
   //Mail Send
   $jenis_pelayanan = $permintaan->jenis_pelayanan;
   $deskripsi_pengajuan = $permintaan->deskripsi_pengajuan;
   Mail::to("danieldeniss92@gmail.com")->send(new SendEmail($jenis_pelayanan, $deskripsi_pengajuan));


    // Set a success message in the session
    session()->flash('notification', [
        'success' => true,
        'message' => 'Form submitted successfully',
    ]);

    // Redirect to the index page or any other page as needed
    return redirect()->route('managepermintaannfa.index');

    }



    
     public function updateStatus(Request $request, $id)
    {
        // Your logic to update status goes here
        // For example:
        // $permintaan = PermintaanNonFixedAsset::find($id);
        // $permintaan->status = 'selesai';
        // $permintaan->save();

        return redirect()->route('managepermintaannfa.index')->with('notification', 'Status updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    try {
        $permintaan = PermintaanNonFixedAsset::findOrFail($id);
        $permintaan->delete();

        // Set a success message in the session
        session()->flash('notification', [
            'success' => true,
            'message' => 'Permintaan berhasil dihapus!',
        ]);

        // Redirect back to the index page
        return redirect()->route('managepermintaannfa.index');
    } catch (\Exception $e) {
        // Handle exceptions if needed

        // Set an error message in the session
        session()->flash('notification', [
            'success' => false,
            'message' => 'Permintaan gagal dihapus!',
        ]);

        // Redirect back to the index page
        return redirect()->route('managepermintaannfa.index');
    }
}

    public function markAsSelesai($id)
{
   

    try {
        $permintaan = PermintaanNonFixedAsset::findOrFail($id);
        $permintaan->status = 'selesai';
        $permintaan->save();

        // Set a success message in the session
        session()->flash('notification', [
            'success' => true,
            'message' => 'Status updated successfully',
        ]);
        
        // Redirect back
        return redirect()->back();

    } catch (\Exception $e) {
        // Handle exceptions if needed

        // Set an error message in the session
       session()->flash('notification', [
    'success' => false,
    'message' => 'Status not updated successfully',
        ]);

// Redirect back
       return redirect()->back();
    }
     // In your controller

       
}

 

}
