<div class="content-wrapper">
    <div class="content">
        <div class="container">
            <div class="card-grid">
                @foreach ($assets as $asset)
                    <div class="card">
                        <div class="qr-code">
                            <img src="data:image/png;base64,{{ $asset['qrCode'] }}" alt="QR Code">
                        </div>
                        <div class="info">
                            <div class="title">Unit ke {{ $asset['unitke'] }}</div>
                            <div class="details">
                                <div>Kode FA: {{ $asset['kodebaru'] }}</div>
                                <div>Lokasi: {{ $fa->lokasi->nama_lokasi_yayasan }}</div>
                                <div>Unit: {{ $fa->Institusi->nama_institusi }}</div>
                                <div>Kelompok: {{ $fa->Kelompok->nama_kelompok_yayasan }}</div>
                                <div>Jenis: {{ $fa->Jenis->nama_jenis_yayasan }}</div>
                                <div>Ruang: {{ $fa->Ruang->nama_ruang }}</div>
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
        size: 70mm 50mm; /* Set page size to 5mm x 7mm */
        margin: 0; /* Remove all margins */
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
    flex-direction: row; /* Change to row layout for horizontal alignment */
    justify-content: space-between; /* Add space between QR code and text */
    align-items: center; /* Center-align items vertically */
    border: none;
    padding: 0;
    background: white;
    width: 70mm;
    height: 50mm;
    page-break-after: always;
}

.qr-code {
    width: 30mm;  /* Adjust QR code width */
    height: 30mm; /* Adjust QR code height */
    margin-left: 2mm; /* Add some space from the edge */
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
    text-align: left; /* Align text to the left */
    margin-left: 2mm; /* Add spacing between QR code and text */
    width: 45mm; /* Adjust width to fit the remaining space */
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
                margin: 0; /* Remove margins for exact fit */
            }
        `;
        document.head.appendChild(styleElement);
    }

    window.onload = function() {
        // Set the desired page size to 5mm x 7mm
        setPageSize('70mm 50mm');

        // Trigger the print function
        window.print();

        // Go back to the previous page after printing
        window.onafterprint = function() {
            window.history.back();
        };
    };
</script>


