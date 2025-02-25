@extends('layouts.layout_main')
@section('title', 'Data Aset Tetap')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-6">
                            <h1 class="m-0">Data Aset</h1>
                        </div><!-- /.col -->
                        <div class="col-6">
                            @can('addfa')
                                <a href="{{ route('manageaset.create') }}" class="btn btn-sm btn-info float-right"
                                    id="btn-create-aset">
                                    <i class="fas fa-plus"></i> Aset Tetap
                                </a>
                            @endcan
                        </div>
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <div class="content">
                <div class="container-fluid">
                    <div class="card card-info  collapsed-card">
                        <div class="card-header" style="width: 100%;">
                            <center><h3 class="card-title">Kategori Aset Tetap (Fixed Asset)</h3></center>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Semua Aset Tetap (Fixed Asset)</h3>
                        </div>
                        <div class="card p-4 mb-4">
                            <form method="GET" action="{{ route('manageaset.index') }}" class="row g-3" id="filterForm">
                                <!-- Location Filter -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="lokasi_input" class="form-label fw-bold">Lokasi</label>
                                        <select id="lokasi_input" 
                                                name="id_lokasi" 
                                                class="form-control">
                                            <option value="">-- Pilih Lokasi --</option>
                                            @foreach ($lokasi as $lok)
                                                <option value="{{ $lok->id_lokasi }}" 
                                                        {{ isset($selectedValues['lokasi']) && $selectedValues['lokasi']->id_lokasi == $lok->id_lokasi ? 'selected' : '' }}>
                                                    {{ $lok->nama_lokasi_yayasan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            
                                <!-- Institution Filter -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="institusi_input" class="form-label fw-bold">Institusi</label>
                                        <select id="institusi_input" 
                                                name="id_institusi" 
                                                class="form-control">
                                            <option value="">-- Pilih Institusi --</option>
                                            @foreach ($institusi as $ins)
                                                <option value="{{ $ins->id_institusi }}"
                                                        {{ isset($selectedValues['institusi']) && $selectedValues['institusi']->id_institusi == $ins->id_institusi ? 'selected' : '' }}>
                                                    {{ $ins->nama_institusi }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            
                                <!-- Room Filter -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ruang_input" class="form-label fw-bold">Ruang</label>
                                        <select id="ruang_input" 
                                                name="id_ruang" 
                                                class="form-control">
                                            <option value="">-- Pilih Ruang --</option>
                                            @if(isset($selectedValues['ruang']))
                                                <option value="{{ $selectedValues['ruang']->id_ruang }}" selected>
                                                    {{ $selectedValues['ruang']->nama_ruang }}
                                                </option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            
                                <!-- Group Filter -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="kelompok_input" class="form-label fw-bold">Kelompok</label>
                                        <select id="kelompok_input" 
                                                name="id_kelompok" 
                                                class="form-control">
                                            <option value="">-- Pilih Kelompok --</option>
                                            @foreach ($kelompok as $kel)
                                                <option value="{{ $kel->id_kelompok }}"
                                                        {{ isset($selectedValues['kelompok']) && $selectedValues['kelompok']->id_kelompok == $kel->id_kelompok ? 'selected' : '' }}>
                                                    {{ $kel->nama_kelompok_yayasan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            
                                <!-- Category Filter -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="jenis_input" class="form-label fw-bold">Jenis</label>
                                        <select id="jenis_input" 
                                                name="id_jenis" 
                                                class="form-control">
                                            <option value="">-- Pilih Jenis --</option>
                                            @if(isset($selectedValues['jenis']))
                                                <option value="{{ $selectedValues['jenis']->id_jenis }}" selected>
                                                    {{ $selectedValues['jenis']->nama_jenis_yayasan }}
                                                </option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            
                                <!-- Type Filter -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tipe_input" class="form-label fw-bold">Tipe</label>
                                        <select id="tipe_input" 
                                                name="id_tipe" 
                                                class="form-control">
                                            <option value="">-- Pilih Tipe --</option>
                                            @if(isset($selectedValues['tipe']))
                                                <option value="{{ $selectedValues['tipe']->id_tipe }}" selected>
                                                    {{ $selectedValues['tipe']->nama_tipe_yayasan }}
                                                </option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            
                                <!-- Reset Button -->
                                <div class="col-12 mt-3">
                                    <button type="button" class="btn btn-secondary" onclick="resetFilters()">Reset Filters</button>
                                </div>
                            </form>
                        </div>
                        
                        <div class="card-body">
                           
                            <table id="tbl_permintaanfa" class="table table-striped table-sm" id="tbl_fa">
                                <a href="{{ route('manageaset.export') }}?{{ http_build_query(request()->all()) }}" class="btn btn-success mb-2">
                                    <i class="fas fa-file-excel"></i> Export to Excel
                                </a>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kode Fixed Asset</th>
                                        <th>Nama Aset</th>
                                        <th>Tahun</th>
                                        <th>Transaksi</th>
                                        <th>Jumlah Aset</th>
                                        <th>Kondisi</th>
                                        <th class="w-1"><i class="fas fa-bars"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($aset as $ast)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="text-center lead">
                                                <span class="badge bg-primary">{{ $ast->kode_fa }} </span>
                                            </td>
                                            <td>{{ $ast->nama_barang }}</td>
                                            <td>{{ $ast->tahun_diterima }}</td>
                                            <td>{{ $ast->status_transaksi }}</td>
                                            <td><span class="badge bg-secondary">{{ $ast->jumlah_unit  }} </span></td>
                                            <td>{{ $ast->status_barang }}</td>
                                            <td>
                                                <a href="{{ route('manageaset.detail', $ast->kode_fa) }}"
                                                    title="Detail Aset" class="btn btn-sm btn-light">
                                                    <i class="far fa-folder-open"></i> Detail
                                                </a>
                                                @role('superadmin')
                                                    @if ($ast->status_fa == 0)
                                                        <button id="validateButton"
                                                            class="btn btn-sm btn-danger validate-asset"
                                                            data-id="{{ $ast->kode_fa }}" title="Valid Aset">
                                                            <i class="fa fa-check"></i> Cek Aset
                                                        </button>
                                                    @endif
                                                @endrole
                                                <!-- Tombol Delete -->
                                              
                                                @role('pimpinanunitkarya')
                                                <form action="{{ route('manageaset.destroy', $ast->id_fa) }}" method="POST" style="display:inline;" id="delete-form-{{ $ast->id_fa }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-danger" title="Delete Aset"
                                                        onclick="confirmDelete('{{ $ast->id_fa }}')">
                                                        <i class="fa fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                                @endrole
                                                
                                                <script>
                                                    function confirmDelete(id) {
                                                        Swal.fire({
                                                            title: 'Apakah Anda yakin?',
                                                            text: "Aset ini akan dihapus!",
                                                            icon: 'warning',
                                                            showCancelButton: true,
                                                            confirmButtonColor: '#d33',
                                                            cancelButtonColor: '#3085d6',
                                                            confirmButtonText: 'Ya, hapus!',
                                                            cancelButtonText: 'Batal'
                                                        }).then((result) => { 
                                                            if (result.isConfirmed) {
                                                                document.getElementById('delete-form-' + id).submit();
                                                            }
                                                        });
                                                    }
                                                </script>
                                                
                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Kode Fixed Asset</th>
                                        <th>Nama Aset</th>
                                        <th>Tahun</th>
                                        <th>Transaksi</th>
                                        <th>Jumlah Aset</th>
                                        <th>Kondisi</th>
                                        <th class="w-1"><i class="fas fa-bars"></i></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content -->
        </div>
    </div>
@endsection

@section('scripttambahan')
    <!-- InputMask -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    
<script>
    $(document).ready(function() {
        let debounceTimer;
        let isLoadingData = false;
        
        // Function to debounce form submission
        function debounceSubmit(func, delay) {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(func, delay);
        }
    
        // Function to submit form
        function submitForm() {
            if (!isLoadingData) {
                document.getElementById('filterForm').submit();
            }
        }
    
        // Initial load of dependent dropdowns
        if ($('#institusi_input').val()) {
            loadRuangData($('#institusi_input').val(), false);
        }
        
        if ($('#kelompok_input').val()) {
            loadJenisData($('#kelompok_input').val(), false);
        }
        
        if ($('#jenis_input').val()) {
            loadTipeData($('#jenis_input').val(), false);
        }
    
        // Add change event listeners for all select elements
        $('#filterForm select').on('change', function() {
            const selectId = $(this).attr('id');
            
            // Set loading flag
            isLoadingData = true;
            
            // Handle dependent dropdowns
            if (selectId === 'institusi_input') {
                loadRuangData($(this).val(), true);
            } else if (selectId === 'kelompok_input') {
                loadJenisData($(this).val(), true);
            } else if (selectId === 'jenis_input') {
                loadTipeData($(this).val(), true);
            } else {
                // For non-dependent dropdowns, submit immediately
                isLoadingData = false;
                debounceSubmit(submitForm, 500);
            }
        });
    
        // Function to load Ruang data
        function loadRuangData(institusiId, shouldSubmit = true) {
            $('#ruang_input').empty().append('<option value="">-- Pilih Ruang --</option>');
            
            if (!institusiId) {
                isLoadingData = false;
                if (shouldSubmit) debounceSubmit(submitForm, 500);
                return;
            }
    
            $.ajax({
                url: '{{ route("getRoomsByInstitution") }}',
                type: 'GET',
                data: { id_institusi: institusiId },
                success: function(response) {
                    if (response && response.length > 0) {
                        response.forEach(function(room) {
                            let selected = @json(isset($selectedValues['ruang']) ? $selectedValues['ruang']->id_ruang : null) == room.id_ruang;
                            $('#ruang_input').append(
                                $('<option></option>')
                                    .val(room.id_ruang)
                                    .text(room.nama_ruang)
                                    .prop('selected', selected)
                            );
                        });
                    }
                    isLoadingData = false;
                    if (shouldSubmit) debounceSubmit(submitForm, 500);
                },
                error: function() {
                    isLoadingData = false;
                    if (shouldSubmit) debounceSubmit(submitForm, 500);
                }
            });
        }
    
        // Function to load Jenis data
        function loadJenisData(kelompokId, shouldSubmit = true) {
            $('#jenis_input').empty().append('<option value="">-- Pilih Jenis --</option>');
            $('#tipe_input').empty().append('<option value="">-- Pilih Tipe --</option>');
            
            if (!kelompokId) {
                isLoadingData = false;
                if (shouldSubmit) debounceSubmit(submitForm, 500);
                return;
            }
    
            $.ajax({
                url: '{{ route("getJenisByKelompok3") }}',
                type: 'GET',
                data: { id_kelompok: kelompokId },
                success: function(response) {
                    if (response && response.length > 0) {
                        response.forEach(function(jenis) {
                            let selected = @json(isset($selectedValues['jenis']) ? $selectedValues['jenis']->id_jenis : null) == jenis.id_jenis;
                            $('#jenis_input').append(
                                $('<option></option>')
                                    .val(jenis.id_jenis)
                                    .text(jenis.nama_jenis_yayasan)
                                    .prop('selected', selected)
                            );
                        });
                        
                        // If there was a previously selected jenis, load its types
                        if ($('#jenis_input').val()) {
                            loadTipeData($('#jenis_input').val(), shouldSubmit);
                        } else {
                            isLoadingData = false;
                            if (shouldSubmit) debounceSubmit(submitForm, 500);
                        }
                    } else {
                        isLoadingData = false;
                        if (shouldSubmit) debounceSubmit(submitForm, 500);
                    }
                },
                error: function() {
                    isLoadingData = false;
                    if (shouldSubmit) debounceSubmit(submitForm, 500);
                }
            });
        }
    
        // Function to load Tipe data
        function loadTipeData(jenisId, shouldSubmit = true) {
            $('#tipe_input').empty().append('<option value="">-- Pilih Tipe --</option>');
            
            if (!jenisId) {
                isLoadingData = false;
                if (shouldSubmit) debounceSubmit(submitForm, 500);
                return;
            }
    
            $.ajax({
                url: '{{ route("getTipeByJenis1") }}',
                type: 'GET',
                data: { id_jenis: jenisId },
                success: function(response) {
                    if (response && response.length > 0) {
                        response.forEach(function(tipe) {
                            let selected = @json(isset($selectedValues['tipe']) ? $selectedValues['tipe']->id_tipe : null) == tipe.id_tipe;
                            $('#tipe_input').append(
                                $('<option></option>')
                                    .val(tipe.id_tipe)
                                    .text(tipe.nama_tipe_yayasan)
                                    .prop('selected', selected)
                            );
                        });
                    }
                    isLoadingData = false;
                    if (shouldSubmit) debounceSubmit(submitForm, 500);
                },
                error: function() {
                    isLoadingData = false;
                    if (shouldSubmit) debounceSubmit(submitForm, 500);
                }
            });
        }
    
        // Reset filters function
        window.resetFilters = function() {
            isLoadingData = false;
            const selects = document.querySelectorAll('#filterForm select');
            selects.forEach(select => {
                select.value = '';
            });
            submitForm();
        }
    });
    </script>
    <!-- Page specific script -->
    <script>
        $(document).ready(function() {
            $('#tbl_permintaanfa').DataTable({
                // Optional configurations
                paging: true,
                pageLength: 10, // Show 10 records per page
                searching: true,
                ordering: true,
                order: [[0, 'asc']], // Sort by first column
            });
        });
      </script>
   
    <script>
        $(document).ready(function() {
            $('.validate-asset').click(async function() {
                var assetId = $(this).data('id');

                const confirmed = await confirmValidation();

                if (confirmed) {
                    await performValidation(assetId);
                }
            });

            async function confirmValidation() {
                const result = await Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Anda tidak dapat mengembalikan ini!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Validasi!'
                });

                return result.isConfirmed;
            }

            async function performValidation(assetId) {
                try {
                    const response = await $.ajax({
                        type: 'POST',
                        url: '{{ route('manageaset.valid_fa', ['kode_fa' => '__assetId__']) }}'
                            .replace('__assetId__', assetId),
                        data: {
                            'assetId': assetId,
                            '_token': '{{ csrf_token() }}'
                        },
                    });

                    // Tampilkan SweetAlert jika validasi berhasil
                    Swal.fire({
                        icon: 'success',
                        title: 'Hei...',
                        text: 'Validasi berhasil',
                        showConfirmButton: false,
                        timer: 2500
                    });

                    // Sembunyikan tombol setelah validasi berhasil
                    $('#validateButton').hide();
                } catch (error) {
                    // Handle the error response
                    console.log(error);

                    // Tampilkan SweetAlert jika validasi gagal
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Validasi gagal',
                    });
                }
            }
        });
    </script>
@if (session('success'))
@once
<div class="alert alert-success">
    <script>
        var isi = @json(session('notification'));
        Swal.fire({
            icon: 'success',
            title: 'Berhasil..',
            text: isi,
            showConfirmButton: false,
            timer: 2500
        });
    </script>
</div>
@endonce
@endif
@endsection
