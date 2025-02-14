<?php

namespace Modules\ManageAset\Http\Controllers;

use Log;
use App\Models\Tipe;
use App\Models\Jenis;
use App\Models\Ruang;
use App\Models\Divisi;
use App\Models\Lokasi;
use GuzzleHttp\Client;
use App\Models\Kelompok;
use App\Models\Institusi;
use App\Models\FixedAsset;
use App\Models\UnitDetail;
use Endroid\QrCode\QrCode;
use App\Imports\ImportItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Endroid\QrCode\Writer\PngWriter;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Support\Renderable;
use Modules\ManageAset\Exports\FixedAssetExport;


class ManageAsetController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    protected $menu = 'Aset';

    public function index(Request $request)
{
    $institusi = Institusi::where('id_institusi', '!=', 8)->get();
    $tipe = Tipe::all();
    $lokasi = Lokasi::all();
    $kelompok = Kelompok::all();
    $jenis = Jenis::all();
    $ruang = Ruang::all();

    // Get selected values for displaying in inputs
    $selectedValues = [
        'lokasi' => $lokasi->where('id_lokasi', $request->id_lokasi)->first(),
        'institusi' => $institusi->where('id_institusi', $request->id_institusi)->first(),
        'ruang' => $ruang->where('id_ruang', $request->id_ruang)->first(),
        'kelompok' => $kelompok->where('id_kelompok', $request->id_kelompok)->first(),
        'jenis' => $jenis->where('id_jenis', $request->id_jenis)->first(),
        'tipe' => $tipe->where('id_tipe', $request->id_tipe)->first(),
    ];

    $query = FixedAsset::query();

    // Apply filters if present
    if ($request->filled('id_institusi')) {
        $query->where('id_institusi', $request->id_institusi);
    }
    if ($request->filled('id_lokasi')) {
        $query->where('id_lokasi', $request->id_lokasi);
    }
    if ($request->filled('id_ruang')) {
        $query->where('id_ruang', $request->id_ruang);
    }
    if ($request->filled('id_kelompok')) {
        $query->where('id_kelompok', $request->id_kelompok);
    }
    if ($request->filled('id_jenis')) {
        $query->where('id_jenis', $request->id_jenis);
    }
    if ($request->filled('id_tipe')) {
        $query->where('id_tipe', $request->id_tipe);
    }

    // Fetch data
    $aset = $query->orderBy('kode_fa')->get();

    return view('manageaset::index', compact('aset', 'tipe', 'lokasi', 'institusi', 'kelompok', 'jenis', 'ruang', 'selectedValues'), [
        'menu' => $this->menu
    ]);
}

public function exportToExcel()
{
    return Excel::download(new FixedAssetExport, 'FixedAssetData.xlsx');
}

public function getJenisByKelompok3(Request $request)
{
    $jenis = Jenis::where('id_kelompok', $request->id_kelompok)
                  ->get(['id_jenis', 'nama_jenis_yayasan']);
    
    return response()->json($jenis);
}

public function getTipeByJenis1(Request $request)
{
    $tipe = Tipe::where('id_jenis', $request->id_jenis)
                  ->get(['id_tipe', 'nama_tipe_yayasan']);
    
    return response()->json($tipe);
}

public function getRoomsByInstitution(Request $request)
{
    $rooms = Ruang::where('id_institusi', $request->id_institusi)
                  ->get(['id_ruang', 'nama_ruang']);
    
    return response()->json($rooms);
}

    public function detail($kode_fa)
    {
        $fa = FixedAsset::where('kode_fa', $kode_fa)->first();
        $institusi = Institusi::all();
        $tipe = Tipe::all();
        $lokasi = Lokasi::all();
        $code = $kode_fa;
      // Define the base URL for your asset detail page
            // Define the URL or text to encode in the QR code
            $baseUrl = route('aset.detailbarcode', ['kode_fa' => $kode_fa]);
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

        return view("manageaset::detail", compact('fa', 'tipe', 'lokasi', 'institusi'), ['menu' => $this->menu,'barcode' => $base64QrCode, 'code' => $code]);
    }

public function detailbarcode($kode_fa, $kode_baru = null)
    {
        if($kode_baru == null){
        $fa = FixedAsset::where('kode_fa', $kode_fa)->first();
        $institusi = Institusi::all();
        $tipe = Tipe::all();
        $lokasi = Lokasi::all();
        $code = $kode_fa;
        

      // Define the base URL for your asset detail page
// Define the URL or text to encode in the QR code
$baseUrl = url('/aset/manageaset/detail/'. $kode_fa );
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

        return view("manageaset::barcodepage", compact('fa', 'tipe', 'lokasi', 'institusi'), ['menu' => $this->menu,'barcode' => $base64QrCode, 'code' => $code]);
        }else{
            $fa = FixedAsset::where('kode_fa', $kode_fa)->first();
            $institusi = Institusi::all();
            $tipe = Tipe::all();
            $lokasi = Lokasi::all();
            $code = $kode_fa;
            $kodebaru = $kode_baru;
            $lastThreeDigits = substr($kodebaru, -3); // Extract the last 3 characters
            $lastThreeDigits = ltrim($lastThreeDigits, '0');    
          // Define the base URL for your asset detail page
    // Define the URL or text to encode in the QR code
    $baseUrl = url('/aset/manageaset/detail/'. $kode_fa );
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
    
            return view("manageaset::barcodepage", compact('fa', 'tipe', 'lokasi', 'institusi'), ['menu' => $this->menu,'barcode' => $base64QrCode, 'code' => $code, 'kodebaru' => $kodebaru, 'unitke' => $lastThreeDigits]);

        }
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */

     public function getJenisByKelompok($kelompokId)
{
    $kelompok = Kelompok::find($kelompokId);

    if (!$kelompok) {
        return response()->json([]);
    }

    $jenis = Jenis::where('id_kelompok', $kelompokId)->get();

    return response()->json($jenis);
}

public function getTipeByJenis($jenisId)
{
    $jenis = Jenis::find($jenisId);

    if (!$jenis) {
        return response()->json([]);
    }

    $tipe = Tipe::where('id_jenis', $jenisId)->get();

    return response()->json($tipe);
}

public function getJenisByKelompok1($kelompokId)
{
    $jenis = DB::table('jenis')
        ->where('id_kelompok', $kelompokId)
        ->select('id_jenis', 'nama_jenis_yayasan')
        ->get();
    
    return response()->json($jenis);
}

    public function create()
    {
        $menu = "Tambah Aset";
        $institusi = Institusi::all();
        $divisi = Divisi::all();
        $tipe = Tipe::with('jenis')->get();
        $lokasi = Lokasi::all();
        $ruang = Ruang::with('institusi')->get();
        $jenis = Jenis::with('kelompok')->get();
        $kelompok = Kelompok::all();

        return view('manageaset::create', compact('tipe', 'divisi', 'lokasi', 'institusi','ruang' , 'institusi' , 'menu','jenis', 'kelompok'));
    }

    public function getDivisi(Request $request)
    {
        $divisi = Divisi::where('id_institusi', $request->id_institusi)->get();
        return response()->json($divisi);
    }

    public function getKelompok(Request $request)
    {
        $kelompok = Kelompok::where('id_tipe', $request->id_tipe)->get();
        return response()->json($kelompok);
    }

    public function getJenis(Request $request)
    {
        $jenis = Jenis::where('id_kelompok', $request->id_kelompok)->get();
        return response()->json($jenis);
    }

    public function getLokasi(Request $request)
    {
        $ruang = Lokasi::where('id_lokasi', $request->id_lokasi)->get();
        return response()->json($ruang);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
{
    try {
        // Validate initial data
        $request->validate([
            'id_lokasi' => 'required|integer',
            'id_ruang' => 'required|integer',
            'id_tipe' => 'required|integer',
            'id_kelompok' => 'required|integer',
            'id_jenis' => 'required|integer',
            'unit_asal' => 'nullable|string',
            'jumlah_unit' => 'required|integer|min:1',
            'nama_barang' => 'required|string|max:255',
            'tahun_diterima' => 'required|integer',
            'no_permaintaan' => 'required|string|max:255',
            'des_barang' => 'required|string',
            'status_transaksi' => 'nullable|string|max:255',
            'status_barang' => 'required|string|max:255',
          
        ]);

        // Handle photo upload
        $fotoPath = null;
        if ($request->hasFile('foto_barang')) {
            $fileName = time() . '_' . $request->file('foto_barang')->getClientOriginalName();
            $request->file('foto_barang')->move(public_path('fotofixaset'), $fileName);
            $fotoPath = 'fotofixaset/' . $fileName; // Fixed path construction
        }

        // Get all required codes
        $kode_institusi = Institusi::findOrFail($request->instansi)->kode_institusi;
        $kode_tipe = Tipe::findOrFail($request->id_tipe)->kode_tipe;
        $kode_kelompok = Kelompok::findOrFail($request->id_kelompok)->kode_kelompok;
        $kode_jenis = Jenis::findOrFail($request->id_jenis)->kode_jenis;
        $kode_lokasi = Lokasi::findOrFail($request->id_lokasi)->kode_lokasi;
        $kode_ruang = Ruang::findOrFail($request->id_ruang)->kode_ruang;

        // Generate unit numbering
        $nomor_awal = '001';
        $no_urut = $request->jumlah_unit > 1 
            ? $nomor_awal . '-' . str_pad($request->jumlah_unit, 3, '0', STR_PAD_LEFT)
            : $nomor_awal;

        // Generate kode_fa
        $kode_fa = implode('.', [
            $kode_lokasi,
            $kode_institusi,
            $kode_ruang,
            $kode_kelompok,
            $kode_jenis,
            $kode_tipe
        ]) . '-' . $no_urut;

        // Generate unique ID
        $idFa = Str::random(32);

        // Wrap in database transaction
        DB::beginTransaction();
        try {
            // Create main asset record
            $fixedAsset = FixedAsset::create([
                'unit_asal' => $request->unit_asal,
                'jumlah_unit' => $request->jumlah_unit,
                'id_fa' => $idFa,
                'status_fa' => auth()->user()->hasRole('superadmin') ? 1 : 0,
                'kode_fa' => $kode_fa,
                'id_user' => auth()->user()->id,
                'id_divisi' => auth()->user()->id_divisi,
                'id_institusi' => $request->instansi,
                'id_lokasi' => $request->id_lokasi,
                'id_ruang' => $request->id_ruang,
                'id_tipe' => $request->id_tipe,
                'id_kelompok' => $request->id_kelompok,
                'id_jenis' => $request->id_jenis,
                'nama_barang' => $request->nama_barang,
                'tahun_diterima' => $request->tahun_diterima,
                'no_permaintaan' => $request->no_permaintaan,
                'des_barang' => $request->des_barang,
                'status_transaksi' => $request->status_transaksi,
                'status_barang' => $request->status_barang,
                'foto_barang' => $fotoPath,
            ]);

            // Create unit details records
            for ($i = 1; $i <= $request->jumlah_unit; $i++) {
                $unit_kode = $kode_fa . '-' . str_pad($i, 3, '0', STR_PAD_LEFT);
                
                UnitDetail::create([
                    'id_fa' => $idFa,
                    'kode_fa' => $unit_kode,
                    'unit_number' => $i,
                    'merk' => $request->input("merk.{$i}"),
                    'seri' => $request->input("seri.{$i}"),
                ]);
            }

            DB::commit();
            return $this->index($request)->with('success', 'Data berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->withErrors('Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }

    } catch (\Exception $e) {
        return redirect()->back()
            ->withInput()
            ->withErrors('Terjadi kesalahan: ' . $e->getMessage());
    }
}

    private function isValidDataStructure($data)
    {
        // Tentukan struktur kolom yang diharapkan
        $expectedColumns = ['no', 'kode institusi', 'kode divisi', 'kode tipe', 'kode kelompok', 'kode jenis', 'kode lokasi', 'kode ruang', 'no permintaan SPA', 'tahun diterima', 'nama barang', 'deskripsi barang', 'status transaksi', 'status barang'];

        // Periksa apakah ada kolom tambahan dalam data
        $extraColumns = array_diff($data, $expectedColumns);
        //dd($data, $expectedColumns, $extraColumns);
        if (!empty($extraColumns)) {
            $errorMessage = 'Format Data salah. Kolom berikut tidak sesuai dengan yang diharapkan: ' . implode(', ', $extraColumns);
            return $errorMessage;
        }

        return null; // Validasi berhasil
    }



    public function upload(Request $request)
{
    try {
        if ($request->hasFile('file')) {
            $data = $request->file('file');
            // Import data dari CSV ke koleksi
            $cek = Excel::toArray(new ImportItem, $data);

            foreach ($cek as $item) {
                unset($item[0]); // Menghapus header jika ada
                foreach ($item as $row) {
                    // Validasi jumlah kolom
                    if (count($row) < 11) {
                        continue; // Skip jika kolom kurang
                    }

                    // Tentukan institusi berdasarkan $row[1]
                    $institusi = '';
                    if ($row[1] == 'YKBS') {
                        $institusi = 'Yayasan Karya Bhakti Ska';
                    }

                    // Temukan entitas di database
                    $id_lokasi = Lokasi::where('nama_lokasi_yayasan', $row[0])->first();
                    $id_institusi = Institusi::where('nama_institusi', $institusi)->first();
                    $id_kelompok = Kelompok::where('nama_kelompok_yayasan', $row[2])->first();
                    $id_jenis = Jenis::where('nama_jenis_yayasan', $row[3])->first();
                    $id_ruang = Ruang::where('nama_ruang_yayasan', $row[4])->first();
                    $id_tipe = Tipe::where('nama_tipe_yayasan', $row[5])->first();

                    if (!$id_lokasi || !$id_institusi || !$id_kelompok || !$id_jenis || !$id_ruang || !$id_tipe) {
                        continue; // Skip jika entitas tidak ditemukan
                    }

                    $idFa = Str::random(32);
                  
                    $jumlah =  str_pad($row[12], 3, '0', STR_PAD_LEFT);
                    $no_urut = str_pad(1, 3, "0", STR_PAD_LEFT);
                    if ($jumlah == $no_urut){
                        $kode_fa = $id_lokasi->kode_lokasi . "." . $id_institusi->kode_institusi . "." . $id_kelompok->kode_kelompok . "." . $id_jenis->kode_jenis . "." . $id_ruang->kode_ruang . "." . $id_tipe->kode_tipe . "-" . $no_urut;
                    }else{
                        $kode_fa = $id_lokasi->kode_lokasi . "." . $id_institusi->kode_institusi . "." . $id_kelompok->kode_kelompok . "." . $id_jenis->kode_jenis . "." . $id_ruang->kode_ruang . "." . $id_tipe->kode_tipe . "-" . $no_urut . "-" . $jumlah;
                    }
                    $status_fa = auth()->user()->hasRole('superadmin') ? 1 : 0;
                    $status_transaksi = $row[9] === 'Pemindahan Baru' ? 'Pemindahan' : $row[9];

                    // Validasi dan konversi tahun_diterima
                    $tahun_diterima = is_numeric($row[6]) && strlen($row[6]) == 4 ? (int)$row[6] : null;

                    // Simpan data ke database
                    FixedAsset::create([
                        "id_fa" => $idFa,
                        "id_institusi" => $id_institusi->id_institusi,
                        "id_divisi" => auth()->user()->id_divisi,
                        "id_tipe" => $id_tipe->id_tipe,
                        "id_kelompok" => $id_kelompok->id_kelompok,
                        "id_jenis" => $id_jenis->id_jenis,
                        "id_lokasi" => $id_lokasi->id_lokasi,
                        "id_ruang" => $id_ruang->id_ruang,
                        "nama_barang" => $row[8] ?? '',
                        "foto_barang" => $row[7] ?? '',
                        "tahun_diterima" => $tahun_diterima,
                        "des_barang" => $row[8] ?? 'No description',
                        "no_permintaan" => '',
                        "jumlah_unit" => $row[12] ?? '',
                        "status_transaksi" => $status_transaksi,
                        "id_user" => auth()->user()->id,
                        "kode_fa" => $kode_fa,
                        "status_fa" => $status_fa
                    ]);
                }
            }

            return redirect()->route('manageaset.index')->with('notification', 'Data berhasil diupload');
        } else {
            return redirect()->back()->with('error', 'File not uploaded.');
        }
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}


    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id_fa)
    {
        $aset = FixedAsset::findOrFail($id_fa);
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Sset',
            'data'    => $aset
        ]);
    }
 
    public function download($data)
    {
        $code = $data;
        $generator = new BarcodeGeneratorPNG();
        $barcode = $generator->getBarcode($code, $generator::TYPE_CODE_128);

        return response($barcode, 200)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="barcode.png"');
    }


    public function validateAsset($kode_fa)
    {
        $fa = FixedAsset::where('kode_fa', $kode_fa)->first();
        // Pastikan $fa tidak null sebelum melakukan update
        if ($fa) {
            // Update fa
            $fa->update([
                'status_fa' => 1,
            ]);

            return response()->json(['message' => 'Validasi Aset Berhasil']);
        } else {
            return response()->json(['message' => 'Aset tidak ditemukan'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id_fa)
    {
        $fa = FixedAsset::findOrFail($id_fa);
        $institusi = Institusi::all();
        $divisi = Divisi::where('id_institusi', $fa->id_institusi)->get();
        $tipe = Tipe::all();
        $kelompok = Kelompok::all();
        $jenis = Jenis::all();
        $lokasi = Lokasi::all();
        $ruang = Ruang::all();
        return view("manageaset::edit", compact('fa', 'institusi', 'divisi', 'tipe', 'kelompok', 'jenis', 'lokasi', 'ruang'), ['menu' => $this->menu]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id_fa)
{
    $fa = FixedAsset::findOrFail($id_fa);

    // Define validation rules
    $request->validate([
        "institusi" => 'required',
        "id_tipe" => 'required',
        "id_kelompok" => 'required',
        "id_jenis" => 'required',
        "id_lokasi" => 'required',
        "id_ruang" => 'required',
        "nama_barang" => 'required',
        "tahun_diterima" => 'required',
        "des_barang" => 'required',
        "status_transaksi" => 'required',
        "status_barang" => 'required',
        "foto_barang" => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        "jumlah_unit" => 'required|numeric|min:1', // Add validation for jumlah_unit
    ]);

    // Handle photo upload
    if ($request->hasFile('foto_barang')) {
        // Delete the old photo if it exists
        if ($fa->foto_barang) {
            Storage::disk('public')->delete('fotofixaset/' . $fa->foto_barang);
        }

        // Get the uploaded file
        $file = $request->file('foto_barang');

        // Use the asset's name as the file name (sanitize it if needed)
        $fileName = $fa->nama_barang . '.' . $file->getClientOriginalExtension();

        // Move the file to the 'public/fotofixaset' folder
        $file->move(public_path('fotofixaset'), $fileName);

        // Save the new file name in the database
        $fa->foto_barang = $fileName;
    } else {
        $fileName = $fa->foto_barang;
    }

    // Update the asset with the new data
    $fa->update([
        "id_institusi" => $request->institusi,
        "id_tipe" => $request->id_tipe,
        "id_kelompok" => $request->id_kelompok,
        "id_jenis" => $request->id_jenis,
        "id_lokasi" => $request->id_lokasi,
        "id_ruang" => $request->id_ruang,
        "nama_barang" => $request->nama_barang,
        "foto_barang" => $fileName,
        "tahun_diterima" => $request->tahun_diterima,
        "des_barang" => $request->des_barang,
        "jumlah_unit" => $request->jumlah_unit, // Save jumlah_unit to the database
    ]);

    // Redirect with success message
    return redirect()->route("manageaset.detail", ['kode_fa' => $fa->kode_fa])->with(['success' => 'Data Berhasil Disimpan. Terima kasih']);
}


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $aset = FixedAsset::findOrFail($id);
        $aset->delete();

        return redirect()->back()->with('success', 'Aset berhasil dihapus.');
    }
}
