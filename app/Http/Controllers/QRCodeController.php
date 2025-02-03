<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use App\Models\FixedAsset;

class QRCodeController extends Controller
{
    public function generateQRCode(Request $request)
{
    $fa = FixedAsset::where('kode_fa', $request->kode_fa)->first();

    if (!$fa) {
        return redirect()->back()->withErrors('Fixed asset not found.');
    }

    if ($request->action === 'single') {
        $kode = $fa->kode_fa;
        
        // Get base code without unit numbers
        $kode_base = substr($kode, 0, strrpos($kode, '-'));
        
        // Add the requested unit number
        $kode_baru = $kode_base . '-' . str_pad($request->unit, 3, '0', STR_PAD_LEFT);

        // Generate URL for QR code
        $baseUrl = route('aset.detailbarcode', ['kode_fa' => $fa->kode_fa, 'kode_baru' => $kode_baru]);
        $fullUrl = $baseUrl;

        // Create QR code
        $qrCode = new QrCode($fullUrl);
        $qrCode->setSize(200);
        $qrCode->setMargin(10);

        // Generate and encode QR code
        $writer = new PngWriter();
        $qrCodeImage = $writer->write($qrCode)->getString();
        $base64QrCode = base64_encode($qrCodeImage);

        return view('print.singleqr-code', [
            'qrCode' => $base64QrCode,
            'asset' => $fa,
            'kodebaru' => $kode_baru,
            'unitke' => $request->unit
        ]);
    }

    if ($request->action === 'all') {
        // Split the kode_fa by hyphen
        $parts = explode('-', $fa->kode_fa);
        $base_code = $parts[0]; // 02.01.002.06.011.006
        
        $qrCodes = [];
        
        // Check if there's a range (e.g., 001-003) or just a single unit (001)
        if (count($parts) === 3) {
            // Range case: 02.01.002.06.011.006-001-003
            $start_unit = intval($parts[1]);
            $end_unit = intval($parts[2]);
            
            // Generate QR codes for the range
            for ($i = $start_unit; $i <= $end_unit; $i++) {
                $unit_formatted = str_pad($i, 3, '0', STR_PAD_LEFT);
                $kode_baru = $base_code . '-' . $unit_formatted;
                
                // Generate QR code for each unit
                $baseUrl = route('aset.detailbarcode', ['kode_fa' => $fa->kode_fa, 'kode_baru' => $kode_baru]);
                $qrCode = new QrCode($baseUrl);
                $qrCode->setSize(200);
                $qrCode->setMargin(10);
                
                $writer = new PngWriter();
                $qrCodeImage = $writer->write($qrCode)->getString();
                $base64QrCode = base64_encode($qrCodeImage);
                
                $qrCodes[] = [
                    'kodebaru' => $kode_baru,
                    'unitke' => $i,
                    'qrCode' => $base64QrCode
                ];
            }
        } else {
            // Single unit case: 02.01.002.06.011.006-001
            $unit = $parts[1];
            $kode_baru = $fa->kode_fa; // Use the original kode_fa
            
            // Generate single QR code
            $baseUrl = route('aset.detailbarcode', ['kode_fa' => $fa->kode_fa, 'kode_baru' => $kode_baru]);
            $qrCode = new QrCode($baseUrl);
            $qrCode->setSize(200);
            $qrCode->setMargin(10);
            
            $writer = new PngWriter();
            $qrCodeImage = $writer->write($qrCode)->getString();
            $base64QrCode = base64_encode($qrCodeImage);
            
            $qrCodes[] = [
                'kodebaru' => $kode_baru,
                'unitke' => intval($unit),
                'qrCode' => $base64QrCode
            ];
        }

        return view('print.allqr-code', [
            'assets' => $qrCodes,
            'fa' => $fa
        ]);
    }

    return redirect()->back()->withErrors('Invalid QR code generation request.');
} 

      
    private function generateQRCodeForUnit($fa, $unit)
    {
        // Menyiapkan data untuk QR Code, termasuk kode_fa dan unit
        $data = [
            'kode_fa' => $fa->kode_fa,
            'unit' => $unit,
        ];

        // Menghasilkan QR Code dan mengembalikan data QR Code beserta kode unit
        return [
            'qr_code' => QrCode::size(250)->generate(json_encode($data)),
            'kode_unit' => 'Unit ' . $unit,
        ];
    }
}
