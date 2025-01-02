<!-- Modal -->
<div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">TAMBAH DATA JENIS</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="modal-body">
                <form action="{{ route('manage-jenis.store') }}" method="POST" id="form-create-jenis" enctype="multipart/form-data">
                    @csrf <!-- CSRF token for security -->
                    <input type="hidden" id="id_jenis" name="id_jenis">

                    <div class="form-group">
                        <label>Kelompok</label>
                        <select id="id_kelompok" name="id_kelompok" class="form-control select2" style="width: 100%;" required>
                            <option value="">- Pilih Kelompok -</option>
                            @foreach ($kelompok as $klp)
                                <option value="{{ $klp->id_kelompok }}" {{ old('id_kelompok') == $klp->id_kelompok ? 'selected' : '' }}>
                                    {{ $klp->nama_kelompok_yayasan }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_kelompok')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nama_jenis" class="control-label">Jenis Barang Yayasan</label>
                        <input type="text" class="form-control @error('nama_jenis_yayasan') is-invalid @enderror" id="nama_jenis_yayasan" name="nama_jenis_yayasan" required value="{{ old('nama_jenis_yayasan') }}">
                        @error('nama_jenis_yayasan')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="image" class="control-label">Upload Gambar (optional)</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                        <small>Gambar Minimal 2 Mb</small>
                        @error('image')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="submit-button">SIMPAN</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        // Button create post event
        $('body').on('click', '#btn-create-kelompok', function() {
            $('#modal-create').modal('show');
        });

        // Submit form on button click
        $('#submit-button').click(function(e) {
            e.preventDefault();
            $('#form-create-jenis').submit(); // Submit the form
        });

        // Optionally, you can handle success/error messages after form submission with Laravel's session flash
    });
</script>
