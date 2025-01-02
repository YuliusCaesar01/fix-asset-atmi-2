<!-- Modal -->
<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ubah Data Tipe</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <form action="{{ route('manage-tipe.update', $tipe->id_tipe) }}" method="POST" id="form-edit" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id_tipe" value="{{ $tipe->id_tipe }}">

                    <div class="form-group">
                        <label for="nama-edit" class="control-label">Nama Tipe</label>
                        <input type="text" name="nama_tipe" placeholder="{{ $tipe->nama_tipe }}" class="form-control @error('nama_tipe') is-invalid @enderror" id="nama-edit" value="{{ old('nama_tipe', $tipe->nama_tipe) }}" required>
                        
                        @if ($errors->has('nama_tipe'))
                            <div class="alert alert-danger mt-2" role="alert">
                                {{ $errors->first('nama_tipe') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="image-edit" class="control-label">Upload Gambar (optional)</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image-edit" name="image" accept="image/*">
                        @if ($errors->has('image'))
                            <div class="alert alert-danger mt-2" role="alert">
                                {{ $errors->first('image') }}
                            </div>
                        @endif
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        //button create tipe event
        $('body').on('click', '#btn-edit-tipe', function() {

            let id_tipe = $(this).data('di');
            //fetch detail post with ajax
            $.ajax({
                url: `/tipe/managetipe/${id_tipe}`,
                type: "GET",
                cache: false,
                success: function(response) {

                    //fill data to form
                    $('#id_tipe').val(response.data.id_tipe);
                    $('#nama-edit').val(response.data.nama_tipe);

                    //open modal
                    $('#modal-edit').modal('show');
                }
            });
        });

        //action update post
        $('#update').click(function(e) {
            e.preventDefault();

            //define variable
            let id_tipe = $('#id_tipe').val();
            let nama_tipe = $('#nama-edit').val();
            let token = $("meta[name='csrf-token']").attr("content");

            //ajax
            $.ajax({
                url: `/tipe/managetipe/${id_tipe}`,
                type: "PUT",
                cache: false,
                data: {
                    "nama_tipe": nama_tipe,
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
                    let replace_name =
                        `<h3 class="m-0 text-center" id="nama_tipe"><i class="fas fa-building"></i>
                                    ${response.data.nama_tipe}</h3>`;
                    //append to post data
                    $('#nama_tipe').replaceWith(replace_name);

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
