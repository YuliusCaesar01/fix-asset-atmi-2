<!-- Modal -->
<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">UBAH DATA DIVISI </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id_divisi">
                <div class="form-group">
                    <label for="nama-edit" class="control-label">Divisi</label>
                    <input type="text" class="form-control" id="nama-edit">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama-edit"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="update">SIMPAN</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        //button create divisi event
        $('body').on('click', '#btn-edit-divisi', function() {

            let id_divisi = $(this).data('di');
            //fetch detail post with ajax
            $.ajax({
                url: `/divisi/managedivisi/${id_divisi}`,
                type: "GET",
                cache: false,
                success: function(response) {

                    //fill data to form
                    $('#id_divisi').val(response.data.id_divisi);
                    $('#nama-edit').val(response.data.nama_divisi);

                    //open modal
                    $('#modal-edit').modal('show');
                }
            });
        });

        //action update post
        $('#update').click(function(e) {
            e.preventDefault();

            //define variable
            let id_divisi = $('#id_divisi').val();
            let nama_divisi = $('#nama-edit').val();
            let token = $("meta[name='csrf-token']").attr("content");

            //ajax
            $.ajax({
                url: `/divisi/managedivisi/${id_divisi}`,
                type: "PUT",
                cache: false,
                data: {
                    "nama_divisi": nama_divisi,
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
                    //data post
                    //append to post data
                    let replace_name =
                        `<h3 class="m-0 text-center" id="nama_divisi"><i class="fas fa-building"></i>
                                    ${response.data.nama_divisi}</h3>`;
                    //append to post data
                    $('#nama_divisi').replaceWith(replace_name);
                    //$('#nama-edit').val(response.data.nama_divisi);
                    //close modal
                    $('#modal-edit').modal('hide');
                },
                error: function(error) {

                    if (error.responseJSON.nama_edit[0]) {

                        //show alert
                        $('#alert-nama-edit').removeClass('d-none');
                        $('#alert-nama-edit').addClass('d-block');

                        //add message to alert
                        $('#alert-nama-edit').html(error.responseJSON.nama_edit[0]);
                    }

                }

            });

        });
    });
</script>
