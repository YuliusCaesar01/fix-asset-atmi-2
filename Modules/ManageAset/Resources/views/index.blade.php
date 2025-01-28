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
                                        <input list="lokasi_list" 
                                               id="lokasi_input" 
                                               name="id_lokasi" 
                                               class="form-control" 
                                               placeholder="-- Pilih Lokasi --"
                                               value="{{ $selectedValues['lokasi']->nama_lokasi_yayasan ?? '' }}">
                                        <datalist id="lokasi_list">
                                            @foreach ($lokasi as $lok)
                                                <option value="{{ $lok->nama_lokasi_yayasan }}" data-value="{{ $lok->id_lokasi }}">
                                            @endforeach
                                        </datalist>
                                    </div>
                                </div>
                            
                                <!-- Institution Filter -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="institusi_input" class="form-label fw-bold">Institusi</label>
                                        <input list="institusi_list" 
                                               id="institusi_input" 
                                               name="id_institusi" 
                                               class="form-control" 
                                               placeholder="-- Pilih Institusi --"
                                               value="{{ $selectedValues['institusi']->nama_institusi ?? '' }}">
                                        <datalist id="institusi_list">
                                            @foreach ($institusi as $ins)
                                                <option value="{{ $ins->nama_institusi }}" data-value="{{ $ins->id_institusi }}">
                                            @endforeach
                                        </datalist>
                                    </div>
                                </div>
                            
                                <!-- Room Filter -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ruang_input" class="form-label fw-bold">Ruang</label>
                                        <input list="ruang_list" 
                                               id="ruang_input" 
                                               name="id_ruang" 
                                               class="form-control" 
                                               placeholder="-- Pilih Ruang --"
                                               value="{{ $selectedValues['ruang']->nama_ruang ?? '' }}">
                                        <datalist id="ruang_list">
                                            @foreach ($ruang as $ru)
                                                <option value="{{ $ru->nama_ruang }}" data-value="{{ $ru->id_ruang }}">
                                            @endforeach
                                        </datalist>
                                    </div>
                                </div>
                                
                                <!-- Group Filter -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="kelompok_input" class="form-label fw-bold">Kelompok</label>
                                        <input list="kelompok_list" 
                                               id="kelompok_input" 
                                               name="id_kelompok" 
                                               class="form-control" 
                                               placeholder="-- Pilih Kelompok --"
                                               value="{{ $selectedValues['kelompok']->nama_kelompok_yayasan ?? '' }}">
                                        <datalist id="kelompok_list">
                                            @foreach ($kelompok as $kel)
                                                <option value="{{ $kel->nama_kelompok_yayasan }}" data-value="{{ $kel->id_kelompok }}">
                                            @endforeach
                                        </datalist>
                                    </div>
                                </div>
                            
                                <!-- Category Filter -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="jenis_input" class="form-label fw-bold">Jenis</label>
                                        <input list="jenis_list" 
                                               id="jenis_input" 
                                               name="id_jenis" 
                                               class="form-control" 
                                               placeholder="-- Pilih Jenis --"
                                               value="{{ $selectedValues['jenis']->nama_jenis_yayasan ?? '' }}">
                                        <datalist id="jenis_list">
                                            @foreach ($jenis as $jen)
                                                <option value="{{ $jen->nama_jenis_yayasan }}" data-value="{{ $jen->id_jenis }}">
                                            @endforeach
                                        </datalist>
                                    </div>
                                </div>
                            
                                <!-- Type Filter -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tipe_input" class="form-label fw-bold">Tipe</label>
                                        <input list="tipe_list" 
                                               id="tipe_input" 
                                               name="id_tipe" 
                                               class="form-control" 
                                               placeholder="-- Pilih Tipe --"
                                               value="{{ $selectedValues['tipe']->nama_tipe_yayasan ?? '' }}">
                                        <datalist id="tipe_list">
                                            @foreach ($tipe as $tip)
                                                <option value="{{ $tip->nama_tipe_yayasan }}" data-value="{{ $tip->id_tipe }}">
                                            @endforeach
                                        </datalist>
                                    </div>
                                </div>
                                
                                <!-- Filter and Reset Buttons -->
                                <div class="col-12 mt-3">
                                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                                    <button type="button" class="btn btn-secondary" onclick="resetFilters()">Reset Filters</button>
                                </div>
                            </form>
                        </div>
                        
                        <div class="card-body">
                           
                            <table id="tbl_permintaanfa" class="table table-striped table-sm" id="tbl_fa">
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
            // Handle kelompok change
            $('#kelompok_input').on('input', function() {
                let kelompokName = $(this).val();
                let kelompokId = $('#kelompok_list option').filter(function() {
                    return this.value === kelompokName;
                }).data('value');
        
                // Clear jenis input and datalist
                $('#jenis_input').val('');
                $('#jenis_list').empty();
                
                if (!kelompokId) {
                    return;
                }
                
                // Fetch jenis for selected kelompok
                $.ajax({
                    url: '{{ route("getJenisByKelompok3") }}',
                    type: 'GET',
                    data: { id_kelompok: kelompokId },
                    success: function(response) {
                        if (response && response.length > 0) {
                            response.forEach(function(jenis) {
                                $('#jenis_list').append(
                                    $('<option></option>')
                                        .val(jenis.nama_jenis_yayasan)
                                        .attr('data-value', jenis.id_jenis)
                                );
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching jenis:', error);
                    }
                });
            });

            $('#jenis_input').on('input', function() {
                let jenisName = $(this).val();
                let jenisId = $('#jenis_list option').filter(function() {
                    return this.value === jenisName;
                }).data('value');
        
                // Clear tipe input and datalist
                $('#tipe_input').val('');
                $('#tipe_list').empty();
                
                if (!jenisId) {
                    return;
                }
                
                // Fetch jenis for selected Jenis
                $.ajax({
                    url: '{{ route("getTipeByJenis1") }}',
                    type: 'GET',
                    data: { id_jenis: jenisId },
                    success: function(response) {
                        if (response && response.length > 0) {
                            response.forEach(function(tipe) {
                                $('#tipe_list').append(
                                    $('<option></option>')
                                        .val(tipe.nama_tipe_yayasan)
                                        .attr('data-value', tipe.id_tipe)
                                );
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching jenis:', error);
                    }
                });
            });
        
            // Keep your existing institution/ruang handling code
            $('#institusi_input').on('input', function() {
                let institusiName = $(this).val();
                let institusiId = $('#institusi_list option').filter(function() {
                    return this.value === institusiName;
                }).data('value');
        
                // Clear room input and datalist
                $('#ruang_input').val('');
                $('#ruang_list').empty();
                
                if (!institusiId) {
                    return;
                }
                
                // Fetch rooms for selected institution
                $.ajax({
                    url: '{{ route("getRoomsByInstitution") }}',
                    type: 'GET',
                    data: { id_institusi: institusiId },
                    success: function(response) {
                        if (response && response.length > 0) {
                            response.forEach(function(room) {
                                $('#ruang_list').append(
                                    $('<option></option>')
                                        .val(room.nama_ruang)
                                        .attr('data-value', room.id_ruang)
                                );
                            });
                        }
                    }
                });
            });
        
            // Handle form submission
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();
                
                // Get all inputs with datalists
                const inputs = {
                    'lokasi_input': 'id_lokasi',
                    'institusi_input': 'id_institusi',
                    'ruang_input': 'id_ruang',
                    'kelompok_input': 'id_kelompok',
                    'jenis_input': 'id_jenis',
                    'tipe_input': 'id_tipe'
                };
                
                // Create a new FormData object
                const formData = new FormData(this);
                
                // Update the form data with the correct IDs
                Object.entries(inputs).forEach(([inputId, paramName]) => {
                    const input = document.getElementById(inputId);
                    const datalist = document.getElementById(input.getAttribute('list'));
                    const option = Array.from(datalist.options).find(opt => opt.value === input.value);
                    
                    if (option) {
                        formData.set(paramName, option.dataset.value);
                    } else {
                        formData.set(paramName, '');
                    }
                });
                
                // Convert FormData to URL parameters
                const params = new URLSearchParams(formData);
                
                // Redirect to the URL with parameters
                window.location.href = `${this.action}?${params.toString()}`;
            });
        
            // Reset filters function
            window.resetFilters = function() {
                const inputs = document.querySelectorAll('#filterForm input[list]');
                inputs.forEach(input => {
                    input.value = '';
                });
                document.getElementById('filterForm').submit();
            }
        });
        </script>
    <script>
        $(document).ready(function() {
            //button create post event
            $('body').on('click', '#btn-detail-aset', function() {
                let kode = $(this).data('di');

                $.ajax({
                    type: "GET",
                    success: function(response) {
                        // Redirect ke URL yang diterima dalam respons
                        window.location.href = `/aset/manageaset/detail/${kode}`;
                    },
                    error: function(xhr, status, error) {
                        // Tangani kesalahan jika diperlukan
                        console.error(xhr.responseText);
                    }
                });

            });

            $('#institusi').on('change', function() {
                let institusiId = $(this).val();

                $.ajax({
                    url: '{{ route('getDivisi') }}',
                    type: 'GET',
                    data: {
                        'id_institusi': institusiId
                    },
                    success: function(data) {
                        if (data) {
                            let all_option = "<option value=''>- Pilih Divisi -</option>";
                            $('#divisi').empty();
                            $.each(data, function(key, value) {
                                all_option += "<option value='" + value.id_divisi +
                                    "'>" + value.nama_divisi + "</option>";
                                // $('#divisi').append('<option value="' + value.id_divisi +
                                //     '">' + value.nama_divisi + '</option>');
                            });
                            $('#divisi').html(all_option);
                        }
                    }
                });
            });

            $('#tipe').on('change', function() {
                let tipeId = $(this).val();

                $.ajax({
                    url: '{{ route('getKelompok') }}',
                    type: 'GET',
                    data: {
                        'id_tipe': tipeId
                    },
                    success: function(data) {
                        if (data) {
                            let all_option = "<option value=''>- Pilih Kelompok -</option>";
                            $('#kelompok').empty();
                            $.each(data, function(key, value) {
                                all_option += "<option value='" + value.id_kelompok +
                                    "'>" + value.nama_kelompok + "</option>";
                            });
                            $('#kelompok').html(all_option);
                        }
                    }
                });
            });

            $('#kelompok').on('change', function() {
                let kelompokId = $(this).val();

                $.ajax({
                    url: '/aset/getJenis',
                    type: 'GET',
                    data: {
                        'id_kelompok': kelompokId
                    },
                    success: function(data) {
                        if (data && data.length > 0) {
                            let all_option = "<option value=''>- Pilih Jenis -</option>";
                            $('#jenis').empty();
                            $.each(data, function(key, value) {
                                all_option += '<option value="' +
                                    value.id_jenis +
                                    '">' + value.nama_jenis + '</option>';
                            });
                            $('#jenis').html(all_option);
                        }
                    }
                });
            });

            $('#lokasi').on('change', function() {
                let lokasiId = $(this).val();
                let divisiId = $('#divisi').val();

                $.ajax({
                    url: '{{ route('getRuang') }}',
                    type: 'GET',
                    data: {
                        'id_lokasi': lokasiId,
                        'id_divisi': divisiId
                    },
                    success: function(data) {
                        if (data && data.length > 0) {
                            let all_option = "<option value=''>- Pilih Ruang -</option>";
                            $('#ruang').empty();
                            $.each(data, function(key, value) {
                                all_option += '<option value="' +
                                    value.id_ruang +
                                    '">' + value.nama_ruang + '</option>';
                            });
                            $('#ruang').html(all_option);
                        } else {
                            $('#ruang').empty();
                        }
                    }
                });
            });
            $('[data-mask]').inputmask()
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
