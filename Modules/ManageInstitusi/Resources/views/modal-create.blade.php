<!-- Modal -->
<div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">TAMBAH DATA INSTITUSI </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                
            </div>
            <div class="modal-body">
                <input type="hidden" id="id_institusi">
                <div class="form-group">
                    <label for="nama_institusi" class="control-label">Institusi</label>
                    <input type="text" class="form-control" id="nama_institusi" required>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="store">SIMPAN</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        //button create post event
        $('body').on('click', '#btn-create-institusi', function() {

            //open modal
            $('#modal-create').modal('show');
        });

        //action create post
        $('#store').click(function(e) {
            e.preventDefault();

            //define variable
            let nama = $('#nama_institusi').val();
            let token = $("meta[name='csrf-token']").attr("content");

            //ajax
            $.ajax({

                url: `{{ route('manageinstitusi.store') }}`,
                type: "POST",
                cache: false,
                data: {
                    "nama_institusi": nama,
                    "_token": token
                },
                success: function(response) {

                    //show success message
                    Swal.fire({
                        icon: 'success',
                        title: `${response.message}`,
                        showConfirmButton: false,
                        timer: 3000
                    });

                    let post =
                        `<tr id="index_${response.data.id_institusi}">
                            <td class="text-center lead"><span  class="badge bg-yellow"> ${response.data.kode_institusi} </span></td>
                            <td> ${response.data.nama_institusi} </td> 
                            <td>
                                <a href="javascript:void(0)" id="btn-detail-institusi" data-di = "${response.data.id_institusi}" title="Detail Institusi" class="btn btn-sm btn-light">
                                    <i class="far fa-folder-open"></i>
                                </a>
                                <a href = "javascript:void(0)" id ="btn-edit-institusi" data-di = "${response.data.id_institusi}"  title="Ubah Institusi" class="btn btn-sm btn-light">
                                    <i class = "fas fa-pencil-alt"> </i> 
                                </a>
                            </td> 
                        </tr>`;

                    //append to table
                    $('#tbl_institusi').prepend(post);

                    //clear form
                    $('#nama_institusi').val('');

                    //close modal
                    $('#modal-create').modal('hide');


                },
                error: function(error) {

                    if (error.responseJSON.nama_institusi[0]) {

                        //show alert
                        $('#alert-nama').removeClass('d-none');
                        $('#alert-nama').addClass('d-block');

                        //add message to alert
                        $('#alert-nama').html(error.responseJSON.nama_institusi[0]);
                    }

                }

            });

        });

    });
</script>
