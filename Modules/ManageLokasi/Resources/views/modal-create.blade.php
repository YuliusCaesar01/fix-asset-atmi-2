<!-- Modal -->
<div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">TAMBAH DATA LOKASI</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="alert-container"></div>
                <form action="{{ route('manage-lokasi.store') }}" method="POST" id="form-create-lokasi" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="id_lokasi" name="id_lokasi">

                    <div class="form-group">
                        <label for="nama-lokasi-yayasan" class="control-label">Nama Lokasi</label>
                        <input type="text" class="form-control" id="nama-lokasi-yayasan" name="nama_lokasi_yayasan" required>
                        <div class="invalid-feedback" id="nama-lokasi-yayasan-error"></div>
                    </div>

                    <div class="form-group">
                        <label for="keterangan-lokasi-yayasan" class="control-label">Keterangan Lokasi</label>
                        <input type="text" class="form-control" id="keterangan-lokasi-yayasan" name="keterangan_lokasi" required>
                        <div class="invalid-feedback" id="keterangan-lokasi-error"></div>
                    </div>

                    <div class="form-group">
                        <label for="image" class="control-label">Upload Gambar (optional)</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <small class="text-muted">Gambar Maksimal 2 Mb</small>
                        <div class="invalid-feedback" id="image-error"></div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">TUTUP</button>
                        <button type="submit" class="btn btn-primary">SIMPAN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Show modal
    $('body').on('click', '#btn-create-lokasi', function() {
        $('#modal-create').modal('show');
    });

    // Form submission
    $('#form-create-lokasi').on('submit', function(e) {
        e.preventDefault();
        
        // Reset previous error states
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').text('');
        $('#alert-container').empty();
        
        let formData = new FormData(this);
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#modal-create').modal('hide');
                // Show success message
                Swal.fire({
                    title: 'Sukses!',
                    text: 'Data lokasi berhasil ditambahkan',
                    icon: 'success',
                    timer: 1500
                }).then(() => {
                    // Refresh the page or update the data table
                    location.reload();
                });
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    // Validation errors
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        let inputField = $(`[name="${key}"]`);
                        let errorDisplay = $(`#${key}-error`);
                        
                        inputField.addClass('is-invalid');
                        errorDisplay.text(value[0]);
                    });

                    // Show error alert
                    $('#alert-container').html(`
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Mohon periksa kembali input Anda
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    `);
                } else {
                    // Server error
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan pada server',
                        icon: 'error'
                    });
                }
            }
        });
    });

    // Reset form when modal is closed
    $('#modal-create').on('hidden.bs.modal', function () {
        $('#form-create-lokasi')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').text('');
        $('#alert-container').empty();
    });
});
</script>