<!-- Modal -->
<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">UBAH DATA KELOMPOK</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-edit" enctype="multipart/form-data">
                @csrf
                @method('PUT') <!-- This is required for Laravel PUT requests -->
                <input type="hidden" id="id_kelompok" name="id_kelompok">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama-edit" class="control-label">Nama Kelompok</label>
                        <input type="text" name="nama_kelompok" placeholder="Nama Kelompok" 
                               class="form-control @error('nama_kelompok') is-invalid @enderror" 
                               id="nama-edit" required>
                        <div id="alert-nama-edit" class="alert alert-danger mt-2 d-none"></div>
                    </div>

                    <div class="form-group">
                        <label for="image-edit" class="control-label">Upload Gambar (optional)</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               id="image-edit" name="image" accept="image/*">
                        <small>Gambar Minimal 2 Mb</small>
                        <div id="alert-image-edit" class="alert alert-danger mt-2 d-none"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="update">SIMPAN</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
    $(document).ready(function () {
    // Open Edit Modal and Populate Data
    $('body').on('click', '#btn-edit-kelompok', function () {
        let id_kelompok = $(this).data('id'); // Ensure this matches the data attribute
        $.ajax({
            url: `/kelompok/managekelompok/detail/${id_kelompok}`,
            type: "GET",
            cache: false,
            success: function (response) {
                // Populate form fields with fetched data
                $('#id_kelompok').val(response.data.id_kelompok);
                $('#nama-edit').val(response.data.nama_kelompok);
                $('#modal-edit').modal('show');
            },
            error: function (error) {
                console.log(error.responseJSON);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal mengambil data!',
                    text: 'Terjadi kesalahan saat mengambil data. Silakan coba lagi.',
                });
            },
        });
    });

    // Update Data via AJAX
    $('#form-edit').on('submit', function (e) {
        e.preventDefault();

        let id_kelompok = $('#id_kelompok').val();
        let nama_kelompok = $('#nama-edit').val();
        let token = $("meta[name='csrf-token']").attr("content");

        let formData = new FormData(this);
        formData.append("_method", "PUT");

        $.ajax({
            url: `/kelompok/managekelompok/detail/${id_kelompok}`,
            type: "POST",
            cache: false,
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: false,
                    timer: 3000,
                });
                $('#modal-edit').modal('hide');
                // Optionally update the table or UI with the new data
            },
            error: function (error) {
                console.log(error.responseJSON);
                if (error.responseJSON.errors.nama_kelompok) {
                    $('#alert-nama-edit')
                        .removeClass('d-none')
                        .addClass('d-block')
                        .html(error.responseJSON.errors.nama_kelompok[0]);
                }
                if (error.responseJSON.errors.image) {
                    $('#alert-image-edit')
                        .removeClass('d-none')
                        .addClass('d-block')
                        .html(error.responseJSON.errors.image[0]);
                }
            },
        });
    });
});

</script>
