@extends('layouts.layout_main')
@section('title', 'Permintaan Aktiva Tetap (SPA)')
@section('content')
<style>
    /* Basic Modal Styling */
.modal {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0,0,0,0.4);
}

.modal-dialog {
  margin: 15% auto;
  max-width: 600px;
  background-color: #fff;
  padding: 20px;
  border-radius: 5px;
}

.modal-header, .modal-footer {
  display: flex;
  justify-content: space-between;
}

.modal-header {
  border-bottom: 1px solid #ddd;
}

.modal-footer {
  border-top: 1px solid #ddd;
}

    </style>

<style>
    .modal-content {
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
  
    .btn-primary {
      background-color: #00c875;
      border-color: #00c875;
      font-weight: 200;
    }
  
    .btn-danger, .btn-success {
      font-weight: 600;
    }
  
    .btn-danger {
      background-color: #ff5c5c;
      border-color: #ff5c5c;
    }
  
    .btn-success {
      background-color: #00c875;
      border-color: #00c875;
    }
  </style>
  
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-12">
                            <h1 class="m-0">Permintaan Aktiva Tetap (SPA)</h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <div class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List Permintaan Perlu
                                
                                Ditindak Lanjuti
                            
                            
                            
                            </h3>
                            
                            <div class="card-tools">
                                @if(auth()->check() && auth()->user()->role_id == 1 || auth()->user()->role_id == 5 )
                                <a href="{{ route('managepermintaanfa.create') }}" class="btn btn-sm btn-info float-right" id="btn-create-aset">
                                    <i class="fas fa-plus"></i> Permintaan
                                </a>
                            @endif
                            

                            </div>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                           
                            <table id="tbl_permintaanfa" class="table table-sm table-bordered table-hover">
                                <thead>
                                 
                                    <tr>
                                        <th>#</th>
                                        <th>Unit Pemohon</th>
                                        <th>Unit Tujuan</th>
                                        <th>Status Permohonan</th>
                                        <th>Permohonan</th>
                                        <th>Tgl Permintaan</th>
                                        <th>Tindakan</th>
                                        <th><i class="far fa-folder-open"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        use Illuminate\Support\Facades\Crypt;
                                        ?>
                                    @foreach ($permintaanfa as $pfa)
                                        
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $pfa->unit_pemohon }}</td>
                                            <td>{{ ucfirst($pfa->unit_tujuan) }}</td>
                                            <td>{{ $pfa->status_permohonan }}</td>
                                            <td>{{ $pfa->deskripsi_permintaan }}</td>
                                            <td>{{ date('d M Y', strtotime($pfa->tgl_permintaan)) }}</td>
                                            <td>
                                            @if(auth()->user()->role_id == 14)
                                                    <!-- Use classes and data attributes for buttons -->
                                              @if($pfa->status != 'delayed')
                                             
                                                    @if($pfa->valid_fixaset == 'menunggu')
                                                    <button class="btn btn-primary approve-btn" data-id="{{ $pfa->id_permintaan_fa }}" data-status="{{ $pfa->status_permohonan }}">Approve</button>
                                                    <button class="btn btn-secondary delay-btn" data-id="{{ $pfa->id_permintaan_fa }}" data-status="{{ $pfa->status_permohonan }}" data-bs-toggle="modal" data-bs-target="#delayModal">Delay</button>
                                                    <button class="btn btn-danger reject-btn" data-id="{{ $pfa->id_permintaan_fa }}">Reject</button>
                                                    @elseif($pfa->valid_fixaset == 'tolak')
                                                    <button class="btn btn-danger" disabled>Di{{ $pfa->valid_fixaset}}</button>
                                                    @else
                                                    <button class="btn btn-primary" disabled>Di{{ $pfa->valid_fixaset}}i</button>
                                                    @endif
                                              @else
                                                    <button class="btn btn-secondary" disabled>{{ ucfirst($pfa->status)}}&nbsp;<i class="fas fa-clock"></i> </button>

                                              @endif
                                                                 
       
                                                    
                                            @elseif(auth()->user()->role_id == 15 || auth()->user()->role_id == 16)
                                                <!-- Buttons -->
                                             <!-- Buttons -->
                                      
                                         
                                             <!-- view button -->
                                             @if($pfa->pdf_bukti_1 != null)
                                             <button class="btn btn-secondary" disabled>{{ ucfirst($pfa->status)}}</button>
                                             {{-- <a href="{{ asset('storage/' . Crypt::decryptString($pfa->pdf_bukti_1)) }}" class="btn btn-primary" target="_blank">View PDF</a> --}}
                                             @else
                                             <button class="btn btn-secondary" disabled>{{ ucfirst($pfa->status)}}</button>
                                             @endif
                                              
                                             
                      <!--- STATUS TAMPILAN DAN TINDAKAN APPROVE SETLEMENT --->
                      @if ($pfa->valid_karyausaha === 'setuju' || $pfa->valid_ketuayayasan === 'setuju')
                      <button class="btn btn-primary" disabled>Disetujui</button>
                      @elseif ($pfa->valid_karyausaha === 'menunggu' && $pfa->valid_ketuayayasan === 'menunggu')
                     <button id="tindakan" class="btn btn-info" data-bs-toggle="modal" data-id="{{ $pfa->id_permintaan_fa }}" data-bs-target="#tindakanModal">Tindakan</button>
                     @else
                     <button class="btn btn-danger" disabled>Ditolak</button>

                     @endif

       @elseif(auth()->user()->role_id == 18)
                                            <!-- Tombol Approve -->
@if($pfa->status != 'delayed')

@if($pfa->valid_dirmanageraset == 'menunggu')                    

<!-- Tombol Approve -->
<button id="dirmansetuju{{ $pfa->id_permintaan_fa }}" class="btn btn-success" data-toggle="modal" data-id="{{ $pfa->id_permintaan_fa }}" data-target="#approveModal{{ $pfa->id_permintaan_fa }}">Confirmation</button>

<!-- Modal Approve -->
<div class="modal fade" id="approveModal{{ $pfa->id_permintaan_fa }}" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel{{ $pfa->id_permintaan_fa }}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="approveModalLabel{{ $pfa->id_permintaan_fa }}">Konfirmasi Approve</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Penyerahan Berita Acara Serah Terima Aset
        
        <!-- Peringatan jika userdetail tidak lengkap -->
        @if(is_null(optional($pfa->user->userdetail)->nama_lengkap) || optional($pfa->user->userdetail)->nama_lengkap === 'Default')
          <div class="alert alert-warning mt-3">
            <strong>Perhatian!</strong> Data user detail dari pengaju belum lengkap. Mohon untuk memperbarui data sebelum melanjutkan proses.
          </div>
        @endif
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>

        @if(is_null(optional($pfa->user->userdetail)->nama_lengkap) || optional($pfa->user->userdetail)->nama_lengkap === 'Default')
          <!-- Tombol Kirim Notifikasi -->
          <form action="{{ route('notifications.send') }}" method="POST" style="margin-left: 10px;">
            @csrf
            <input type="hidden" name="id_user_pengirim" value="{{ auth()->user()->id }}">
            <input type="hidden" name="id_user_penerima" value="{{ $pfa->user->id }}">
            <input type="hidden" name="id_pengajuan" value="{{ $pfa->id_permintaan_fa }}">
            <input type="hidden" name="jenis_notif" value="profil"> <!-- Input untuk jenis_notif -->
            <input type="hidden" name="keterangan_notif" value="Data Userdetails anda belum terupdate, Mohon untuk mengisi nama lengkap dll terlebih dahulu!">
            <button type="submit" class="btn btn-warning">
              Kirim Notifikasi
            </button>
          </form>
        @else
          <!-- Tombol Generate PDF -->
          <form action="{{ route('bast.tindakanbast', $pfa->id_permintaan_fa) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary" id="generatePdf{{ $pfa->id_permintaan_fa }}">Membuatkan BAST</button>
          </form>
        @endif
      </div>
    </div>
  </div>
</div>




@elseif($pfa->valid_dirmanageraset == 'setuju')

<a href="{{ route('bast.pdf', ['id' => $pfa->id_permintaan_fa]) }}" target="_blank" class="px-4 py-2 bg-blue-500 text-white rounded">Document BAST</a>
@else
<p class="inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-gray-600 rounded-full">
    Telah Ditolak
</p>
@endif
@else
<button class="btn btn-secondary" disabled>{{ ucfirst($pfa->status)}}&nbsp;<i class="fas fa-clock"></i> </button>

@endif



@elseif(auth()->user()->role_id == 17)
@if ($pfa->valid_dirkeuangan == 'setuju')
<button class="btn btn-primary" disabled>Disetujui</button>
@elseif ($pfa->valid_dirkeuangan == 'ditolak')
<button class="btn btn-danger" disabled>Ditolak</button>
@elseif ($pfa->valid_dirkeuangan == 'menunggu')
<!-- Tombol Approve dan Reject -->
<button class="btn btn-success" data-toggle="modal" data-target="#approveModal{{ $pfa->id_permintaan_fa }}">Confirm</button>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal{{ $pfa->id_permintaan_fa }}" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel{{ $pfa->id_permintaan_fa }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approveModalLabel{{ $pfa->id_permintaan_fa }}">Approve Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('bast.tindakan') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $pfa->id_permintaan_fa }}">
                    <input type="hidden" name="status" value="setuju">
                    <div class="form-group">
                        <label for="harga_perolehan{{ $pfa->id_permintaan_fa }}">Harga Perolehan</label>
                        <input type="number" class="form-control" id="harga_perolehan{{ $pfa->id_permintaan_fa }}" name="harga_perolehan" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Approve</button>
                </form>            
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal{{ $pfa->id_permintaan_fa }}" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel{{ $pfa->id_permintaan_fa }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel{{ $pfa->id_permintaan_fa }}">Reject Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('bast.tindakan') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $pfa->id_permintaan_fa }}">
                    <input type="hidden" name="status" value="tolak">
                    <div class="form-group">
                        <label for="alasan_reject{{ $pfa->id_permintaan_fa }}">Alasan</label>
                        <textarea class="form-control" id="alasan_reject{{ $pfa->id_permintaan_fa }}" name="alasan_reject" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger">Reject</button>
                </form>
            </div>
        </div>
    </div>
</div>
@else
<button class="btn btn-danger" disabled>Ditolak</button>
@endif


  @elseif(auth()->user()->role_id == 19)
  @if ($pfa->valid_manageraset != 'menunggu')
  <!-- Tambahkan status atau elemen lainnya di sini -->
  <button class="btn btn-primary" disabled>Telah Disimpan</button>
@elseif ($pfa->valid_manageraset == 'menunggu')
  <!-- Tombol Approve -->
  <button class="btn btn-success" data-toggle="modal" data-target="#approveModal{{ $pfa->id_permintaan_fa }}">Simpan</button>
  
  <!-- Approve Modal -->
  <div class="modal fade" id="approveModal{{ $pfa->id_permintaan_fa }}" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel{{ $pfa->id_permintaan_fa }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="approveModalLabel{{ $pfa->id_permintaan_fa }}">Approve Request</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="catatForm" action="{{ route('bast.catat') }}" method="POST" enctype="multipart/form-data">
            @csrf <!-- Include CSRF token for security -->

            <!-- Confirmation Message -->
            <p class="mb-4 text-center">
                Apakah Anda yakin ingin mencatat permintaan ini?
            </p>

            <!-- Hidden input to store the request ID -->
            <input type="hidden" value="{{ $pfa->id_permintaan_fa }}" id="idPermintaanFA" name="idPermintaanFA">

            <button type="submit" class="btn btn-primary">Simpan</button>
          </form>            
        </div>
      </div>
    </div>
  </div>

  @else
  <button class="btn btn-danger" disabled>Ditolak</button>
  @endif
  
  

                                            @else
                                                    @switch($pfa->status)
                                                        @case('menunggu')
                                                            <p>Status: <span class="badge text-dark bg-grey">Menunggu..</span></p>
                                                        @break
                                                
                                                        @case('disetujui')
                                                            <p>Status: <span class="badge bg-green">Selesai</span></p>
                                                        @break
                                                
                                                        @case('ditolak')
                                                            <p>Status: <span class="badge bg-red">Ditolak</span></p>
                                                        @break
                                                        @case('delayed')
                                                        <p>Status: <span class="badge bg-dark">Delayed</span></p>
                                                        @break
                                                        @default
                                                            <p>Status: Tidak diketahui</p>
                                                    @endswitch
                                                @endif
                                            </td>
                                            <td>
                                              <a href="{{ route('managepermintaanfa.detail', $pfa->id_permintaan_fa) }}" id="btn-detail-lokasi"
                                                 class="btn btn-sm btn-light" title="Detail Permintaan">
                                                  <i class="far fa-folder-open">&nbsp;View</i>
                                              </a>
                                            {{-- @if($pfa->status == 'menunggu')
                                              <a href="" id="btn-detail-lokasi"
                                                class="btn btn-sm btn-light" title="Detail Permintaan">
                                                 <i class="fas fa-edit">&nbsp;Edit</i>
                                             </a>
                                             @endif --}}
                                          </td>
                                          
                                        </tr>

<!-- Modal -->
<div class="modal fade" id="tindakanModal" tabindex="-1" aria-labelledby="tindakanModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog">
      <div class="modal-content" style="border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
          <div class="modal-header" style="border-bottom: none;">
              <h5 class="modal-title" id="tindakanModalLabel" style="font-weight: 600; color: #333;">Pilih Tindakan</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closeButton"></button>
          </div>
          <div class="modal-body" style="padding: 20px;">
              <!-- Bagian pertama: Pilihan tindakan -->
              <div id="initialButtons">
                  <button type="button" class="btn btn-success" id="approveBtn" style="width: 100%; margin-bottom: 10px; background-color: #00c875; border-color: #00c875; font-weight: 600;">Approve</button>

                  <button type="button" class="btn btn-danger" id="rejectBtn" style="width: 100%; background-color: #ff5c5c; border-color: #ff5c5c; font-weight: 600;">Reject</button>
              </div>
              
              <!-- Bagian kedua: Input dan konfirmasi -->
              <div id="confirmationSection" style="display: none;">
                  <form id="confirmationForm" action="{{ route('managepermintaanfa.tindakan') }}" method="POST">
                      @csrf
                      <input type="hidden" id="permintaanId" value="{{ $pfa->id_permintaan_fa}}" name="id"> <!-- Hidden input untuk ID -->
                      <div class="mb-3" id="alasanSection" style="display: none;">
                          <label for="alasanInput" class="form-label" style="font-weight: 500;">Alasan</label>
                          <input type="text" class="form-control" id="alasanInput" name="alasan">
                      </div>
                      <div class="mb-3">
                          <label for="tindakLanjutInput" class="form-label" style="font-weight: 500;">Tindak Lanjut</label>
                          <input type="text" class="form-control" id="tindakLanjutInput" name="tindakLanjut" required>
                      </div>
                      
                      <input type="hidden" id="tindakanType" name="tindakanType">
                      <button type="submit" class="btn btn-primary" id="confirmBtn" style="width: 100%; font-weight: 600;">Konfirmasi</button>
                  </form>
              </div>
          </div>
      </div>
  </div>
</div>





                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Unit Pemohon</th>
                                        <th>Unit Tujuan</th>
                                        <th>Status Permohonan</th>
                                        <th>Permohonan</th>
                                        <th>Tgl Permintaan</th>
                                        <th>Tindakan</th>
                                        <th>
                                          <i class="far fa-folder-open"></i>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div><!-- /.card-body -->
                    </div>
                    <!-- ./card -->
                </div>
            </div>
            <!-- /.content -->
            @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        </div>
    </div>

   






<!-- Modal HTML -->
<div class="modal fade" id="delayModal" tabindex="-1" aria-labelledby="delayModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="delayModalLabel">Select Delay Date</h5>
        <small class="text-muted">*Delay will automatically approve the request.</small>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="delayForm" action="{{ route('managepermintaanfa.approve') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="id" id="delayId">
          <input type="hidden" name="status" value="delayed">
          <div id="unitSourceContainerDelay" class="d-none">
            <label for="unitSourceDelay">Unit Asal</label>
            <input type="text" id="unitSourceDelay" name="unitSourceDelay" class="form-control">
          </div>
          <div id="priceEstimateContainerDelay" class="d-none">
            <label for="priceEstimateDelay">Perkiraan Harga</label>
            <input type="number" id="priceEstimateDelay" name="priceEstimateDelay" class="form-control" step="0.01" min="0" required>
          </div>
          <div class="form-group">
            <label>Status Kondisi Barang</label>
            <select id="status_barang" class="form-control" name="status_barang" style="width: 100%;" required>
              <option value="baik(100%)">baik(100%)</option>
              <option value="cukup(50%)">cukup(50%)</option>
              <option value="rusak">rusak</option>
            </select>
          </div>
          <div class="form-group mt-3">
            <label>Pilih Jenis File</label>
            <div class="btn-group" role="group" aria-label="File Upload Type">
              <button type="button" class="btn btn-primary active" id="uploadImageBtn2">Upload Gambar</button>
              <button type="button" class="btn btn-secondary" id="uploadPDFBtn2">Upload PDF</button>
            </div>
          </div>
          
          <div id="imageUploadContainer" class="form-group mt-3">
            <label for="image_file">Upload File</label>
            <input type="file" class="form-control-file" id="image_file2" name="file_image2" accept="image/*">
            <small class="text-muted">(*File gambar kurang dari 2 MB)</small>
            <div id="image-upload-feedback" class="mt-2"></div>
          </div>
          
          <div id="pdfUploadContainer" class="form-group mt-3 d-none">
            <label for="pdf_file">Upload File</label>
            <input type="file" class="form-control-file" id="pdf_file2" name="file_pdf2" accept="application/pdf">
            <small class="text-muted">(*Opsional upload pdf, kurang dari 2 MB)</small>
            <div id="file-upload-feedback" class="mt-2"></div>
          </div>

          <div class="form-group">
            <label for="alasanDelay">Alasan Delay</label>
            <input type="text" name="alasan_delay" class="form-control" required>
            <label for="delayDate">Select Date</label>
            <input type="text" id="delayDate" name="delay_date" class="form-control" required>
            <small class="text-muted">Date must not be today.</small>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>








    <!-- Modal HTML -->
<div class="modal fade" id="approvalModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabel">Approval Form</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Form Approve -->
          <form id="approveForm" action="{{ route('managepermintaanfa.approve') }}" method="post" class="d-none" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="approveId">
            <input type="hidden" name="status" value="setuju">
            <div id="unitSourceContainerApprove" class="d-none">
              <label for="unitSourceApprove">Unit Asal</label>
              <input type="text" id="unitSourceApprove" name="unitSource" class="form-control">
            </div>

            <div id="priceEstimateContainerApprove" class="d-none">
              <label for="priceEstimateApprove">Perkiraan Harga</label>
              <input type="number" id="priceEstimateApprove" name="priceEstimate" class="form-control" step="0.01" min="0" required>
          </div>
          
            <div class="form-group">
              <label>Status Kondisi Barang</label>
              <select id="status_barang" class="form-control" name="status_barang" style="width: 100%;" required>
                  <option value="baik(100%)">baik(100%)</option>
                  <option value="cukup(50%)">cukup(50%)</option>
                  <option value="rusak">rusak</option>
              </select>
          </div>
          <div class="form-group mt-3">
            <label>Pilih Jenis File</label>
            <div class="btn-group" role="group" aria-label="File Upload Type">
              <button type="button" class="btn btn-primary active" id="uploadImageBtn">Upload Gambar</button>
              <button type="button" class="btn btn-secondary" id="uploadPDFBtn">Upload PDF</button>
            </div>
          </div>
          
          <div id="imageUploadContainer2" class="form-group mt-3">
            <label for="image_file2">Upload File</label>
            <input type="file" class="form-control-file" id="image_file2" name="file_image2" accept="image/*">
            <small class="text-muted">(*File gambar kurang dari 2 MB)</small>
            <div id="image-upload-feedback2" class="mt-2"></div>
          </div>
          
          <div id="pdfUploadContainer2" class="form-group mt-3 d-none">
            <label for="pdf_file2">Upload File</label>
            <input type="file" class="form-control-file" id="pdf_file2" name="file_pdf2" accept="application/pdf">
            <small class="text-muted">(*Opsional upload pdf, kurang dari 2 MB)</small>
            <div id="file-upload-feedback2" class="mt-2"></div>
          </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Approve</button>
            </div>
          </form>
  
          <!-- Form Reject -->
          <form id="rejectForm" action="{{ route('managepermintaanfa.reject') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="rejectId">
            <input type="hidden" name="status" value="ditolak">
            <div class="form-group">
                <label for="catatan">Catatan</label>
                <input type="text" id="catatan" name="catatan" class="form-control">
        
                <label for="file_pdf">Upload PDF (Opsional)</label>
                <input type="file" class="form-control-file" id="file_pdf" name="file_pdf" accept="application/pdf">
                <small class="text-muted">(*Opsional upload pdf)</small>
                <div id="file-upload-feedback" class="mt-2"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">Reject</button>
            </div>
        </form>
        
        </div>
      </div>
    </div>
  </div>

  
   
@endsection

@section('scripttambahan')
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

document.getElementById('uploadImageBtn2').addEventListener('click', function() {
  document.getElementById('imageUploadContainer').classList.remove('d-none');
  document.getElementById('pdfUploadContainer').classList.add('d-none');
  
  this.classList.add('active');
  document.getElementById('uploadPDFBtn2').classList.remove('active');
});

document.getElementById('uploadPDFBtn2').addEventListener('click', function() {
  document.getElementById('imageUploadContainer').classList.add('d-none');
  document.getElementById('pdfUploadContainer').classList.remove('d-none');
  
  this.classList.add('active');
  document.getElementById('uploadImageBtn2').classList.remove('active');
});

  document.getElementById('uploadImageBtn').addEventListener('click', function() {
  document.getElementById('imageUploadContainer2').classList.remove('d-none');
  document.getElementById('pdfUploadContainer2').classList.add('d-none');
  
  this.classList.add('active');
  document.getElementById('uploadPDFBtn').classList.remove('active');
});

document.getElementById('uploadPDFBtn').addEventListener('click', function() {
  document.getElementById('imageUploadContainer2').classList.add('d-none');
  document.getElementById('pdfUploadContainer2').classList.remove('d-none');
  
  this.classList.add('active');
  document.getElementById('uploadImageBtn').classList.remove('active');
});

</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Flatpickr on the delay date input
    flatpickr("#delayDate", {
        minDate: new Date().fp_incr(1), // Prevents selection of today's date
        dateFormat: "Y-m-d",
        allowInput: true
    });


      // When the Delay button is clicked, set the ID in the form
      document.querySelectorAll('.delay-btn').forEach(button => {
          button.addEventListener('click', function() {
              const id = this.getAttribute('data-id');
              document.getElementById('delayId').value = id;
          });
      });
  });
</script>



<script>
var generatePdfButton = document.getElementById('generatePdf');

if (generatePdfButton) { // Mengecek apakah elemen generatePdf ada
    generatePdfButton.addEventListener('click', function() {
        var idPermintaan = document.getElementById('dirmansetuju').value;
        // Lakukan tindakan untuk generate PDF
        alert('Membuat pengesahan berita acara untuk permintaan ID: ' + idPermintaan);
        // Close modal
        $('#approveModal').modal('hide');
    });
}


var confirmRejectButton = document.getElementById('confirmReject');

if (confirmRejectButton) { // Mengecek apakah elemen confirmReject ada
    confirmRejectButton.addEventListener('click', function() {
        var alasan = document.getElementById('rejectReason').value;
        if (alasan.trim() === '') {
            alert('Harap masukkan alasan penolakan.');
            return;
        }
        var idPermintaan = $('#dirmantolak').data('id');
        // Lakukan tindakan untuk reject dengan alasan
        alert('Permintaan dengan ID: ' + idPermintaan + ' ditolak dengan alasan: ' + alasan);
        // Close modal
        $('#rejectModal').modal('hide');
    });
}

    </script>
<script>
  var tindakanButton = document.getElementById('tindakan');

if (tindakanButton) { // Mengecek apakah elemen tindakan ada
    tindakanButton.addEventListener('click', function() {
        var permintaanId = this.getAttribute('data-id'); // Ambil ID dari atribut data-id
        document.getElementById('permintaanId').value = permintaanId; // Set ID ke hidden input
    });
}

    
    document.getElementById('rejectBtn').addEventListener('click', function() {
        showConfirmationSection('Ditolak');
        disableCloseButton();
        document.getElementById('alasanSection').style.display = 'block'; // Tampilkan input alasan
    });
    
    document.getElementById('approveBtn').addEventListener('click', function() {
        showConfirmationSection('Setuju');
        disableCloseButton();
        document.getElementById('alasanSection').style.display = 'none'; // Sembunyikan input alasan
    });
    
    function showConfirmationSection(action) {
        // Sembunyikan tombol awal dan tampilkan inputan serta tombol konfirmasi
        document.getElementById('initialButtons').style.display = 'none';
        document.getElementById('confirmationSection').style.display = 'block';
        
        // Set hidden input untuk jenis tindakan (approve/reject)
        document.getElementById('tindakanType').value = action;
        
        // Ganti teks tombol konfirmasi sesuai dengan aksi yang dipilih
        const confirmBtn = document.getElementById('confirmBtn');
        confirmBtn.innerText = action + ' Konfirmasi';
    }
    
    function disableCloseButton() {
        // Disable the close button
        document.getElementById('closeButton').disabled = true;
    }
    
    </script>
<script>
 document.addEventListener('DOMContentLoaded', function() {
  const approvalButtons = document.querySelectorAll('.approve-btn, .reject-btn, .delay-btn');
  const approvalForm = document.getElementById('approveForm');
  const rejectForm = document.getElementById('rejectForm');
  const delayForm = document.getElementById('delayForm');

  approvalButtons.forEach(button => {
    button.addEventListener('click', function() {
      const statusPermohonan = button.getAttribute('data-status');
      const id = button.getAttribute('data-id');

      if (button.classList.contains('approve-btn')) {
        approvalForm.action = '{{ route('managepermintaanfa.approve') }}';
        document.getElementById('approveId').value = id;

        let unitSourceContainer = document.getElementById('unitSourceContainerApprove');
        let priceEstimateContainer = document.getElementById('priceEstimateContainerApprove');

        // Configure input fields based on statusPermohonan
        if (statusPermohonan === 'Pemindahan') {
          unitSourceContainer.classList.remove('d-none');
          priceEstimateContainer.classList.add('d-none');

          const unitSourceInput = document.getElementById('unitSourceApprove');
          unitSourceInput.setAttribute('placeholder', 'Enter the original asset unit');
          unitSourceInput.setAttribute('aria-label', 'Unit Asal');
        } else {
          unitSourceContainer.classList.add('d-none');
          priceEstimateContainer.classList.remove('d-none');

          const priceEstimateInput = document.getElementById('priceEstimateApprove');
          priceEstimateInput.setAttribute('placeholder', 'Enter the estimated price');
          priceEstimateInput.setAttribute('aria-label', 'Perkiraan Harga');
        }

        approvalForm.classList.remove('d-none');
        rejectForm.classList.add('d-none');
      } else if (button.classList.contains('reject-btn')) {
        rejectForm.action = '{{ route('managepermintaanfa.reject') }}';
        document.getElementById('rejectId').value = id;

        approvalForm.classList.add('d-none');
        rejectForm.classList.remove('d-none');
      } else if (button.classList.contains('delay-btn')){
        delayForm.action = '{{ route('managepermintaanfa.approve') }}';

        let unitSourceContainer2 = document.getElementById('unitSourceContainerDelay');
        let priceEstimateContainer2 = document.getElementById('priceEstimateContainerDelay');

        // Configure input fields based on statusPermohonan
        if (statusPermohonan === 'Pemindahan') {
          unitSourceContainer2.classList.remove('d-none');
          priceEstimateContainer2.classList.add('d-none');

          const unitSourceInput2 = document.getElementById('unitSourceDelay');
          unitSourceInput2.setAttribute('placeholder', 'Enter the original asset unit');
          unitSourceInput2.setAttribute('aria-label', 'Unit Asal');
        } else {
          unitSourceContainer2.classList.add('d-none');
          priceEstimateContainer2.classList.remove('d-none');

          const priceEstimateInput2 = document.getElementById('priceEstimateDelay');
          priceEstimateInput2.setAttribute('placeholder', 'Enter the estimated price');
          priceEstimateInput2.setAttribute('aria-label', 'Perkiraan Harga');
        }
        document.getElementById('approvalModal').add('d-none');
        approvalForm.classList.add('d-none');
        rejectForm.classList.add('d-none');

      }

      // Show the modal
      new bootstrap.Modal(document.getElementById('approvalModal')).show();
    });
  });
});

    </script>
<script>
    $(document).ready(function(){
    $('#mencatat').on('click', function() {
        var id = $(this).data('id');
        
        // Show the modal (you can customize the modal as per your need)
        $('#catatModal').modal('show');

        // Example: perform an AJAX request to the backend when needed
     
    });
});

    </script>
<!-- Tampilkan pesan kesalahan jika ada -->








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
<script>
  document.addEventListener('DOMContentLoaded', function () {
      const maxSize = 2 * 1024 * 1024; // 2 MB dalam bytes

      // Fungsi untuk menampilkan feedback
      function showFileInfo(inputElement, feedbackElement, maxSize) {
          const file = inputElement.files[0];
          feedbackElement.textContent = ''; // Reset feedback

          if (file) {
              const fileSize = (file.size / 1024 / 1024).toFixed(2); // Menghitung ukuran file dalam MB dengan dua desimal
              const fileName = file.name; // Mendapatkan nama file

              // Pesan untuk file yang valid atau tidak
              if (file.size > maxSize) {
                  feedbackElement.innerHTML = `File <strong>${fileName}</strong> terlalu besar (${fileSize} MB). Maksimum 2 MB.`;
                  inputElement.value = ''; // Reset input
              } else {
                  feedbackElement.innerHTML = `File <strong>${fileName}</strong> valid (${fileSize} MB).`;
              }
          }
      }

      // Validasi untuk file image pertama
      const imageFileInput = document.getElementById('image_file');
      const imageFeedback = document.getElementById('image-upload-feedback');

      imageFileInput.addEventListener('change', function () {
          showFileInfo(imageFileInput, imageFeedback, maxSize);
      });

      // Validasi untuk file PDF pertama
      const pdfFileInput = document.getElementById('pdf_file');
      const pdfFeedback = document.getElementById('file-upload-feedback');

      pdfFileInput.addEventListener('change', function () {
          showFileInfo(pdfFileInput, pdfFeedback, maxSize);
      });

      // Validasi untuk file image kedua
      const imageFileInput2 = document.getElementById('image_file2');
      const imageFeedback2 = document.getElementById('image-upload-feedback2');

      imageFileInput2.addEventListener('change', function () {
          showFileInfo(imageFileInput2, imageFeedback2, maxSize);
      });

      // Validasi untuk file PDF kedua
      const pdfFileInput2 = document.getElementById('pdf_file2');
      const pdfFeedback2 = document.getElementById('file-upload-feedback2');

      pdfFileInput2.addEventListener('change', function () {
          showFileInfo(pdfFileInput2, pdfFeedback2, maxSize);
      });
  });
</script>


    @if (session('notification'))
    @once
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
        @endonce
    @endif

@endsection
