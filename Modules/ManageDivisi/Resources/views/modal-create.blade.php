<!-- Modal -->
<div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">TAMBAH DATA DIVISI </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id_divisi">
                <div class="form-group">
                    <label>Institusi</label>
                    <select id="id_institusi" class="form-control select2" style="width: 100%;" required>
                        <option value="">- Pilih Institusi -</option>
                        @foreach ($institusi as $ins)
                            <option value="{{ $ins->id_institusi }}">
                                {{ $ins->nama_institusi }}
                            </option>
                        @endforeach
                    </select>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-idinstitusi"></div>
                </div>
                <div class="form-group">
                    <label for="nama_divisi" class="control-label">Nama Divisi</label>
                    <input type="text" class="form-control" id="nama_divisi">
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
        $('body').on('click', '#btn-create-divisi', function() {

            //open modal
            $('#modal-create').modal('show');
        });

        //action create post
        $('#store').click(function(e) {
            e.preventDefault();

            //define variable
            let nama = $('#nama_divisi').val();
            let id_institusi = $('#id_institusi').val();
            let token = $("meta[name='csrf-token']").attr("content");

            //ajax
            $.ajax({

                url: `{{ route('managedivisi.store') }}`,
                type: "POST",
                cache: false,
                data: {
                    "nama_divisi": nama,
                    "id_institusi": id_institusi,
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

                    $('#modal-create').modal('hide');

                    setTimeout(function() { // wait for 3 secs
                        location.reload(); // then reload the page
                    }, 3000);
                },
                error: function(error) {
    console.log(error);
    let message = 'Something went wrong! Please try again.';
    if (error.responseJSON && error.responseJSON.message) {
        message = error.responseJSON.message;
    }

    //show alert
    $('#alert-nama').removeClass('d-none').addClass('d-block').html(message);
}


            });

        });

    });
</script>
