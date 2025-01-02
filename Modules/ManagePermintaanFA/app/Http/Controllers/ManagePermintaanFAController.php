<?php

namespace Modules\ManagePermintaanFA\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Divisi;
use App\Models\FixedAsset;
use App\Models\Institusi;
use App\Models\Jenis;
use App\Models\Kelompok;
use App\Models\Lokasi;
use App\Models\Ruang;
use App\Models\Tipe;
use App\Models\Bast;
use App\Models\User;
use Illuminate\Support\Str;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use App\Mail\NotifyUser;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth; // Add this line
use App\Models\PermintaanFixedAsset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use App\Models\Notification;


class ManagePermintaanFAController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $menu = 'PermintaanFA';

    public function updateStatusBasedOnDelay()
    {
        // Get all the records
        $permintaanfa = PermintaanFixedAsset::all();

        // Iterate through each record
        foreach ($permintaanfa as $item) {
            // Check if delay_timestamp is set and not null
            if ($item->delay_timestamp && Carbon::parse($item->delay_timestamp)->isToday()) {
                // Update status to 'menunggu' if the delay_timestamp matches today's date
                $item->status = 'menunggu';
                switch ($item->delay_id) {
                    case 14:
                        $item->valid_fixaset = 'setuju';
                        $item->valid_fixaset_timestamp = Carbon::now(); // Set to current time or any appropriate value
                        $item->delay_id = null;
                        $item->delay_timestamp = null; // Ensure 'status' is the correct field name for updating
                        $item->save();
                        $user = User::where('id', $item->user_id)->first();

                        $permintaan = $item;
               
                        // Call mail function to send email for approval
                       
                         $this->mail('delayend', $permintaan, $user);

                        break;
                    case 18:
                        $item->valid_dirmanageraset = 'setuju';
                         // Parse the timestamp to get the month and year
                         $item->valid_dirmanageraset_timestamp = Carbon::now(); // Set to current time or any appropriate value
                         $timestamp = Carbon::parse($item->valid_dirmanageraset_timestamp);

                        // Convert month to Roman numerals
                        $bulan = $this->monthToRoman($timestamp->month);
                            $permintaann = Bast::create([
                                'id_permintaan_fa' => $item->id_permintaan_fa,
                                'id_user' => $item->id_user,
                                'bulan' => $bulan, // Use the formatted month
                                'tahun' => $timestamp->year // You might want to use the year as well
                            ]);
                            $item->delay_id = null;
                            $item->delay_timestamp = null; // Ensure 'status' is the correct field name for updating
                            $item->save();
                            $permintaan = $item;
                            $user = User::where('id', $item->user_id)->first();
                            $user1 = User::where('role_id', 19)->first();

                             $this->mail('delayend', $permintaan, $user);

                        break;
                    default:
                        # code...
                        break;
                }


               
            }
        }

        return response()->json(['message' => 'Statuses updated based on delay timestamp.']);
    }

    public function index()
    {

        $user = Auth::user();
        $userall = User::all();

    
        $this->updateStatusBasedOnDelay();

        // Check if the user is authenticated and their ID
        if ($user && $user->role_id == 14) {
            // User ID is 1, fetch all records
            $permintaanfa = PermintaanFixedAsset::orderByRaw("CASE WHEN delay_id IS NULL THEN 0 ELSE 1 END")
            ->orderByRaw("CASE WHEN valid_fixaset = 'menunggu' THEN 0 ELSE 1 END")
            ->orderBy('created_at', 'desc')
            ->get();
        
        
        
       
        } elseif($user && $user->role_id == 15){
            $permintaanfa = PermintaanFixedAsset::where('valid_fixaset', 'setuju')
            ->where('perkiraan_harga', '>=', 1000000000)
            ->orderBy('created_at', 'desc')->get();
            
          
        }elseif($user && $user->role_id == 16){
            $permintaanfa = PermintaanFixedAsset::where('valid_fixaset', 'setuju')
            ->where(function ($query) {
                $query->whereNull('perkiraan_harga')
                      ->orWhere('perkiraan_harga', '<', 1000000000);
            })->orderBy('created_at', 'desc')->get();
          
        }elseif($user && $user->role_id == 17){
            $permintaanfa = PermintaanFixedAsset::where(function ($query) {
                $query->where('valid_karyausaha', 'setuju')
                      ->orWhere('valid_ketuayayasan', 'setuju');
            })
            ->where('status_permohonan', '!=', 'Pemindahan') // Perbaikan disini
            ->orderBy('created_at', 'desc')->get();

          
        }elseif($user && $user->role_id == 18){
            $permintaanfa = PermintaanFixedAsset::where(function ($query) {
                $query->where('valid_karyausaha', 'setuju')
                ->where('valid_dirkeuangan', '!=', 'tolak')
                ->orWhere('valid_ketuayayasan', 'setuju');
            })
            ->orderBy('created_at', 'desc')->get();

          
        }elseif($user && $user->role_id == 19){
            $permintaanfa = PermintaanFixedAsset::where(function ($query) {
                $query->where('valid_dirmanageraset', 'setuju');          
              })
              ->orderBy('created_at', 'desc')->get();

          
        }
        
         else{
            $permintaanfa = PermintaanFixedAsset::all();

            // For other users, fetch records based on some condition
            // For example, you might want to filter records or apply different logic
        }
        return view('managepermintaanfa::index', compact('permintaanfa'), ['menu' => $this->menu , 'user' => $userall]);
    }

    

    public function detail($id_permintaanfa)
    {
      
        $permintaan = PermintaanFixedAsset::findOrFail($id_permintaanfa);
//pdfPengaju
try {
    $pdf = Crypt::decryptString($permintaan->file_pdf);
} catch (\Exception $e) {
    $pdf = null;
}     
//pdfbukti1
try {
    $pdfbukti1 = Crypt::decryptString($permintaan->pdf_bukti_1);
} catch (\Exception $e) {
    $pdfbukti1 = null;
}


$fa = FixedAsset::where('no_permintaan', $permintaan->id_permintaan_fa)->first();
$code = $fa->kode_fa ?? '';
// Define the base URL for your asset detail page
// Define the URL or text to encode in the QR code
$baseUrl = url('/aset/manageaset/detail/'. $code );
$fullUrl = $baseUrl;

// Create a new QR code instance
$qrCode = new QrCode($fullUrl);

// Set the size of the QR code (in pixels)
$qrCode->setSize(200); // 200x200 pixels

// Set the margin around the QR code
$qrCode->setMargin(10); // 10 pixels margin

// Generate the QR code
$writer = new PngWriter();
$qrCodeImage = $writer->write($qrCode)->getString();

// Encode QR code image in Base64 for embedding in HTML
$base64QrCode = base64_encode($qrCodeImage);




return view("managepermintaanfa::detail", compact('permintaan'), ['menu' => $this->menu, 'pdf' => $pdf, 'pdfbukti1' => $pdfbukti1 , 'qrcode' => $base64QrCode]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menu = "SPA";
        $institusi = Institusi::all();
        $tipe = Tipe::all();
        $lokasi = Lokasi::all();
        $ruang = Ruang::all();
        $jenis = Jenis::all();
        $kelompok = Kelompok::all();

        return view('managepermintaanfa::create', compact('tipe', 'lokasi', 'institusi', 'menu', 'kelompok', 'ruang', 'jenis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validasi data
    $validatedData = $request->validate([
        'deskripsi_permintaan' => 'required',
        'alasan_permintaan' => 'required',
        'id_lokasi' => 'required',
        'id_ruang' => 'required',
        'id_tipe' => 'required',
        'nama_barang' => 'required',
        'merk_barang' => 'required',
        'id_kelompok' => 'required',
        'status_transaksi' => 'required',
        'id_jenis' => 'required',
        'unit_asal' => 'nullable|string', // Unit Asal hanya wajib jika status Pemindahan
        'jumlah_unit' => 'required|integer|min:1', // Validasi jumlah unit
        'file_pdf' => 'nullable|file|mimes:pdf|max:2048',
    ]);

    // Ambil pengguna yang sedang login
    $user = User::where('role_id', 14)->first();
    $divisi = $user->divisi;

    // Simpan data ke dalam database
    $permintaan = PermintaanFixedAsset::create([
        'deskripsi_permintaan' => strip_tags($validatedData['deskripsi_permintaan']),
        'alasan_permintaan' => strip_tags($validatedData['alasan_permintaan']),
        'id_lokasi' => strip_tags($validatedData['id_lokasi']),
        'id_ruang' => $validatedData['id_ruang'],
        'id_tipe' => $validatedData['id_tipe'],
        'tgl_permintaan' => Carbon::now(),
        'status_permohonan' => $validatedData['status_transaksi'],
        'id_kelompok' => $validatedData['id_kelompok'],
        'id_jenis' => $validatedData['id_jenis'],
        'unit_pemohon' => $request->unit_pemohon,
        'unit_tujuan' => $request->unit_tujuan,
        'unit_asal' => $validatedData['unit_asal'],
        'jumlah_unit' => $validatedData['jumlah_unit'],
        'id_institusi' => $divisi->id_institusi,
        'id_user' => $user->id,
        'nama_barang' => $validatedData['nama_barang'],
        'merk_barang' => $validatedData['merk_barang'],
    ]);

    // Handle file upload
    if ($request->hasFile('file_pdf')) {
        $file = $request->file('file_pdf');
        if ($file->isValid()) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pdfs'), $fileName);
            $permintaan->file_pdf = Crypt::encryptString('uploads/pdfs/' . $fileName);
            $permintaan->save();
        } else {
            return redirect()->route('managepermintaanfa.index')->with('error', 'PDF upload failed.');
        }
    }

    // Call mail function to send email for approval
    $this->mail('approval', $permintaan, $user);

    return redirect()->route('managepermintaanfa.index')->with('success', 'Permintaan berhasil diajukan.');
}

    

    /**
     * Show the specified resource.
     */
    public function profile($id)
    {
        return view('managepermintaanfa::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function approve(Request $request)
{
    // Validation rules
    $validator = Validator::make($request->all(), [
        'id' => 'required|integer',
        'status' => 'required|string|in:setuju,delayed,ditolak', // Added 'delayed' and 'ditolak' for different statuses
        'unitSource' => 'nullable|string',
        'priceEstimate' => 'nullable|numeric',
        'file_pdf2' => 'nullable|file|mimes:pdf',
        'file_image' => 'nullable|file|mimes:jpg,jpeg,png', // Validation for image
        'file_image2' => 'nullable|file|mimes:jpg,jpeg,png', // Validation for image
        'delay_date' => 'nullable|date|after_or_equal:today', // Validation for delay date
        'catatan' => 'nullable|string' // Validation for rejection notes
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Find the model based on the ID
    $model = PermintaanFixedAsset::findOrFail($request->id);

    // Handle the different statuses
    if ($request->status === 'setuju') {
        // Handle approval
        $model->valid_fixaset = $request->status;
        $model->valid_fixaset_timestamp = Carbon::now();
        $model->unit_asal = $request->unitSource;
        $model->perkiraan_harga = $request->priceEstimate;

        // Handle PDF upload
        if ($request->hasFile('file_pdf2')) {
            $file = $request->file('file_pdf2');
            if ($file->isValid()) {
                   // Tentukan nama file yang unik agar tidak bentrok
                   $fileName = time() . '_' . $file->getClientOriginalName();
        
                   // Pindahkan file ke direktori public/uploads/pdfs
                   $file->move(public_path('uploads/pdfs'), $fileName);
                   $model->pdf_bukti_1 =  Crypt::encryptString('uploads/pdfs/' . $fileName);
            } else {
                return redirect()->route('managepermintaanfa.index')->with('error', 'PDF upload failed.');
            }
        }

        if ($request->hasFile('file_image2')) {
            $file = $request->file('file_image2');
            // Generate a unique file name with timestamp
            $fileName = time() . '_' . $file->getClientOriginalName();
    
            // Move the file to the public/uploads/photos directory
            $file->move(public_path('uploads/photos'), $fileName);
    
            // Save the file path to the database (relative path)
            $model->foto_barang = 'uploads/photos/' . $fileName; 
        }
        $permintaan = $model;
        if ($model->perkiraan_harga >= 1000000000) {
            $user = User::where('role_id', 15)->first();
        } else {
            $user = User::where('role_id', 16)->first();
        }
       // Call mail function to send email for approval
    $this->mail('approval', $permintaan, $user);
    } elseif ($request->status === 'delayed') {
        // Handle delay


        if ($request->hasFile('file_image')) {
              $file = $request->file('file_image');
            // Generate a unique file name with timestamp
            $fileName = time() . '_' . $file->getClientOriginalName();
    
            // Move the file to the public/uploads/photos directory
            $file->move(public_path('uploads/photos'), $fileName);
    
            // Save the file path to the database (relative path)
            $model->foto_barang = 'uploads/photos/' . $fileName; 

        } else {
            $fileName = 'no_img.png';
        }
        // Handle PDF upload
        if ($request->hasFile('file_pdf')) {
            $file = $request->file('file_pdf');
            if ($file->isValid()) {
                   // Tentukan nama file yang unik agar tidak bentrok
                   $fileName = time() . '_' . $file->getClientOriginalName();
        
                   // Pindahkan file ke direktori public/uploads/pdfs
                   $file->move(public_path('uploads/pdfs'), $fileName);
                   $model->pdf_bukti_1 =  Crypt::encryptString('uploads/pdfs/' . $fileName);
            } else {
                return redirect()->route('managepermintaanfa.index')->with('error', 'PDF upload failed.');
            }
        }
        $model->catatan = $request->alasan_delay;

        $model->unit_asal = $request->unitSourceDelay;
        $model->perkiraan_harga = $request->priceEstimateDelay;
        $model->delay_id = auth()->user()->role_id; // Store role_id in delay_id
        $model->delay_timestamp = $request->delay_date; // Ensure this column exists in your database
        $model->status = 'delayed'; // Update status to 'delayed'
        $permintaan = $model;
        $user = User::where('id', $model->id_user)->first();
    
        // Call mail function to send email for approval
         $this->mail('delayed', $permintaan, $user);
    } elseif ($request->status === 'ditolak') {
        // Handle rejection
        $model->catatan = $request->catatan; // Store rejection note
        $model->status = 'rejected'; // Update status to 'rejected'
        $permintaan = $pfa;
        $user = Auth::user();
    
       // Call mail function to send email for approval
        $this->mail('rejection', $permintaan, $user);
        // Handle PDF upload (if rejection includes optional PDF upload)
        if ($request->hasFile('file_pdf')) {
            $file = $request->file('file_pdf');
            if ($file->isValid()) {
                $fileName = time() . '_' . $file->getClientOriginalName();
        
                // Pindahkan file ke direktori public/uploads/pdfs
                $file->move(public_path('uploads/pdfs'), $fileName);
                $model->pdf_bukti_1 =  Crypt::encryptString('uploads/pdfs/' . $fileName);
            } else {
                return redirect()->route('managepermintaanfa.index')->with('error', 'PDF upload failed.');
            }
        }
        
    }

    // Save the model
    $model->save();

    return redirect()->route('managepermintaanfa.index')->with('success', 'Request processed successfully!');
}
    
    
    public function tindakan(Request $request)

    {
        // Validasi request secara otomatis
        $validatedData = $request->validate([
            'id' => 'required|integer', // ID dari permintaan
            'alasan' => 'nullable|string', // Alasan bisa null (hanya untuk reject)
            'tindakLanjut' => 'required|string', // Input tindakan lanjut yang harus ada
            'tindakanType' => 'required|string|in:Setuju,Ditolak', // Hanya Setuju atau Ditolak
        ]);

        // Cari permintaan berdasarkan ID
        $permintaan = PermintaanFixedAsset::find($validatedData['id']);

        if (!$permintaan) {
            // Jika permintaan tidak ditemukan, return response atau redirect dengan pesan error
            return redirect()->back()->withErrors('Permintaan fix asset tidak ditemukan.');
        }
        if ($permintaan->status_permohonan == 'Pemindahan') {
            $user = User::where('role_id', 18)->first();
        } else {
            $user = User::where('role_id', 17)->first();
        }
        // Logika untuk Setuju atau Ditolak
        if ($validatedData['tindakanType'] == 'Setuju') {
            // Tindakan Setuju: update status permintaan
            if (Auth::user()->role_id == 16) {
                $permintaan->valid_karyausaha = 'setuju';
                $permintaan->valid_karyausaha_timestamp = Carbon::now();
                $permintaan->tindak_lanjut = $validatedData['tindakLanjut'];
                $permintaan->save(); // Simpan perubahan ke database
             
                $this->mail('approval', $permintaan, $user);

                 

            }else{
             $permintaan->valid_ketuayayasan = 'setuju';
             $permintaan->valid_ketuayayasan_timestamp = Carbon::now();
             $permintaan->tindak_lanjut = $validatedData['tindakLanjut'];
             $this->mail('approval', $permintaan, $user);
              $permintaan->save(); // Simpan perubahan ke database

            }
          
           
        } else {
            if (Auth::user()->role_id == 16) {
                $permintaan->valid_karyausaha = 'tolak';
                $permintaan->status = 'ditolak';
                //notif ke role sebelumnya
                $permintaan->valid_karyausaha_timestamp = Carbon::now();
                $permintaan->catatan = $validatedData['alasan']; // Simpan alasan penolakan
                $permintaan->tindak_lanjut = $validatedData['tindakLanjut'];
                $permintaan->save(); // Simpan perubahan ke database
                $user = Auth::user();
                $this->mail('rejection', $permintaan, $user);
            }else{
                 $permintaan->valid_ketuayayasan = 'tolak';
                 $permintaan->valid_ketuayayasan_timestamp = Carbon::now();
                 $permintaan->catatan = $validatedData['alasan']; // Simpan alasan penolakan
                 $permintaan->tindak_lanjut = $validatedData['tindakLanjut'];
                 $permintaan->save(); // Simpan perubahan ke database
                 $user = Auth::user();
                 $this->mail('rejection', $permintaan, $user);
            }
        }

        
      

        // Berikan respons atau redirect setelah berhasil
        return redirect()->route('managepermintaanfa.index')->with('success', 'Tindakan berhasil dilakukan.');
    }


    

    public function tindakan_bast(Request $request)
    {
        try {
            // Validasi data
            $validatedData = $request->validate([
                'id' => 'required|integer|exists:permintaan_fixed_assets,id_permintaan_fa',
                'status' => 'required|string|in:setuju,tolak',
                'harga_perolehan' => 'nullable|numeric|min:0',
                'alasan_reject' => 'nullable|string'
            ]);
    
            $permintaan = PermintaanFixedAsset::find($validatedData['id']);
            $user = User::where('role_id', 18)->first();

            switch (Auth::user()->role_id) {
                case 17:
                    if ($request->status === 'setuju') {
                        // Logika untuk status 'setuju'
                        $permintaan->perolehan_harga = $request->harga_perolehan;
                        $permintaan->valid_dirkeuangan = 'setuju';
                        $permintaan->valid_dirkeuangan_timestamp = Carbon::now();
                        $permintaan->update();
                        if ($permintaan->save()) {
                            $this->mail('approval', $permintaan, $user);
                        } else {
                            // Handle the error, you can get the errors like this
                            $errors = $permintaan->getErrors(); // If you have a method for this
                        }
                    } elseif ($request->status === 'tolak') {
                        // Logika untuk status 'tolak'
                        $permintaan->status = 'ditolak';
                        $permintaan->valid_dirkeuangan = 'tolak';
                        $permintaan->valid_dirkeuangan_timestamp = Carbon::now();
                        $permintaan->catatan = $request->alasan_reject;
                        $permintaan->update();
                    }
                    break;
                case 18:
                                      break;
                case 19:
                    // Implementasikan logika untuk role_id 19 jika diperlukan
                    break;
                default:
                    // Implementasikan logika untuk role_id lain jika diperlukan
                    break;
            }
    
            return redirect()->back()->with('success', 'Data berhasil diproses.');
        } catch (\Exception $e) {
            // Log error details
            Log::error('Error updating permintaan_fixed_assets: ' . $e->getMessage());
    
            // Return an error response or redirect with error message
            return redirect()->back()->withErrors('Terjadi kesalahan saat memproses data.');
        }
    }
    


    public function reject(Request $request)
    {
        // Validasi input
        $request->validate([
            'id' => 'required', // Ganti `permintaans` dengan nama tabel yang sesuai
            'catatan' => 'nullable|string',
            'status' => 'required|string|in:ditolak',
            'file_pdf' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        // Temukan permintaan berdasarkan ID
        $permintaan = PermintaanFixedAsset::findOrFail($request->input('id'));
        $roleId = auth()->user()->role_id;

        // Set status ke 'rejected'
        switch ($roleId) {
            case 14:
                $permintaan->status = 'ditolak';
                $permintaan->valid_fixaset = 'tolak';
                $permintaan->valid_fixaset_timestamp = Carbon::now();

                break;
            case 17:
                $permintaan->status = 'ditolak';
                $permintaan->valid_dirkeuangan = 'tolak';
                $permintaan->valid_dirkeuangan_timestamp = Carbon::now();

                break;
    
            break;
            default:
            $permintaan->status = 'ditolak';

                break;
        }
        $permintaan->catatan = $request->input('catatan');
        

          // Handle the PDF upload
    if ($request->file_pdf) {
        $file = $request->file_pdf;
        if ($file->isValid()) {
            $path = $file->store('upload/pdf', 'public'); 
            $permintaan->pdf_bukti_1 = Crypt::encryptString($path); 
            $permintaan->save(); 
        } else {
            return redirect()->route('managepermintaanfa.index')->with('error', 'Permintaan gagal.');
        }
    } else {
        return redirect()->route('managepermintaanfa.index')->with('success', 'Permintaan berhasil diajukan.');

    }

        // Simpan perubahan
        $permintaan->save();

        // Redirect atau respon sesuai kebutuhan
        return redirect()->back()->with('success', 'Permintaan berhasil ditolak.');
    }
    

    /**
     * Update the specified resource in storage.
     */
  
public function tindakanbast(Request $request, $id)
{
    // Retrieve the requested FA using the provided ID
    $pfa = PermintaanFixedAsset::find($id);

    // Check if the record exists
    if (!$pfa) {
        return redirect()->back()->withErrors('Data not found');
    }

    if($request->status != null){
               $pfa->valid_dirmanageraset = 'tolak';
               $pfa->valid_dirmanageraset_timestamp = Carbon::now();
               $pfa->catatan = $request->rejectReason;
               $pfa->status = 'ditolak';
               $pfa->save();


    }else{

    
  

    $pfa->valid_dirmanageraset = 'setuju';
    $pfa->valid_dirmanageraset_timestamp = Carbon::now();
    $pfa->save();
    // Call mail function to send email for approval
    $permintaan = $pfa;
    $user = User::where('role_id', 19)->first();

   // Call mail function to send email for approval
    $this->mail('approval', $permintaan, $user);
 // Parse the timestamp to get the month and year
 $timestamp = Carbon::parse($pfa->valid_dirmanageraset_timestamp);

 // Convert month to Roman numerals
 $bulan = $this->monthToRoman($timestamp->month);
    $permintaan = Bast::create([
        'id_permintaan_fa' => $pfa->id_permintaan_fa,
        'id_user' => $pfa->id_user,
        'bulan' => $bulan, // Use the formatted month
        'tahun' => $timestamp->year // You might want to use the year as well
    ]);
}

    return redirect()->back()->with('success', 'Permintaan berhasil ditindak.');
}

// Method to convert month number to Roman numeral
private function monthToRoman($month)
{
    $romans = [
        1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV',
        5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII',
        9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
    ];

    return $romans[$month] ?? 'Unknown';
}


public function catat(Request $request)
    {
        $request->validate([
            'idPermintaanFA' => 'required|integer|exists:permintaan_fixed_assets,id_permintaan_fa',
          
        ]);
        

        // Retrieve the request ID from the form
        $id_permintaan_fa = $request->input('idPermintaanFA');

        // Find the related PermintaanFA record (assuming PermintaanFA is the model)
        $pfa = PermintaanFixedAsset::findOrFail($id_permintaan_fa);

        // Perform any action you'd like to "catat" the request, e.g., updating the status or saving a log
        $pfa->status = 'disetujui'; 
        $pfa->valid_manageraset = 'setuju'; // Assuming 'status' is a column in the table
        $pfa->valid_manageraset_timestamp = Carbon::now();
        $pfa->save();
         $bast = bast::where('id_permintaan_fa' , $pfa->id_permintaan_fa)->first();

    
        $kode_institusi = Institusi::find($pfa->id_institusi)->kode_institusi;
        $kode_tipe = Tipe::find($pfa->id_tipe)->kode_tipe;
        $kode_kelompok = Kelompok::find($pfa->id_kelompok)->kode_kelompok;
        $kode_jenis = Jenis::find($pfa->id_jenis)->kode_jenis;
        $kode_lokasi = Lokasi::find($pfa->id_lokasi)->kode_lokasi;
        $kode_ruang = Ruang::find($pfa->id_ruang)->kode_ruang;

        $kode_max = FixedAsset::where('id_institusi', $pfa->id_institusi)->where('id_divisi', $pfa->id_divisi)->where('id_tipe', $pfa->id_tipe)->where('id_kelompok', $pfa->id_kelompok)->where('id_jenis', $pfa->id_jenis)->where('id_lokasi', $pfa->id_lokasi)->where('id_ruang', $pfa->id_ruang)->count();
        $no_urut = str_pad($kode_max + 1, 3, '0', STR_PAD_LEFT);

        $kode_fa = $kode_lokasi . "." . $kode_institusi . "." .   $kode_kelompok . "." .  $kode_jenis . "." . $kode_ruang . "." .$kode_tipe . "-" . $no_urut;
        $idFa = Str::random(32);

        if (auth()->user()->hasRole('superadmin')) {
            $status_fa = 1;
        } else {
            $status_fa = 0;
        }
        $permintaan = FixedAsset::create([
            'id_fa' =>  $idFa,
            'id_institusi' => $pfa->id_institusi,
            'id_divisi' => $pfa->user->id_divisi,
            'id_tipe' => $pfa->id_tipe,
            'id_jenis' => $pfa->id_jenis,
            'id_ruang' => $pfa->id_ruang,
            'id_kelompok' => $pfa->id_kelompok,
            'kode_fa' => $kode_fa,
            'status_fa' => $status_fa,
            'id_lokasi' => $pfa->id_lokasi,
            'no_permintaan' => $pfa->id_permintaan_fa,
            'tahun_diterima' => $bast->tahun,
            'foto_barang' => $pfa->foto_barang ?? '',
            'file_pdf' => $pdfFilePath ?? '',
            'nama_barang' => $pfa->nama_barang,
            'des_barang' => $pfa->deskripsi_permintaan,
            'status_transaksi' => $pfa->status_permohonan,
            'status_barang' => $pfa->status_barang,
            'id_user' => $pfa->id_user,

        ]);

        $permintaan = $pfa;
        $user = User::where('id', $pfa->id_user)->first();
    
       // Call mail function to send email for approval
        $this->mail('success', $permintaan, $user);
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Permintaan FA telah dicatat dengan sukses!');
    }

    public function mail($typemail, $permintaan, $user)
    {
        switch ($typemail) {
            case 'approval':
                $emailType = 'Approval';
                $subject = 'No-Reply, Fixed Asset Approval';
                $message = 'Fix Asset terbaru menunggu tindakan anda';
                break;
            case 'rejection':
                $emailType = 'Rejection';
                $subject = 'No-Reply,Fixed Asset Rejection';
                $message = 'Fix Asset telah ditolak';

                break;
            case 'delayed':
                    $emailType = 'Delayed';
                    $subject = 'No-Reply,Fixed Asset Delayed';
                    $message = 'Fix Asset telah ditunda';
            case 'delayend':
                        $emailType = 'Delayend';
                        $subject = 'No-Reply,Fixed Asset Delay End';
                        $message = 'Fix Asset waktu penundaan telah berakhir';
    
                break;
            case 'success':
                    $emailType = 'Success';
                    $subject = 'No-Reply,Fixed Asset Approved';
                    $message = 'Fix Asset telah Approved success';

                    break;
            default:
                return; // Exit if no valid email type is provided
        }
    
      
Notification::create([
    'id_user_pengirim' => auth()->user()->id,
    'id_user_penerima' => $user->id ,
    'id_pengajuan' => $permintaan->id_permintaan_fa,
    'keterangan_notif' => $message,
    'jenis_notif' => 'pengajuan', // Menggunakan input dari request
    'tipe_notif' => 'system', // Default notification type
]);

        // Kirim email ke user atau admin berdasarkan role
      $mail =  Mail::to($user->email)->send(new NotifyUser($subject, $emailType, $permintaan));


      
    

    }

    /**
     * Remove the specified resource from storage.
     */
    public function viewBast($id)
    {
        $bast = Bast::where('id_permintaan_fa', $id)->first();
        $pfa = PermintaanFixedAsset::findOrFail($id);
        return view('components.pdf_bast', compact('pfa','bast'));
    }
    public function viewPengajuan($id)
    {
        $bast = Bast::where('id_permintaan_fa', $id)->first();
        $pfa = PermintaanFixedAsset::findOrFail($id);
        return view('components.pdf_FA', compact('pfa','bast'));
    }
}
