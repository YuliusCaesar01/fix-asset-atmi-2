<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jenis;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class JenisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $jenis = array(
            array('id_jenis' => '1', 'nama_jenis_yayasan' => 'Meja', 'kode_jenis' => '001', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('id_jenis' => '2', 'nama_jenis_yayasan' => 'Kursi', 'kode_jenis' => '002', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('id_jenis' => '3', 'nama_jenis_yayasan' => 'CPU', 'kode_jenis' => '003', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('id_jenis' => '4', 'nama_jenis_yayasan' => 'Printer', 'kode_jenis' => '004', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('id_jenis' => '5', 'nama_jenis_yayasan' => 'Loker 4X3', 'kode_jenis' => '005', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('id_jenis' => '6', 'nama_jenis_yayasan' => 'Loker 4X2', 'kode_jenis' => '006', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('id_jenis' => '7', 'nama_jenis_yayasan' => 'Rak/Almari', 'kode_jenis' => '007', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('id_jenis' => '8', 'nama_jenis_yayasan' => 'Ekshause', 'kode_jenis' => '008', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('id_jenis' => '9', 'nama_jenis_yayasan' => 'AC', 'kode_jenis' => '009', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('id_jenis' => '10', 'nama_jenis_yayasan' => 'Dispenser', 'kode_jenis' => '010', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('id_jenis' => '11', 'nama_jenis_yayasan' => 'Role Kabel', 'kode_jenis' => '011', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('id_jenis' => '12', 'nama_jenis_yayasan' => 'Jam Dinding', 'kode_jenis' => '012', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('id_jenis' => '13', 'nama_jenis_yayasan' => 'Tempat Sampah', 'kode_jenis' => '013', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('id_jenis' => '14', 'nama_jenis_yayasan' => 'Salib', 'kode_jenis' => '014', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('id_jenis' => '15', 'nama_jenis_yayasan' => 'Apar', 'kode_jenis' => '015', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('id_jenis' => '16', 'nama_jenis_yayasan' => 'Tabung Oksigen', 'kode_jenis' => '016', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('id_jenis' => '17', 'nama_jenis_yayasan' => 'Regulator Oksigen', 'kode_jenis' => '017', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('id_jenis' => '18', 'nama_jenis_yayasan' => 'Tangga Lipat', 'kode_jenis' => '018', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('id_jenis' => '19', 'nama_jenis_yayasan' => 'Senter Tangan', 'kode_jenis' => '019', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('id_jenis' => '20', 'nama_jenis_yayasan' => 'Head Lamp', 'kode_jenis' => '020', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('id_jenis' => '21', 'nama_jenis_yayasan' => 'Troli/Handlift', 'kode_jenis' => '021', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('id_jenis' => '22', 'nama_jenis_yayasan' => 'Kotak Kunci', 'kode_jenis' => '022', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('id_jenis' => '23', 'nama_jenis_yayasan' => 'Gerobak Angkut', 'kode_jenis' => '023', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('id_jenis' => '24', 'nama_jenis_yayasan' => 'Ankong', 'kode_jenis' => '024', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('id_jenis' => '25', 'nama_jenis_yayasan' => 'Torn Air', 'kode_jenis' => '025', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('id_jenis' => '26', 'nama_jenis_yayasan' => 'Safety Harnes', 'kode_jenis' => '026', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('id_jenis' => '27', 'nama_jenis_yayasan' => 'Helm Proyek', 'kode_jenis' => '027', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('id_jenis' => '28', 'nama_jenis_yayasan' => 'Dril Beton', 'kode_jenis' => '028', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('id_jenis' => '29', 'nama_jenis_yayasan' => 'Bor Listrik', 'kode_jenis' => '029', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('id_jenis' => '30', 'nama_jenis_yayasan' => 'Bor Baterai', 'kode_jenis' => '030', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '31', 'nama_jenis_yayasan' => 'WaterPass', 'kode_jenis' => '031', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '32', 'nama_jenis_yayasan' => 'Multi Tester Digital', 'kode_jenis' => '032', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '33', 'nama_jenis_yayasan' => 'Kunci L', 'kode_jenis' => '033', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '34', 'nama_jenis_yayasan' => 'Palu Besi', 'kode_jenis' => '034', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '35', 'nama_jenis_yayasan' => 'Hammer', 'kode_jenis' => '035', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '36', 'nama_jenis_yayasan' => 'Cetok', 'kode_jenis' => '036', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '37', 'nama_jenis_yayasan' => 'Catut', 'kode_jenis' => '037', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '38', 'nama_jenis_yayasan' => 'Roll meter', 'kode_jenis' => '038', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '39', 'nama_jenis_yayasan' => 'Grenda Tangan', 'kode_jenis' => '039', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '40', 'nama_jenis_yayasan' => 'Mesin', 'kode_jenis' => '040', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '41', 'nama_jenis_yayasan' => 'Peralatan Las', 'kode_jenis' => '041', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '42', 'nama_jenis_yayasan' => 'Betel', 'kode_jenis' => '042', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '43', 'nama_jenis_yayasan' => 'Kunci Besi 6mm', 'kode_jenis' => '043', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '44', 'nama_jenis_yayasan' => 'Clam Drat', 'kode_jenis' => '044', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '45', 'nama_jenis_yayasan' => 'Spindle Key', 'kode_jenis' => '045', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '46', 'nama_jenis_yayasan' => 'Sprinkle Toilet', 'kode_jenis' => '046', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '47', 'nama_jenis_yayasan' => 'Sekop', 'kode_jenis' => '047', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '48', 'nama_jenis_yayasan' => 'Selang Timbang', 'kode_jenis' => '048', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '49', 'nama_jenis_yayasan' => 'Kompressor Portable', 'kode_jenis' => '049', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '50', 'nama_jenis_yayasan' => 'Sky Folding', 'kode_jenis' => '050', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '51', 'nama_jenis_yayasan' => 'Linggis', 'kode_jenis' => '051', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '52', 'nama_jenis_yayasan' => 'Gunting Seng', 'kode_jenis' => '052', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '53', 'nama_jenis_yayasan' => 'Granding', 'kode_jenis' => '053', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '54', 'nama_jenis_yayasan' => 'GrossCut Shreader', 'kode_jenis' => '054', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '55', 'nama_jenis_yayasan' => 'Dinning Cabinet', 'kode_jenis' => '055', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '56', 'nama_jenis_yayasan' => 'Brankas', 'kode_jenis' => '056', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '57', 'nama_jenis_yayasan' => 'UPS', 'kode_jenis' => '057', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '58', 'nama_jenis_yayasan' => 'Mesin Ketik', 'kode_jenis' => '058', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '59', 'nama_jenis_yayasan' => 'Scanner', 'kode_jenis' => '059', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '60', 'nama_jenis_yayasan' => 'Pesawat Telpon', 'kode_jenis' => '060', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '61', 'nama_jenis_yayasan' => 'Backdrop Photo', 'kode_jenis' => '061', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '62', 'nama_jenis_yayasan' => 'Sofa', 'kode_jenis' => '062', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '63', 'nama_jenis_yayasan' => 'Mobile File', 'kode_jenis' => '063', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '64', 'nama_jenis_yayasan' => 'Purifier', 'kode_jenis' => '064', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '65', 'nama_jenis_yayasan' => 'Kulkas', 'kode_jenis' => '065', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '66', 'nama_jenis_yayasan' => 'Water Dispenser', 'kode_jenis' => '066', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '67', 'nama_jenis_yayasan' => 'Papan Tulis Ka', 'kode_jenis' => '067', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '68', 'nama_jenis_yayasan' => 'Loker 1X4', 'kode_jenis' => '068', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '69', 'nama_jenis_yayasan' => 'Tangga Lipat Multi', 'kode_jenis' => '069', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '70', 'nama_jenis_yayasan' => 'Viewer', 'kode_jenis' => '070', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
          array('id_jenis' => '71', 'nama_jenis_yayasan' => 'Foto Presiden dan Wapres', 'kode_jenis' => '071', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '72', 'nama_jenis_yayasan' => 'Dining Kabinet', 'kode_jenis' => '072', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '73', 'nama_jenis_yayasan' => 'Piagam PBB', 'kode_jenis' => '073', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '74', 'nama_jenis_yayasan' => 'Bangku', 'kode_jenis' => '074', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '75', 'nama_jenis_yayasan' => 'Altar', 'kode_jenis' => '075', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '76', 'nama_jenis_yayasan' => 'Apar Powder', 'kode_jenis' => '076', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '77', 'nama_jenis_yayasan' => 'Sekat Stainless', 'kode_jenis' => '077', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '78', 'nama_jenis_yayasan' => 'Peralatan Sound System', 'kode_jenis' => '078', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '79', 'nama_jenis_yayasan' => 'Kipas Angin', 'kode_jenis' => '079', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
    array('id_jenis' => '80', 'nama_jenis_yayasan' => 'PC', 'kode_jenis' => '080', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now())

);

        DB::table('jenis')->insert($jenis);
    }
}
