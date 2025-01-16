<div class="content-wrapper">
    <div class="content">
        <div class="container">
            <div class="card-grid">
                @foreach ($assets as $asset)
                    <div class="card">
                        <!-- QR Code Section -->
                        <div class="qr-code">
                            <img src="data:image/png;base64,{{ $asset['qrCode'] }}" alt="QR Code">
                        </div>
                        <!-- Text Section -->
                        <div class="info">
                            <div class="title">Unit ke {{ $asset['unitke'] }}</div>
                            <div class="details">
                                <div class="code">Kode FA: <span class="badge">{{ $asset['kodebaru'] }}</span></div>
                                <div>Lokasi: {{ $fa->lokasi->nama_lokasi_yayasan }}</div>
                                <div>Unit: {{ $fa->Institusi->nama_institusi }}</div>
                                <div>Kelompok: {{ $fa->Kelompok->nama_kelompok_yayasan }}</div>
                                <div>Jenis: {{ $fa->Jenis->nama_jenis_yayasan }}</div>
                                <div>Ruang: {{ $fa->Ruang->nama_ruang_yayasan }}</div>
                                <div>Type: {{ $fa->Tipe->nama_tipe_yayasan }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
    @page {
    size: A4;
    margin: 5mm;
}

body {
    margin: 0;
    padding: 0;
}

.content-wrapper {
    width: 100%;
    padding: 0;
}

.container {
    width: 100%;
    max-width: 100%;
    margin: 0 auto;
}

.card-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 5mm;
    width: 100%;
}

.card {
    display: flex;
    flex-direction: row;
    border: 1px solid #ddd;
    border-radius: 2mm;
    padding: 2mm;
    background: white;
    width: 70mm;  /* 7cm length */
    height: 50mm; /* 5cm width */
    page-break-inside: avoid;
    align-items: center; /* Centers content vertically */
}

.qr-code {
    width: 75mm;
    height: 75mm;
    margin-right: 5mm;
    display: flex;
    align-items: center;
}

.qr-code img {
    width: 130%;
    height: 130%;
    object-fit: contain;
}

.info {
    flex: 1;
    font-size: 8pt;
    line-height: 1.2;
    display: flex;
    flex-direction: column;
    justify-content: center; /* Centers content vertically */
    height: 100%;
}

.title {
    font-weight: bold;
    margin-bottom: 1mm;
    font-size: 9pt;
}

.details div {
    margin-bottom: 1mm;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.badge {
    background-color: #17a2b8;
    color: white;
    padding: 0.5mm 1mm;
    border-radius: 1mm;
    font-size: 8pt;
}

@media print {
    .card-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 5mm;
    }

    .card {
        break-inside: avoid;
        page-break-inside: avoid;
    }

    body {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
}
</style>

<script>
    window.onload = function() {
        window.print();
        window.onafterprint = function() {
            window.history.back();
        };
    };
</script>