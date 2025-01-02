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
                <form action="{{ route('manage-lokasi.store') }}" method="POST" id="form-create-lokasi" enctype="multipart/form-data">
                    @csrf <!-- CSRF token for security -->
                    <input type="hidden" id="id_lokasi" name="id_lokasi">

                    <div class="form-group">
                        <label for="nama-lokasi-yayasan" class="control-label">Nama Lokasi</label>
                        <input type="text" class="form-control @error('nama_lokasi') is-invalid @enderror" id="nama-lokasi-yayasan" name="nama_lokasi" required value="{{ old('nama_lokasi') }}">
                        @error('nama_lokasi')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="keterangan-lokasi-yayasan" class="control-label">Keterangan Lokasi</label>
                        <input type="text" class="form-control @error('keterangan_lokasi') is-invalid @enderror" id="keterangan-lokasi-yayasan" name="keterangan_lokasi" required value="{{ old('keterangan_lokasi') }}">
                        @error('keterangan_lokasi')
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

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">SIMPAN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('body').on('click', '#btn-create-lokasi', function() {
            $('#modal-create').modal('show');
        });
    });
</script>
