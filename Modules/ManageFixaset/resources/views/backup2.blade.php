@extends('layouts.layout_main')
@section('title', 'Data Institusi')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
<style>
    .btn-approve, .btn-reject {
        font-size: 14px;
    }
</style>
@import url('https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.css')

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-6">
                        <h1 class="m-0">Pengajuan FixAssets</h1>
                    </div>
                    <div class="col-6">
                        <a href="javascript:void(0)" class="btn btn-sm btn-info float-right" id="btn-create-institusi">
                            <i class="fas fa-plus"></i> Mengajukan
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header ">
                      PENGAJUAN
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-striped table-sm" id="tbl_institusi">
                            <thead>
                                <tr>
                                    <th>Kode Ajuan</th>
                                    <th>Pengajuan</th>
                                    <th>Validasi Kaprodi</th>
                                    <th>Validasi Corporate</th>
                                    <th>Status</th>
                                    <th>Jenis Pelayanan</th>
                                    <th>Kebutuhan</th>
                                    <th>Keterangan Teknis</th>
                                    <th>Validasi Finance</th>
                                    <th>Catatan</th>
                                    <th>Actions</th>
                                    <th class="w-1"><i class="fas fa-bars"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="index_ada">
                                    <td class="text-center lead">
                                        <span class="badge bg-black">1 </span>
                                    </td>
                                    <td><div class="badge bg-grey">Keterangan pengajuan pengajuan pengajuan</div></td>
                                    <td id="validasi1">0</td>
                                    <td id="validasi2">0</td>
                                    <td><span class="badge bg-green" id="status">DIPROSES<h1></h1><i id="status2" class="fas fa-times"></i></td>
                                    <td>Barang/Jasa</td>
                                    <td><Span id="span1" style="align-content: center;">-</Span></td>
                                    <td><div  id="input" class="badge bg-yellow" value="Estimasi Biaya 1jt"></div></td>
                                    <td><span class="badge bg-green">V</span></td>
                                    <td></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-success btn-sm mr-1" id="approveBtn">
                                                <i class='fas fa-check'></i> Approve
                                            </a>
                                            <a href="#" class="btn btn-danger btn-sm mr-1" id="rejectBtn">
                                                <i class="fas fa-times"></i> Reject
                                            </a>
                                            <a href="#" class="btn btn-secondary btn-sm" style="font-size: 14px;" id="editBtn">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Kode Ajuan</th>
                                    <th>Pengajuan</th>
                                    <th>Validasi Kaprodi</th>
                                    <th>Validasi Corporate</th>
                                    <th>Status</th>
                                    <th>Jenis Pelayanan</th>
                                    <th>Kebutuhan</th>
                                    <th>Keterangan Teknis</th>
                                    <th>Validasi Finance</th>
                                    <th>Catatan</th>
                                    <th>Actions</th>
                                    <th class="w-1"><i class="fas fa-bars"></i></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="popupForm" style="display: none;">
    <h2>Formulir Barang</h2>
    <form id="itemForm" onsubmit="submitForm()">
        Nama Barang: <input type="text" id="itemName" required><br>
        Jumlah: <input type="number" id="itemQuantity" required><br>
        <input type="submit" value="Submit">
    </form>
</div>

<script>
   document.getElementById("approveBtn").addEventListener("click", function() {
        this.remove();
        document.getElementById("rejectBtn").remove();
        Swal.fire({
            title: 'Pengajuan di-approve!',
            icon: 'success',
            confirmButtonText: 'Ok'
        });
    });

    document.getElementById("rejectBtn").addEventListener("click", function() {
        document.getElementById("approveBtn").remove();
        this.remove();
        Swal.fire({
            title: 'Pengajuan di-reject!',
            icon: 'error',
            confirmButtonText: 'Ok'
        });
    });
</script>

@include('manageinstitusi::modal-create')

@endsection
@section('scripttambahan')

<script>
 var spanclass =  document.getElementById("status");
 var value =  document.getElementById("status").textContent;

switch(value){
    case "DITERIMA":
            document.getElementById("select2").disabled = false;
            var klas = document.getElementById("status").className;
            document.getElementById("status").className = "badge bg-green";
            document.getElementById("status2").className = "fas fa-check";   
            break;
            
    case "DITOLAK":
            document.getElementById("select2").disabled = true;
            var klas = document.getElementById("status").className;
            document.getElementById("status").className = "badge bg-red";
            document.getElementById("status2").className = "fas fa-times";
            break;
     case "DIPROSES":
            var klas = document.getElementById("status").className;
            document.getElementById("status").className = "badge bg-black";
            document.getElementById("status2").className = "fa fa-spinner fa-spin";
            break;
 }
</script>

<script>
var validasi1 =  document.getElementById("validasi1").textContent;
var validasi2 =  document.getElementById("validasi2").textContent;
switch (true) {
    case validasi1 == "1":
        document.getElementById("validasi1").innerHTML = '<span class="badge bg-green"><i class="fas fa-check"></i></span>';
       
    case validasi2 == "1":
        document.getElementById("validasi2").innerHTML = '<span class="badge bg-green"><i class="fas fa-check"></i></span>';
       
       case validasi1 == "0":
           document.getElementById("validasi1").innerHTML = '<span class="badge bg-red"><i class="fas fa-times"></i></span>';
         
       case validasi2 == "0":
           document.getElementById("validasi2").innerHTML = '<span class="badge bg-red"><i class="fas fa-times"></i></span>';
          
       default:
           break;
   }
   
   </script>
       
   <!-- Page specific script -->
   <script>
       $(function() {
           $("#tbl_institusi").DataTable({
               "responsive": true,
               "lengthChange": false,
               "autoWidth": false,
               "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
           }).buttons().container().appendTo('#tbl_institusi_wrapper .col-md-6:eq(0)');
       });
   </script>
   
   <script>
   function Jenislayanan() {
       var itemType = document.getElementById("select2").value;
   
       if (itemType === "barang") {
           var itemType = document.getElementById("select2").value;
       } else {
           Swal.fire({
               title: "Butuh Barang?",
               text: "Apakah anda hanya membutuhkan barang?",
               icon: "question",
               showCancelButton: true,
               confirmButtonColor: "#3085d6",
               cancelButtonColor: "#d33",
               confirmButtonText: "IYA",
               cancelButtonText: 'TIDAK',
           }).then((result) => {
               if (result.isConfirmed) {
                   Swal.fire({
                       title: "Butuh Barang",
                       text: "Anda membutuhkan barang",
                       icon: "success"
                   });
               } else {
                   Swal.fire({
                       title: "Butuh Subcon?",
                       text: "Apakah anda hanya membutuhkan barang?",
                       icon: "question",
                       showCancelButton: true,
                       confirmButtonColor: "#3085d6",
                       cancelButtonColor: "#d33",
                       confirmButtonText: "IYA",
                       cancelButtonText: 'TIDAK',
                   });
               }
           });
       }
   }
   </script>
   @endsection
   
