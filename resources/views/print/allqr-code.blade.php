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
        margin: 0.5in;
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
        gap: 15px;
        width: 100%;
    }

    .card {
        display: flex;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 10px;
        background: white;
        height: 120px;
        page-break-inside: avoid;
    }

    .qr-code {
        width: 100px;
        height: 100px;
        margin-right: 10px;
    }

    .qr-code img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .info {
        flex: 1;
        font-size: 11px;
        line-height: 1.2;
    }

    .title {
        font-weight: bold;
        margin-bottom: 4px;
    }

    .details div {
        margin-bottom: 2px;
    }

    .badge {
        background-color: #17a2b8;
        color: white;
        padding: 1px 4px;
        border-radius: 3px;
        font-size: 10px;
    }

    @media print {
        .card-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
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