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
        $fa = FixedAsset::with('unitDetails')->where('kode_fa', $request->kode_fa)->first();

        if (!$fa) {
            return redirect()->back()->withErrors('Fixed asset not found.');
        }

        // Extract the base code (everything before the first unit number)
        // Example: from "01.01.006.04.001.002-001-002" get "01.01.006.04.001.002"
        $baseCode = substr($fa->kode_fa, 0, strrpos($fa->kode_fa, '-', strrpos($fa->kode_fa, '-') - strlen($fa->kode_fa) - 1));

        if ($request->action === 'single') {
            $unit = $request->unit;
            $unitDetail = $fa->unitDetails->where('unit_number', $unit)->first();
            
            if (!$unitDetail) {
                return redirect()->back()->withErrors('Unit detail not found.');
            }

            // Format: XX.XX.XXX.XX.XXX.XXX-XXX
            // For single unit, we only append the unit number to the base code
            $kode_baru = $baseCode . '-' . str_pad($unit, 3, '0', STR_PAD_LEFT);

            $baseUrl = route('aset.detailbarcode', [
                'kode_fa' => $fa->kode_fa,
                'kode_baru' => $kode_baru
            ]);
            
            $qrCode = new QrCode($baseUrl);
            $qrCode->setSize(200);
            $qrCode->setMargin(10);

            $writer = new PngWriter();
            $qrCodeImage = $writer->write($qrCode)->getString();
            $base64QrCode = base64_encode($qrCodeImage);

            return view('print.singleqr-code', [
                'qrCode' => $base64QrCode,
                'asset' => $fa,
                'kodebaru' => $kode_baru,
                'unitke' => $unit,
                'unitDetail' => $unitDetail
            ]);
        }

        if ($request->action === 'all') {
            $qrCodes = [];
            
            // Get the unit range from the kode_fa
            $parts = explode('-', $fa->kode_fa);
            $startUnit = (int)$parts[count($parts)-2];
            $endUnit = (int)$parts[count($parts)-1];
            
            // Generate QR codes for each unit in the range
            for ($unitNumber = $startUnit; $unitNumber <= $endUnit; $unitNumber++) {
                $unitDetail = $fa->unitDetails->where('unit_number', $unitNumber)->first();
                
                if (!$unitDetail) {
                    continue;
                }

                // Format individual unit code: XX.XX.XXX.XX.XXX.XXX-XXX
                $kode_baru = $baseCode . '-' . str_pad($unitNumber, 3, '0', STR_PAD_LEFT);
                
                $baseUrl = route('aset.detailbarcode', [
                    'kode_fa' => $fa->kode_fa,
                    'kode_baru' => $kode_baru
                ]);

                $qrCode = new QrCode($baseUrl);
                $qrCode->setSize(200);
                $qrCode->setMargin(10);
                
                $writer = new PngWriter();
                $qrCodeImage = $writer->write($qrCode)->getString();
                $base64QrCode = base64_encode($qrCodeImage);
                
                $qrCodes[] = [
                    'kodebaru' => $kode_baru,
                    'unitke' => $unitNumber,
                    'qrCode' => $base64QrCode,
                    'merk' => $unitDetail->merk,
                    'seri' => $unitDetail->seri
                ];
            }

            return view('print.allqr-code', [
                'assets' => $qrCodes,
                'fa' => $fa
            ]);
        }

        return redirect()->back()->withErrors('Invalid QR code generation request.');
    }

    private function validateAssetCode($kode_fa)
    {
        // Validate format: XX.XX.XXX.XX.XXX.XXX-XXX-XXX
        $pattern = '/^\d{2}\.\d{2}\.\d{3}\.\d{2}\.\d{3}\.\d{3}-\d{3}-\d{3}$/';
        return preg_match($pattern, $kode_fa);
    }

    private function getBaseCode($kode_fa)
    {
        // Returns everything before the unit range (before the first dash of the last two dashes)
        return substr($kode_fa, 0, strrpos($kode_fa, '-', strrpos($kode_fa, '-') - strlen($kode_fa) - 1));
    }
}