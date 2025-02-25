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

        $baseCode = substr($fa->kode_fa, 0, strrpos($fa->kode_fa, '-', strrpos($fa->kode_fa, '-') - strlen($fa->kode_fa) - 1));

        if ($request->action === 'single') {
            $unit = $request->unit;
            $unitDetail = $fa->unitDetails->where('unit_number', $unit)->first();
            
            // Generate base QR code data
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
                'unitDetail' => $unitDetail // This might be null, view will handle it
            ]);
        }

        if ($request->action === 'all') {
            $qrCodes = [];
            
            // Extract the base code and unit range from kode_fa
            $parts = explode('-', $fa->kode_fa);
            
            // Format: 01.02.001.05.009.001-001-002
            if (count($parts) >= 3) {
                // The base code is everything before the last two segments
                $baseCode = implode('-', array_slice($parts, 0, count($parts) - 2));
                
                // The start and end units are the last two segments
                $startUnit = (int)$parts[count($parts) - 2];
                $endUnit = (int)$parts[count($parts) - 1];
            } 
            // Format: 01.02.001.05.009.001-001 (single unit)
            else if (count($parts) == 2) {
                $baseCode = $parts[0];
                $startUnit = (int)$parts[1];
                $endUnit = $startUnit; // Only one unit
            } 
            else {
                return redirect()->back()->withErrors('Invalid kode_fa format.');
            }
            
            // Generate QR codes for each unit in the range
            for ($unitNumber = $startUnit; $unitNumber <= $endUnit; $unitNumber++) {
                $unitDetail = $fa->unitDetails->where('unit_number', $unitNumber)->first();
                
                // Create the individual kode_fa for this unit
                $kode_baru = $baseCode . '-' . str_pad($unitNumber, 3, '0', STR_PAD_LEFT);
                
                $baseUrl = route('aset.detailbarcode', [
                    'kode_fa' => $fa->kode_fa, // Original kode_fa for reference
                    'kode_baru' => $kode_baru   // Individual unit kode_fa
                ]);
        
                $qrCode = new QrCode($baseUrl);
                $qrCode->setSize(200);
                $qrCode->setMargin(10);
                
                $writer = new PngWriter();
                $qrCodeImage = $writer->write($qrCode)->getString();
                $base64QrCode = base64_encode($qrCodeImage);
                
                // Add to qrCodes array with optional unit details
                $qrCodes[] = [
                    'kodebaru' => $kode_baru,
                    'unitke' => $unitNumber,
                    'qrCode' => $base64QrCode,
                    'merk' => $unitDetail ? $unitDetail->merk : null,
                    'seri' => $unitDetail ? $unitDetail->seri : null,
                    'hasUnitDetails' => !is_null($unitDetail)
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