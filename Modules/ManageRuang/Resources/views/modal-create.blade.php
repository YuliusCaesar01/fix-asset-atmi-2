<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Modal -->
<div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">TAMBAH DATA RUANG</h5>
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
                <!-- Start Form -->
                <form action="{{ route('manage-ruang.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Form fields -->
                    <div class="form-group">
                        <label for="nama_yayasan" class="control-label">Nama Ruang Yayasan</label>
                        <input type="text" class="form-control @error('nama_yayasan') is-invalid @enderror" name="nama_yayasan" id="nama_yayasan" value="{{ old('nama_yayasan') }}">
                        @error('nama_yayasan')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="nama_mikael" class="control-label">Nama Ruang Mikael</label>
                        <input type="text" class="form-control @error('nama_mikael') is-invalid @enderror" name="nama_mikael" id="nama_mikael" value="{{ old('nama_mikael') }}">
                        @error('nama_mikael')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="nama_politeknik" class="control-label">Nama Ruang Politeknik</label>
                        <input type="text" class="form-control @error('nama_politeknik') is-invalid @enderror" name="nama_politeknik" id="nama_politeknik" value="{{ old('nama_politeknik') }}">
                        @error('nama_politeknik')
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
                <!-- End Form -->
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for AJAX Request -->
<script>
$(document).ready(function() {
    // Open modal when button is clicked
    $('#btn-create-ruang').click(function() {
        $('#modal-create').modal('show');
    });

  
});
document.querySelectorAll('.close-modal, .close').forEach(function (button) {
        button.addEventListener('click', function () {
            $('#editModal').modal('hide');
        });
    });
</script>

