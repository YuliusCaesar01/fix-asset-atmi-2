@extends('layouts.layout_main')
@section('title', 'User Guide')

@section('content')
<style>
    .nav-tabs .nav-link {
    border: none; /* Remove border */
    color: #333; 
}
.nav-tabs .nav-link.active {
    font-weight: bold; /* Bold active tab */
}
.btn-link {
    color: #007bff; /* Bootstrap primary color */
    text-decoration: none; /* Remove underline */
}

.card-header {
    background-color: #f8f9fa; /* Light background for header */
}

.card-body {
    padding: 15px; /* More padding for body */
}

.btn-link {
    text-decoration: none; /* Remove underline */
    color: #007bff; /* Bootstrap primary color */
}

.btn-link:hover {
    text-decoration: underline; /* Underline on hover */
}

.accordion .card {
    border: none; /* Remove borders */
}

.accordion .card-header {
    border-bottom: 1px solid #dee2e6; /* Light border for separation */
}


    </style>
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="content-header">
            <div class="row mb-4">
                <div class="col-6">
                    <h1 class="m-0 text-primary">User Guide</h1>
                </div>
                <div class="col-6 text-right">
                    <a href="{{ asset('pdfs/manualbook.pdf') }}" class="btn btn-sm btn-info" download>
                        <i class="fas fa-download"></i> Download User Guide
                    </a>
                    
                </div>
            </div>
        </div>

        <div class="content">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <ul class="nav nav-tabs card-header-tabs" id="userGuideTabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#overview">Overview</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#getting-started">Getting Started</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#faq">Frequently Asked Questions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#contact-support">Contact Support</a>
                        </li>
                    </ul>
                </div>

                <div class="card-body tab-content">
                    <div id="overview" class="tab-pane fade show active p-4 bg-light border rounded">
                        <h6 class="font-weight-bold text-primary mb-3">Welcome to the User Guide</h6>
                        <p class="mb-4">This user guide provides comprehensive information on how to use our application effectively. Below, you will find sections detailing the features and functionalities available.</p>
                        
                        
                    </div>
                    

                    <div id="getting-started" class="tab-pane fade">
                        <h6 class="font-weight-bold text-primary">Getting Started</h6>
                        <p class="mb-4">Memulai dengan langkah sederhana untuk aplikasi FixedAsset:</p>
                        
                        <div class="list-group">
                         
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1"><i class="fas fa-sign-in-alt"></i> Log In</h5>
                                    <small>Step 1</small>
                                </div>
                                <p class="mb-1">Log in dengan akun yang sudah ada.</p>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1"><i class="fas fa-tachometer-alt"></i> Melihat bagian Dashboard</h5>
                                    <small>Step 2</small>
                                </div>
                                <p class="mb-1">Explorasi data Informasi jumlah Fixed Asset.</p>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1"><i class="fas fa-box"></i> Menuju pada FixAsset</h5>
                                    <small>Step 3</small>
                                </div>
                                <p class="mb-1">Melihat dan Melakukan Aksi pada Data list Fixed Asset dan Pengajuannya.</p>
                            </a>
                        </div>
                    </div>
                    
                    <div id="faq" class="tab-pane fade">
                        <h6 class="font-weight-bold text-primary">Frequently Asked Questions</h6>
                        <p class="mb-4">Ini adalah pertanyaan yang sering ditanyakan:</p>
                    
                        <div class="accordion" id="faqAccordion">
                            <div class="card mb-2">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            <i class="fas fa-question-circle"></i> Bagaimana cara saya ganti password/profil?
                                        </button>
                                    </h5>
                                </div>
                    
                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#faqAccordion">
                                    <div class="card-body">
                                        klik  foto profil pada pojok kiri atas dan klik edit (bergambar pensil)
                                    </div>
                                </div>
                            </div>
                    
                            <div class="card mb-2">
                                <div class="card-header" id="headingTwo">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            <i class="fas fa-question-circle"></i> Bagaimana saya mengajukan fixedasset?
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#faqAccordion">
                                    <div class="card-body">
                                        Anda dapat mengajukan fixed asset pada kolom kirim permintaan Fixed Asset lalu klik tanda (+)/plus diatas table
                                    </div>
                                </div>
                            </div>
                    
                            <!-- Add more FAQ items here -->
                            
                        </div>
                    </div>
                    
                    
                    

                    <div id="contact-support" class="tab-pane fade p-4 bg-light border rounded">
                        <h6 class="font-weight-bold text-primary mb-3">Contact Support</h6>
                        <p class="mb-4">Jika anda membutuhkan bantuan lebih lanjut anda dapat menghubungi kami:</p>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="fas fa-envelope text-primary"></i>
                                <strong>Email:</strong> 
                                <a href="mailto:atmi@example.com" class="text-decoration-none">fixaset@example.com</a>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-phone-alt text-primary"></i>
                                <strong>Phone:</strong> +62 456-7890
                            </li>
                           
                        </ul>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
