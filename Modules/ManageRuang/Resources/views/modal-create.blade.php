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
                        <label for="institusi" class="control-label">Nama Institusi</label>
                        <select name="id_institusi" class="form-control @error('id_institusi') is-invalid @enderror" id="institusi" required onchange="setInstitusiName(this)">
                            <option value="">- Pilih Instansi -</option>
                            @foreach($institusi as $item)
                                <option value="{{ $item->id_institusi }}" data-nama="{{ $item->nama_institusi }}">{{ $item->nama_institusi }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="nama_institusi" id="nama_institusi_hidden">
                        @error('id_institusi')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="nama_ruang" class="control-label">Nama Ruang</label>
                        <input type="text" class="form-control @error('nama_ruang') is-invalid @enderror" name="nama_ruang" id="nama_ruang" value="{{ old('nama_ruang') }}">
                        @error('nama_ruang')
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
<script>
   function setInstitusiName(selectElement) {
    var selectedOption = selectElement.options[selectElement.selectedIndex];
    var namaInstitusi = selectedOption.text;
    document.getElementById('nama_institusi_hidden').value = namaInstitusi;
}
</script>

