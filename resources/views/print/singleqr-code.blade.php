<div class="content-wrapper">
    <div class="content">
        <div class="container">
            <div class="card-grid">
                <div class="card">
                    <div class="qr-code">
                        <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code">
                    </div>
                    <div class="info">
                        <div class="title">Unit ke {{ $unitke }}</div>
                        <div class="details">
                            <div>Kode FA: {{ $kodebaru }}</div>
                            <div>Lokasi: {{ $asset->lokasi->nama_lokasi_yayasan }}</div>
                            <div>Unit: {{ $asset->Institusi->nama_institusi }}</div>
                            <div>Kelompok: {{ $asset->Kelompok->nama_kelompok_yayasan }}</div>
                            <div>Jenis: {{ $asset->Jenis->nama_jenis_yayasan }}</div>
                            <div>Ruang: {{ $asset->Ruang->nama_ruang}}</div>
                            <div>Type: {{ $asset->Tipe->nama_tipe_yayasan }}</div>
                            @if($unitDetail->merk)<div>Merk: {{ $unitDetail->merk }}</div>@endif
                            @if($unitDetail->seri)<div>Seri: {{ $unitDetail->seri }}</div>@endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @page {
        size: 70mm 50mm;
        margin: 0;
    }

    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        width: 70mm;
        height: 50mm;
        font-weight: bold;
    }

    .content-wrapper {
        width: 70mm;
        height: 50mm;
        padding: 0;
    }

    .container {
        width: 70mm;
        height: 50mm;
        margin: 0;
        padding: 0;
    }

    .card-grid {
        display: block;
        width: 70mm;
        height: 50mm;
    }

    .card {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        border: none;
        padding: 0;
        background: white;
        width: 70mm;
        height: 50mm;
        page-break-after: always;
    }

    .qr-code {
        width: 30mm;
        height: 30mm;
        margin-left: 2mm;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .qr-code img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .info {
        font-size: 6.5pt;
        line-height: 1.2;
        text-align: left;
        margin-left: 2mm;
        width: 45mm;
    }

    .title {
        font-weight: bold;
        margin-bottom: 0.5mm;
        font-size: 6.5pt;
    }

    .details div {
        margin-bottom: 0.2mm;
        white-space: nowrap;
        text-overflow: ellipsis;
        font-size: 6.5pt;
    }

    @media print {
        .card {
            break-after: page;
            page-break-after: always;
        }

        body {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }
</style>

<script>
    function setPageSize(size) {
        const styleElement = document.createElement('style');
        styleElement.textContent = `
            @page {
                size: ${size};
                margin: 0;
            }
        `;
        document.head.appendChild(styleElement);
    }

    window.onload = function() {
        setPageSize('70mm 50mm');
        window.print();
        window.onafterprint = function() {
            window.history.back();
        };
    };
</script>