@extends('layouts.layout_main')
@section('title', 'Permintaan Aktiva Tetap (SPA)')
@section('content')
<style>
    .card-text strong {
        display: block;
        background-color: #f8f9fa; /* Light gray background for a formal look */
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Subtle shadow for a professional touch */
        text-align: left;
    }

    .card-text {
        text-align: center; /* Ensure the overall text is centered */
    }
.card {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%; /* Membuat card fleksibel dalam mengisi ruang vertikal */
}

.card-body {
    flex-grow: 1; /* Membuat card-body fleksibel mengisi ruang yang tersedia */
}

.card-footer {
    margin-top: auto;
     /* Menempatkan elemen di bagian bawah */
}
.dynamic-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.dynamic-card:hover {
    transform: scale(1.02);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.card-footer {
    border-top: 1px solid #eaeaea;
    padding-top: 0.75rem;
}

.card-body {
    padding: 1.25rem;
}

.button-group button {
    border-radius: 25px;
    padding: 10px;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.button-group button:hover {
    transform: scale(1.05);
}

.modal-dialog {
    max-width: 500px;
}
.card.custom-card {
    border-radius: 10px;
    border: 1px solid #ddd;
    overflow: hidden;
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #ddd;
}

.card-title {
    margin: 0;
    font-size: 1.1rem;
}

.card-body {
    padding: 1rem;
}

.card-footer {
    background-color: #f8f9fa;
    border-top: 1px solid #ddd;
    padding: 0.75rem;
}

.button-group {
    display: flex;
    gap: 10px;
}

.button-group form button,
.button-group button {
    width: 100%;
    border-radius: 25px;
    padding: 10px;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.button-group form button:hover,
.button-group button:hover {
    transform: scale(1.05);
}

.modal-content {
    border-radius: 10px;
}

.modal-header {
    border-bottom: 1px solid #ddd;
}

.modal-footer {
    border-top: 1px solid #ddd;
}
@media (max-width: 768px) {
    .card-body {
        padding: 0.5rem;
    }
    
    .button-group {
        flex-direction: column;
    }
    
    .button-group form button,
    .button-group button {
        width: 100%;
        margin-bottom: 10px;
    }
}


</style>
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-6">
                            <h1 class="m-0">Permintaan Non Fixed Assets (NFA)</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Welcome {{ strtoupper(Auth::user()->username) }} (Approve Permintaan NFA)</h3>
                            <span class="badge bg-info" style="margin-left: 45%; font-size: 1rem;">Total Permintaan: {{ $count }}</span>
                        </div>
                        <div class="card-body">
                            <div class="row">
                            
                                @forelse($data as $permintaan)
                                <div class="col-md-4 mb-4">
                                    <div class="card border-light shadow-sm dynamic-card" style="border-radius: 15px;">
                                        <div class="card-header text-center bg-primary text-white" style="border-radius: 15px 15px 0 0;">
                                            Permintaan #{{ $permintaan->id_permintaan_nfa }}
                                        </div>
                                        <div class="card-body text-primary text-center">
                                            <h5 style="width: 100%;" class="card-title text-center">
                                                <span class="badge bg-secondary">{{ strtoupper($permintaan->jenis_pelayanan) }}</span>
                                                @if($permintaan->jenis_pelayanan === 'jasa')
                                                    {{ strtoupper($permintaan->kebutuhan) }}
                                                @endif
                                            </h5>
                                            <p class="card-text">
                                                @if($permintaan->jenis_pelayanan === 'jasa')
                                                    <strong>Deskripsi Jasa : <br> {{ $permintaan->deskripsi_pengajuan }}</strong>  
                                                    <strong>Vendor : {{ $permintaan->vendor }}...</strong>
                                                @else
                                                    <strong>Deskripsi Barang : <br> {{ $permintaan->deskripsi_pengajuan }}</strong>
                                                @endif
                                            </p>
                                            <p class="card-text">
                                                <strong>Purchase Order : {{ $permintaan->purchase_order }}...</strong>
                                            </p>
                                            <div class="card-footer">
                                                <a href="#" class="btn btn-link">View Details <i class="fas fa-eye"></i></a>
                                            </div>
                                            <div class="button-group">
                                                @if(auth()->user()->role_id != 12)
                                                    @switch(auth()->user()->role_id)
                                                        @case(11)
                                                            <form action="" method="POST" class="flex-fill">
                                                                @csrf
                                                                <button type="submit" style="width: 100%;" class="btn btn-info">Ajukan Vendor</button>
                                                            </form>
                                                            @break
                                                        @default
                                                            <div class="d-flex">
                                                                <form action="{{ route('permintaan.action', ['aksi' => 'approve', 'id' => $permintaan->id_permintaan_nfa]) }}" method="POST" class="flex-fill me-1">
                                                                    @csrf
                                                                    <button type="submit" style="width: 100%;" class="btn btn-success flex-fill">Approve</button>
                                                                </form>
                                                                <button type="button" class="btn btn-danger flex-fill" data-toggle="modal" data-target="#rejectNoteModal" data-id="{{ $permintaan->id_permintaan_nfa }}">
                                                                    Reject
                                                                </button>
                                                            </div>
                                                    @endswitch
                                                @else
                                                    @switch($permintaan->validasi_procecurement)
                                                        @case('setuju')
                                                            <button type="submit" class="btn btn-success">Klik Selesai</button>
                                                            @break
                                                        @default
                                                            @if($permintaan->validasi_corp == 'setuju' && $permintaan->kebutuhan == 'non_subcon')
                                                                <form action="{{ route('permintaan.action', ['aksi' => 'selesai', 'id' => $permintaan->id_permintaan_nfa]) }}" method="POST" class="flex-fill me-1">
                                                                    @csrf
                                                                    <button type="submit" style="width: 100%;" class="btn btn-success">Klik Jika Selesai</button>
                                                                </form>
                                                            @elseif($permintaan->purchase_order != 'belum_ada' && $permintaan->jenis_pelayanan == 'barang')
                                                                <button type="submit" style="width: 100%;" class="btn btn-success">Approve</button>
                                                            @else
                                                                <button type="submit" disabled style="width: 100%;" class="btn btn-secondary" data-toggle="modal"  data-id="{{ $permintaan->id_permintaan_nfa }}">Menunggu...</button>
                                                            @endif
                                                    @endswitch
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                            <!-- Modal for rejection note -->
                            <div class="modal fade" id="rejectNoteModal" tabindex="-1" role="dialog" aria-labelledby="rejectNoteModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="rejectNoteModalLabel">Reject Request</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="rejectForm" action="{{ route('permintaan.action', ['aksi' => 'reject', 'id' => $permintaan->id_permintaan_nfa]) }}" method="POST">
                                                @csrf
                                                <input type="hidden" id="requestId" name="requestId">
                                                <div class="form-group">
                                                    <label for="rejectReason">Reason for Rejection:</label>
                                                    <textarea id="rejectReason" name="reject_reason" class="form-control" required></textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger">Submit Rejection</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            @empty
                            <div style="width: 100%; display: flex; justify-content: center;">
                                <div class="col-md-4 mb-4">
                                    <div class="card border-light shadow-sm d-flex align-items-center justify-content-center" style="border-radius: 15px; height: 100px;">
                                        <p class="text-center mb-0">Data Belum Tersedia</p>
                                    </div>
                                </div>
                            </div>
                            @endforelse
                            
                            

         



      
        @if (session()->has('notification'))
            <script>
                var notification = @json(session('notification'));

                Swal.fire({
                    icon: notification.success ? 'success' : 'error',
                    title: notification.message,
                    showConfirmButton: false,
                    timer: 2500
                });
            </script>
        @endif
    </div>
@endsection

@section('scripttambahan')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Attach event listener to the Reject button
        $('#rejectNoteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var requestId = button.data('id'); // Extract info from data-* attributes
            var modal = $(this);
            // You can update the modal with the requestId or any other info here if needed
            modal.find('#rejectReason').text('You are rejecting request ID: ' + requestId); // Example of updating the text
        });
    });
</script>




    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var bellIcon = document.getElementById('bell');

            bellIcon.addEventListener('click', function (event) {
                var notificationMessage = 'You have a new notification!';
                var notificationDiv = document.createElement('div');
                notificationDiv.className = 'notification-popup';
                notificationDiv.textContent = notificationMessage;

                var rect = event.target.getBoundingClientRect();
                notificationDiv.style.position = 'fixed';
                notificationDiv.style.top = rect.bottom + 'px';
                notificationDiv.style.left = rect.left + 'px';

                document.body.appendChild(notificationDiv);

                setTimeout(function () {
                    document.body.removeChild(notificationDiv);
                }, 3000);
            });
        });
    </script>
@endsection
