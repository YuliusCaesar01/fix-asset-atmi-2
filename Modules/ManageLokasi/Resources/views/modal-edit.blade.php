<!-- Modal -->
<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">UBAH DATA LOKASI</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('manage-lokasi.update', $lokasi->id_lokasi) }}" method="POST" id="form-edit" enctype="multipart/form-data">
                @csrf
                @method('PUT') <!-- Method override to PUT for updating -->
                <input type="hidden" id="id_lokasi" name="id_lokasi" value="{{ $lokasi->id_lokasi }}">
                
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama-lokasi-yayasan" class="control-label">Nama Lokasi</label>
                        <input type="text" name="nama_lokasi" value="{{ $lokasi->nama_lokasi_yayasan }}" class="form-control" id="nama-lokasi-yayasan">
                        @if ($errors->has('nama_lokasi'))
                            <div class="alert alert-danger mt-2" role="alert">
                                {{ $errors->first('nama_lokasi') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="keterangan-lokasi-yayasan" class="control-label">Keterangan Lokasi</label>
                        <input type="text" name="keterangan_lokasi" value="{{ $lokasi->keterangan_lokasi }}" class="form-control" id="keterangan-lokasi-yayasan">
                        @if ($errors->has('keterangan_lokasi'))
                            <div class="alert alert-danger mt-2" role="alert">
                                {{ $errors->first('keterangan_lokasi') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="image" class="control-label">Upload Gambar (optional)</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                        <small>Gambar Minimal 2 Mb</small>
                        @error('image')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    @if ($lokasi->image)
                        <div class="form-group">
                            <label for="current-image" class="control-label">Gambar Saat Ini</label>
                            <img src="{{ asset('storage/' . $lokasi->image) }}" alt="Current Image" class="img-fluid mb-2" style="max-width: 100%;">
                        </div>
                    @endif
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
        //button create lokasi event
        $('body').on('click', '#btn-edit-lokasi', function() {

            let id_lokasi = $(this).data('di');
            //fetch detail post with ajax
            $.ajax({
                url: `/lokasi/managelokasi/${id_lokasi}`,
                type: "GET",
                cache: false,
                success: function(response) {

                    //fill data to form
                    $('#id_lokasi').val(response.data.id_lokasi);
                    $('#nama-edit').val(response.data.nama_lokasi);
                    //$('#idtipe-edit').val(response.data.id_tipe).trigger('change');

                    //open modal
                    $('#modal-edit').modal('show');
                }
            });
        });

        //action update post
        $('#update').click(function(e) {
            e.preventDefault();
            $(this).html('Sending..');

            //define variable
            let id_lokasi = $('#id_lokasi').val();
            let nama_lokasi = $('#nama-edit').val();
            let token = $("meta[name='csrf-token']").attr("content");

            //ajax
            $.ajax({
                url: `/lokasi/managelokasi/${id_lokasi}`,
                type: "PUT",
                cache: false,
                data: {
                    "nama_lokasi": nama_lokasi,
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
                        `<h3 class="m-0 text-center" id="nama_lokasi"><i class="fas fa-building"></i>
                                    ${response.data.nama_lokasi}</h3>`;
                    //append to post data
                    $('#nama_lokasi').replaceWith(replace_name);
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
