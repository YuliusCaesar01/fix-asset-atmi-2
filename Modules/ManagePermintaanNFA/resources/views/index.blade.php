@extends('layouts.layout_main')
@section('title', 'Permintaan Aktiva Tetap (SPA)')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-6">
                            <h1 class="m-0">Permintaan Non Fixed Assets(NFA)</h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <div class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Welcome {{ strtoupper(Auth::user()->username) }} || List Permintaan</h3>
                            <div class="card-tools">
                                
                                
                                 @if(auth()->user()->role_id == 12)
                                 <a href="{{ route('managepermintaannfa.create') }}" class="btn btn-sm btn-info float-right"
                                    id="btn-create-aset">
                                    <i class="fas fa-plus"></i> Permintaan
                                </a>
                                    @elseif(auth()->user()->role_id == 1)
                                <a href="{{ route('managepermintaannfa.create') }}" class="btn btn-sm btn-info float-right"
                                    id="btn-create-aset">
                                    <i class="fas fa-plus"></i> Permintaan
                                </a>
                                    @else

                                @endif
                              
                               
                            </div>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            @if (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <div class="table-responsive table-responsive-sm">
                                <table id="tbl_permintaannfa" class="table table-sm table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="max-width: 100px;">No</th>
                                            <th style="max-width: 150px;">Permintaan</th>
                                            <th style="max-width: 100px; ">Keterangan</th>
                                            <th style="max-width: 100px;">Kebutuhan</th>
                                            <th style="max-width: 150px;">Purchase_Order</th>
                                            <th style="max-width: 100px;">Note</th>
                                            <th style="max-width: 250px;">Action</th>
                                            <th style="max-width: 250px;">Details</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $index => $permintaan)
                                            <tr id="index_{{ $index }}">
                                                <td class="text-center">{{ $permintaan->id_permintaan_nfa }}</td> <!-- Misalnya ID permintaan -->
                                                <td>{{ $permintaan->deskripsi_pengajuan }}</td>
                                                <td style="text-align: center; font-size: 18px;"><span class="badge bg-grey">{{ strtoupper($permintaan->jenis_pelayanan) }}</span></td>
                                                <td>{{ $permintaan->kebutuhan }}</td>
                                                <td>{{ $permintaan->purchase_order }}</td>

                                                <td><span class="badge bg-yellow">{{ $permintaan->catatan }}</span></td> 
                                                <td style="max-width: 300px;"> 
                                                    <!-- Contoh tombol aksi -->
                                                        @if(auth()->id() == 1)
                                                            <a href="" class="btn btn-warning btn-sm">Edit</a>
                                                            <form action="{{ route('managepermintaannfa.destroy', $permintaan->id_permintaan_nfa) }}" method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                                            </form>
                                                            
                                                        @else  
                                            @if(auth()->user()->role_id == 5)
                                                        @switch($permintaan->status)
                                                            @case('menunggu')
                                                               <p>Status: <span class="badge bg-grey">Menunggu..</span></p>
                                                            @break

                                                            @case('selesai')
                                                                <p>Status: <span class="badge bg-green">Selesai</span></p>
                                                            @break

                                                            @case('ditolak')
                                                                 <p>Status: <span class="badge bg-red">Ditolak</span></p>
                                                            @break

                                                            @default
                                                                 <p>Status: Tidak diketahui</p>
                                                            @endswitch
                                                        @else
                                             @endif
                                                    @endif
                                                    
                                                </td> 
                                                <td>  <strong class="text-center">View details <i class="fas fa-eye"></i></strong> </td>
                                            </tr>

                                        @endforeach
                                        
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th style="max-width: 100px;">No</th>
                                            <th style="max-width: 150px;">Permintaan</th>
                                            <th style="max-width: 100px;">Keterangan</th>
                                            <th style="max-width: 100px;">Kebutuhan</th>
                                            <th style="max-width: 100px;">Purchase_Order</th>
                                            <th style="max-width: 100px;">Note</th>                      
                                            <th style="max-width: 250px;">Action</th>
                                            <th style="max-width: 250px;">Details</th>

                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            
                        </div><!-- /.card-body -->
                    </div>
                    <!-- ./card -->
                </div>
            </div>
            <!-- /.content -->
        </div>
    </div>
   


   
    <script>
        @if(session('notification'))
            Swal.fire({
                icon: '{{ session('notification.success') ? 'success' : 'error' }}',
                title: '{{ session('notification.success') ? 'Sukses!' : 'Gagal!' }}',
                text: '{{ session('notification.message') }}', // Mengambil pesan dari session
                showConfirmButton: false,
                timer: 2500
            });
        @endif
    </script>
    

@endsection




@section('scripttambahan')

{{-- @if($role = 'staff')
<script>
    var editButton = document.querySelector('.edit-btn');

// Add a click event listener to the edit button
editButton.addEventListener('click', function () {
    // Disable the button to prevent further clicks
    editButton.disabled = true;

    // Optionally, you can change the button text or style to indicate it's disabled
    editButton.innerHTML = '<i class="fas fa-edit"></i> Editing...';
    editButton.classList.add('disabled');
});
    </script>
@endif --}}




<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.bootstrap4.min.css">

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function() {
        $('#tbl_permintaannfa').DataTable({
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            buttons: [
                'excel', 'pdf', 'print'
            ]
        });
    });
</script>
@if(session('waiting'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops. Sorryy',
            text: '{{ session('waiting') }}',
        });
    </script>
@endif
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Select the bell icon
        var bellIcon = document.getElementById('bell');

        // Add a click event listener to the bell icon
        bellIcon.addEventListener('click', function (event) {
            // Dummy notification message
            var notificationMessage = 'You have a new notification!';

            // Create a div element for the notification
            var notificationDiv = document.createElement('div');
            notificationDiv.className = 'notification-popup';
            notificationDiv.textContent = notificationMessage;

            // Set the position of the notification div
            var rect = event.target.getBoundingClientRect();
            notificationDiv.style.position = 'fixed';
            notificationDiv.style.top = rect.bottom + 'px';
            notificationDiv.style.left = rect.left + 'px';

            // Add the notification div to the body
            document.body.appendChild(notificationDiv);

            // Remove the notification div after a few seconds
            setTimeout(function () {
                document.body.removeChild(notificationDiv);
            }, 3000); // Adjust the duration as needed
        });
    });
</script>


@endsection
    

