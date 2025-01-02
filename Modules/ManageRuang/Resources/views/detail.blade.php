@extends('layouts.layout_main')
@section('title', 'Data Detail Ruang')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Detail Ruang</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('manageruang.index') }}">Home</a></li>
                            <li class="breadcrumb-item active">Detail Ruang</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h4 class="m-0 text-center text-purple lead">Ruang:
                                    <span class="badge bg-purple">{{ $ruang->kode_ruang }}</span>
                                    <b>{{ $ruang->nama_ruang }}</b>
                                </h4>
                            </div>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-6">
                                        <h3 class="m-0 text-center" id="nama_ruang"><i class="fas fa-tags"></i>
                                            {{ $ruang->nama_ruang }}
                                        </h3>
                                        <h4 class="m-0 text-center">
                                            <span class="badge badge-primary"><i class="fas fa-barcode"></i> Kode :
                                                {{ $ruang->kode_ruang }}</span>
                                        </h4>
                                    </div>
                                    @if(auth()->user()->role_id == 19)
                                    <div class="col-6">
                                        <a href="javascript:void(0)" id="btn-edit-ruang" title="Ubah Tipe"
                                            data-di="{{ $ruang->id_ruang}}" class="btn btn-sm btn-secondary float-right">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Display the image -->
                        <div class="row mb-4">
                            <div class="col-12 text-center">
                                <img src="{{ $ruang->foto_ruang ? asset('foto/fixasetlist/' . basename($ruang->foto_ruang)) : asset('boxs.png') }}" class="product-image" alt="Foto Barang Aset">

                              
                            </div>
                        </div>

                        <div class="card-body">
                            <table class="table table-striped table-sm" id="tbl_lokasi">
                                <thead>
                                    <tr>
                                        <th>Kode Ruang</th>
                                        <th>Nama Ruang Yayasan</th>
                                        <th>Nama Ruang Mikael</th>
                                        <th>Nama Ruang Politeknik</th>
                                        <th class="w-1"><i class="fas fa-bars"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="index_">
                                        <td class="text-center lead">
                                            <span class="badge bg-yellow">{{ $ruang->kode_ruang }}</span>
                                        </td>
                                        <td class="nama-lokasi">{{ $ruang->nama_ruang_yayasan }}</td>
                                        <td class="nama-lokasi">{{ $ruang->nama_ruang_mikael }}</td>
                                        <td class="nama-lokasi">{{ $ruang->nama_ruang_politeknik }}</td>
                                        <td></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Kode Ruang</th>
                                        <th>Nama Ruang Yayasan</th>
                                        <th>Nama Ruang Mikael</th>
                                        <th>Nama Ruang Politeknik</th>
                                        <th class="w-1"><i class="fas fa-bars"></i></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @include('manageruang::modal-edit')
@endsection
