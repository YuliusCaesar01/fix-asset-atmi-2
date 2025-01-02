@extends('layouts.layout_main')
@section('title', 'Tambah Aset Tetap')
@section('scriptheadtambahan')
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-6">
                            <h1 class="m-0">Edit Non Fixed Assets(NFA)</h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <div class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header d-flex p-0">
                            <h3 class="card-title p-3">Anda {{$role}} || Non Fixed Assets</h3>
                            <ul class="nav nav-pills ml-auto p-2">
                                <a class="nav-link active btn btn-secondary" href="{{ route('managepermintaannfa.index') }}" data-toggle="tab">Exit</a>
                                
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            @if (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    @if ($role != 'staff' ) <!-- Check the role -->
                                    <form action="{{ route('validasiatasan', $datauser->id_permintaan_nfa) }}" method="post">
                                        @csrf                                    
                                        <input type="hidden" id="id_fa">

                                            @if ($role === 'kepalaunit' )
                                            <div class="form-group">
                                                <label for="approval_status" class="control-label">Approval Status</label>
                                                <select class="form-control" id="approval_status" name="approval_status" onchange="toggleAdditionalFields()">
                                                    <option value="setuju">Setuju</option>
                                                    <option value="ditolak">Tolak</option>
                                                    <option value="revisi">Revisi</option>
                                                </select>
                                            </div>
                                            @endif
                                            <div id="revisi_fields1" style="display: none;">
                                                <div class="form-group">
                                                    <label for="revision_comment">Revision/tolak Comment</label>
                                                    <textarea class="form-control" rows="3" name="revision_comment" id="revision_comment"></textarea>
                                                </div>
                                            </div>
                                            @if($role === 'manager' && $datauser->validasi_availability != "setuju")
                                            <div class="form-group">
                                                <label for="availability_status" class="control-label">Availability</label>
                                                <select class="form-control" id="availability_status" name="availability_status" onchange="toggleAdditionalFields()">
                                                    <option value="setuju">Setuju</option>
                                                    <option value="ditolak">Tolak</option>
                                                    <option value="revisi">Revisi</option>
                                                </select>
                                            </div>
                                            @endif
                                            @if($role === 'finance' && $datauser->validasi_availability === "setuju")
                                            <div class="form-group">
                                                <label for="finance_status" class="control-label">Availability</label>
                                                <select class="form-control" id="finance_status" name="finance_status" onchange="toggleAdditionalFields()">
                                                    <option value="setuju">Setuju</option>
                                                    <option value="ditolak">Tolak</option>
                                                    <option value="revisi">Revisi</option>
                                                </select>
                                            </div>
                                            @endif
                                            <div id="revisi_fields2" style="display: none;">
                                                <div class="form-group">
                                                    <label for="revision_comment3">Revision/tolak Comment</label>
                                                    <textarea class="form-control" rows="3" name="revision_comment3" id="revision_comment3"></textarea>
                                                </div>
                                            </div>
                                            
                                            <!-- Additional fields for revisi -->
                                            <div id="revisi_fields" style="display: none;">
                                                <div class="form-group">
                                                    <label for="revision_comment2">Revision/tolak Comment</label>
                                                    <textarea class="form-control" rows="3" name="revision_comment2" id="revision_comment2"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                        @if($role === 'manager')
                                            
                                            @if ($datauser->kebutuhan != 'tidak_ada' && $datauser->validasi_availability === 'setuju')
                                                <div id="Keteranganteknis_fields" >
                                                    <div class="form-group">
                                                        <label for="keteranganteknis_comment">Keterangan Teknis</label>
                                                        <textarea class="form-control" rows="3" name="keteranganteknis_comment" id="keteranganteknis_comment"></textarea>
                                                    </div>
                                                </div>
                                            @endif
                                            @if ($datauser->jenis_pelayanan === 'barang' && $datauser->kebutuhan === 'tidak_ada' && $datauser->validasi_availability === 'setuju')
                                                <div id="Keteranganteknis_fields" >
                                                    <div class="form-group">
                                                        <label for="keteranganteknis_comment">Keterangan Teknis</label>
                                                        <textarea class="form-control" rows="3" name="keteranganteknis_comment" id="keteranganteknis_comment"></textarea>
                                                    </div>
                                                </div>
                                            @endif
                                            @endif
                                            <hr>
                                            <button type="submit" class="btn btn-primary btn-block">Update</button>
                                        </form>
                                    
                                    @elseif($role === 'staff' )
                                    <form action="{{ route('update.pengajuan', $datauser->id_permintaan_nfa) }}" enctype="multipart/form-data" method="post">
                                        @csrf
                                        <input type="hidden" id="id_fa">
                                        <div class="form-group">
                                            <label for="formdes_edit" class="control-label">Edit Pengajuan</label>
                                            <textarea class="form-control" rows="3" name="des_barang"  id="formdes_edit">{{ $datauser->deskripsi_pengajuan}}</textarea>
                                        </div>
                                        <hr>
                                        <button type="submit" class="btn btn-primary btn-block">Update</button>
                                    </form>
                                    @else
                                    @endif
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- ./card -->
                </div>
            </div>
            <!-- /.content -->
        </div>
    </div>
@endsection

@section('scripttambahan')




<script>
    function toggleAdditionalFields() {
        var availabilityStatus = $('#availability_status').val();
        var approvalStatus = $('#approval_status').val();
        var financeStatus = $('#finance_status').val();

        if (availabilityStatus === 'revisi' || availabilityStatus === 'ditolak') {
            $('#revisi_fields').show();
        } else {
            $('#revisi_fields').hide();
        }
        if (approvalStatus === 'revisi' || approvalStatus === 'ditolak') {
            $('#revisi_fields1').show();
        } else {
            $('#revisi_fields1').hide();
        }
        if (financeStatus === 'revisi' || financeStatus === 'ditolak') {
            $('#revisi_fields2').show();
        } else {
            $('#revisi_fields2').hide();
        }
    }

    function changeColor(element, status) {
        // Remove 'active' class from all buttons
        $('.btn-group-toggle label').removeClass('active');

        // Add 'active' class to the selected button
        $(element).addClass('active');
    }
</script>
<script>
    document.getElementById("butuhbarangtidak").style.display = 'none';
    document.getElementById("butuhsubcontidak").style.display = 'none';

    function displaySelectedValue(radioButton) {
        const selectedValue = radioButton.value;

        alert(selectedValue);
        if (selectedValue === 'Jasa') {
            document.getElementById("butuhbarangtidak").style.display = 'block';
        } else {
            document.getElementById("butuhbarangtidak").style.display = 'none';
            document.getElementById("butuhsubcontidak").style.display = 'none';
            document.getElementById("butuhbarangtidak").checked = false;
        }
    }

    function displaySelectedValue2(radioButton2) {
        const selectedValue2 = radioButton2.value;

        if (selectedValue2 === 'Tidak') {
            document.getElementById("butuhbarangtidak").style.display = 'block';
            document.getElementById("butuhsubcontidak").style.display = 'block';
        } else {
            document.getElementById("butuhsubcontidak").style.display = 'none';
            document.getElementById("butuhsubcontidak").checked = false;
        }
    }
</script>
<!-- InputMask -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- bs-custom-file-input -->
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // ... existing script ...

        $('[data-mask]').inputmask()
        $('#formdes_barang').summernote({
            height: 100, //set editable area's height,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['para', ['ul', 'ol']],
            ],
            placeholder: 'Spesifikasi, warna, bahan, nomor barang lainnya ...'
        });
        $('#formdes_edit').summernote({
            height: 100, //set editable area's height,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['para', ['ul', 'ol']],
            ],
            placeholder: 'Spesifikasi, warna, bahan, nomor barang lainnya ...'
        });
        bsCustomFileInput.init();
    });
</script>
@if (session('notification'))
    <script>
        var isi = @json(session('notification'));
        Swal.fire({
            icon: 'success',
            title: 'Hei...',
            text: isi,
            showConfirmButton: false,
            timer: 2500
        });
    </script>
@endif
@endsection
