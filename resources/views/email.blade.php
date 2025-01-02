
<div style="width: 100%; max-width: 950px; margin: 0 auto; padding: 20px; background-color: #f0f0f0; border-radius: 10px;">
    <center>
    <div style="font-family: Arial, sans-serif; font-size: 14px; font-weight: bold; background-color: white; width: 80%; max-width: 500px; margin: 0 auto; padding: 90px; border-radius: 10px; text-align: left;">
    
        <div style="text-align: center;">
            <img src="https://www.atmi.ac.id/images/logo.png" alt="Icon" style="width: 200px; margin-bottom: 20px;">
        </div>
        <hr style="border: none; height: 2px; background-color: #ccc; margin-top: 10px;"> 

        @if($role === 'staff')

        <h2><p>Pengajuan NFA baru saja ditambahkan/mengalami perubahan!</p></h2>
        <div>
        <h3><p>Detail Pengajuan:</p></h3>
        <p>Jenis Ajuan : {{ $jenis ? $jenis : ''}}</p>
        <p>Deskripsi Pengajuan : {{ $deskripsi ? $deskripsi : ''}}</p>
        <p>Tanggal: {{ date('d F Y | H:i T') }}</p>
        <p>Diajukan Oleh : {{ $role }}</p>
        
        @else
        <div>
            <h2><p>Pengajuan NFA anda baru saja mengalami perubahan</p></h2>
            <h3><p>Lihat perubahan yang dilakukan..</p></h3>
            <p>Tanggal: {{ date('d F Y | H:i T') }}</p>
            <p>Oleh : {{ $role }}</p>
        
        @endif
        <a class="button"  href="{{ route('managepermintaannfa.index') }}" style="display: inline-block; padding: 10px 20px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px; margin-top: 20px;">Cek Sekarang!</a>    
        </div>
        <hr style="border: none; height: 2px; background-color: #ccc; margin-top: 20px;"> <!-- Garis penutup -->
    
        <div style="display: flex; justify-content: space-between; margin-top: 20px; background-color: #f0f0f0; padding: 10px; border-radius: 5px;">
            <p style="border-right: 1px solid #ccc; padding-right: 10px; margin-right: 10px;">Email: itatmicorp@gmail.com</p>
            <p style="margin-left: 10px;">No. Telp: +(62) 271-714466</p>
        </div>
    
    </div>
</center>
</div>

