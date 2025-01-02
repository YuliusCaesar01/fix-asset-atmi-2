<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">UBAH DATA INSTITUSI</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('manage-institusi.update', $ins->id_institusi) }}" method="POST" id="form-edit" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id_institusi" value="{{ $ins->id_institusi }}">

                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama-edit" class="control-label">Institusi</label>
                        <input type="text" class="form-control" id="nama-edit" name="nama_institusi" value="{{ $ins->nama_institusi }}" required>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama-edit"></div>
                    </div>
                    <div class="form-group">
                        <label for="image-upload" class="control-label">Upload Gambar</label>
                        <input type="file" class="form-control" id="image-upload" name="image" accept="image/*">
                        <small>Gambar Minimal 2 Mb</small>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-image-upload"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">SIMPAN</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        //button create institusi event
        $('body').on('click', '#btn-edit-institusi', function() {

            let id_institusi = $(this).data('di');
            //fetch detail post with ajax
            $.ajax({
                url: `/institusi/manageinstitusi/${id_institusi}`,
                type: "GET",
                cache: false,
                success: function(response) {

                    //fill data to form
                    $('#id_institusi').val(response.data.id_institusi);
                    $('#nama-edit').val(response.data.nama_institusi);

                    //open modal
                    $('#modal-edit').modal('show');
                }
            });
        });

       
    });
</script>
