// Handle Generate PDF button click
document.getElementById('generatePdf').addEventListener('click', function() {
    var idPermintaan = $('#dirmansetuju').data('id');
    // Lakukan tindakan untuk generate PDF
    alert('Membuat pengesahan berita acara untuk permintaan ID: ' + idPermintaan);
    // Close modal
    $('#approveModal').modal('hide');
});

// Handle Reject button click
document.getElementById('confirmReject').addEventListener('click', function() {
    var alasan = document.getElementById('rejectReason').value;
    if (alasan.trim() === '') {
        alert('Harap masukkan alasan penolakan.');
        return;
    }
    var idPermintaan = $('#dirmantolak').data('id');
    // Lakukan tindakan untuk reject dengan alasan
    alert('Permintaan dengan ID: ' + idPermintaan + ' ditolak dengan alasan: ' + alasan);
    // Close modal
    $('#rejectModal').modal('hide');
});

  // Ketika tombol tindakan diklik, ambil data-id dari tombol dan simpan di modal
  document.getElementById('tindakan').addEventListener('click', function() {
    var permintaanId = this.getAttribute('data-id'); // Ambil ID dari atribut data-id
    document.getElementById('permintaanId').value = permintaanId; // Set ID ke hidden input
});

document.getElementById('rejectBtn').addEventListener('click', function() {
    showConfirmationSection('Ditolak');
    disableCloseButton();
    document.getElementById('alasanSection').style.display = 'block'; // Tampilkan input alasan
});

document.getElementById('approveBtn').addEventListener('click', function() {
    showConfirmationSection('Setuju');
    disableCloseButton();
    document.getElementById('alasanSection').style.display = 'none'; // Sembunyikan input alasan
});

function showConfirmationSection(action) {
    // Sembunyikan tombol awal dan tampilkan inputan serta tombol konfirmasi
    document.getElementById('initialButtons').style.display = 'none';
    document.getElementById('confirmationSection').style.display = 'block';
    
    // Set hidden input untuk jenis tindakan (approve/reject)
    document.getElementById('tindakanType').value = action;
    
    // Ganti teks tombol konfirmasi sesuai dengan aksi yang dipilih
    const confirmBtn = document.getElementById('confirmBtn');
    confirmBtn.innerText = action + ' Konfirmasi';
}

function disableCloseButton() {
    // Disable the close button
    document.getElementById('closeButton').disabled = true;
}
document.addEventListener('DOMContentLoaded', function() {
  const approvalButtons = document.querySelectorAll('.approve-btn, .reject-btn');
  const approvalForm = document.getElementById('approveForm');
  const rejectForm = document.getElementById('rejectForm');

  approvalButtons.forEach(button => {
    button.addEventListener('click', function() {
      const statusPermohonan = button.getAttribute('data-status');
      const id = button.getAttribute('data-id');

      if (button.classList.contains('approve-btn')) {
        approvalForm.action = '{{ route('managepermintaanfa.approve') }}';
        document.getElementById('approveId').value = id;

        let unitSourceContainer = document.getElementById('unitSourceContainerApprove');
        let priceEstimateContainer = document.getElementById('priceEstimateContainerApprove');

        // Configure input fields based on statusPermohonan
        if (statusPermohonan === 'Pemindahan') {
          unitSourceContainer.classList.remove('d-none');
          priceEstimateContainer.classList.add('d-none');

          const unitSourceInput = document.getElementById('unitSourceApprove');
          unitSourceInput.setAttribute('placeholder', 'Enter the original asset unit');
          unitSourceInput.setAttribute('aria-label', 'Unit Asal');
        } else {
          unitSourceContainer.classList.add('d-none');
          priceEstimateContainer.classList.remove('d-none');

          const priceEstimateInput = document.getElementById('priceEstimateApprove');
          priceEstimateInput.setAttribute('placeholder', 'Enter the estimated price');
          priceEstimateInput.setAttribute('aria-label', 'Perkiraan Harga');
        }

        approvalForm.classList.remove('d-none');
        rejectForm.classList.add('d-none');
      } else if (button.classList.contains('reject-btn')) {
        rejectForm.action = '{{ route('managepermintaanfa.reject') }}';
        document.getElementById('rejectId').value = id;

        approvalForm.classList.add('d-none');
        rejectForm.classList.remove('d-none');
      }

      // Show the modal
      new bootstrap.Modal(document.getElementById('approvalModal')).show();
    });
  });
});