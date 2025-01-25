@extends('layouts.master')

@section('title') @lang('My-Profile') @endsection

@section('css')
<!-- Add any specific CSS you need here -->
@endsection

@section('content')

{{-- @section('pagetitle') <small>My Profile</small> @endsection --}}

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Personal Information Data</h4>
            </div>
            <div class="card-body">
                <p class="card-title-desc"></p>

                <div class="row">
                    <div class="col-md-3">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                            aria-orientation="vertical">
                            <a class="nav-link mb-2 active" id="v-pills-personal-tab" data-bs-toggle="pill"
                                href="#v-pills-personal" role="tab" aria-controls="v-pills-personal"
                                aria-selected="true">Personal Info</a>
                            <a class="nav-link mb-2" id="v-pills-contact-tab" data-bs-toggle="pill"
                                href="#v-pills-contact" role="tab" aria-controls="v-pills-contact"
                                aria-selected="false">Contact</a>
                            <a class="nav-link mb-2" id="v-pills-professional-tab" data-bs-toggle="pill"
                                href="#v-pills-professional" role="tab" aria-controls="v-pills-professional"
                                aria-selected="false">Professional</a>
                            <a class="nav-link" id="v-pills-documents-tab" data-bs-toggle="pill"
                                href="#v-pills-documents" role="tab" aria-controls="v-pills-documents"
                                aria-selected="false">Documents</a>
                        </div>
                    </div>
                    <div class="col-md-9">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">

                            <div class="tab-pane fade show active" id="v-pills-personal" role="tabpanel"
                                aria-labelledby="v-pills-personal-tab">
                                
                                {{-- Personal Info Section--}}
                                @include('area.layouts.personal-info', ['personalInfo' => $personalInfo])

                                {{-- Social Media Section--}}
                                @include('area.layouts.social-media', ['socialMedia' => $socialMedia])

                                {{-- Family Section --}}
                                @include('area.layouts.family', ['family' => $family])

                                {{-- Size section --}}
                                @include('area.layouts.size', ['size' => $size])

                            </div>

                            <div class="tab-pane fade" id="v-pills-contact" role="tabpanel"
                                aria-labelledby="v-pills-contact-tab">
                                <h5>Contact Information</h5>

                                <!-- Address Section -->
                                @include('area.layouts.address', ['address' => $address])
                                
                                <!-- Communication Section -->
                                @include('area.layouts.communication', ['communication' => $communication])

                                <!-- Reference Section -->
                                @include('area.layouts.reference', ['reference' => $reference])

                            </div>

                            <div class="tab-pane fade" id="v-pills-professional" role="tabpanel"
                                aria-labelledby="v-pills-professional-tab">
                                <h5>Professional Information</h5>   

                                <!-- Education Section -->
                                @include('area.layouts.education', ['education' => $education])

                                <!-- Experience Section -->
                                @include('area.layouts.experience', ['experience' => $experience])

                                <!-- Language Section -->
                                @include('area.layouts.language', ['language' => $language])

                                <!-- Skill Section -->
                                @include('area.layouts.skill', ['skill' => $skill])

                            </div>

                            <div class="tab-pane fade" id="v-pills-documents" role="tabpanel"
                                aria-labelledby="v-pills-documents-tab">
                                <h5>Documents Information</h5>   

                                <!-- Skill Section -->
                                @include('area.layouts.bank', ['bank' => $bank])
                                
                                <!-- Tax Section -->
                                @include('area.layouts.tax', ['tax' => $tax])
                            

                                {{-- <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4 class="card-title">Documents</h4>
                                            <button type="button" class="btn btn-sm btn-success">Create</button>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Type Document</th>
                                                            <th>Path</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>KTP</td>
                                                            <td><button class="btn btn-secondary btn-sm">Upload</button></td>
                                                            <td><button class="btn btn-primary btn-sm">Edit</button> <button class="btn btn-danger btn-sm">Delete</button></td>
                                                        </tr>
                                                        <tr>
                                                            <td>KK</td>
                                                            <td><button class="btn btn-secondary btn-sm">Upload</button></td>
                                                            <td><button class="btn btn-primary btn-sm">Edit</button> <button class="btn btn-danger btn-sm">Delete</button></td>
                                                        </tr>
                                                        <tr>
                                                            <td>CV</td>
                                                            <td><button class="btn btn-secondary btn-sm">Upload</button></td>
                                                            <td><button class="btn btn-primary btn-sm">Edit</button> <button class="btn btn-danger btn-sm">Delete</button></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Passport</td>
                                                            <td><button class="btn btn-secondary btn-sm">Upload</button></td>
                                                            <td><button class="btn btn-primary btn-sm">Edit</button> <button class="btn btn-danger btn-sm">Delete</button></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                <!-- Document Section -->
                                @include('area.layouts.document', ['document' => $document, 'refTypeDocuments' => $refTypeDocuments])

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end card -->
        </div>
    </div>
</div>

@endsection

@section('script')

    {{-- my-profile-main.js --}}
    <script>
        function toggleSinceField(selectElement) {
            const sinceField = document.getElementById('since-field');
            // Show "Since" field only if the status is something other than "single"
            sinceField.style.display = (selectElement.value === 'married' || selectElement.value === 'divorced' || selectElement.value === 'widowed') ? 'block' : 'none';
        }
        
        // Automatically toggle since field on page load if value is already set
        document.addEventListener('DOMContentLoaded', function () {
            const maritalStatusElement = document.getElementById('marital_status');
            toggleSinceField(maritalStatusElement);

            // Dapatkan semua nav-link
            const navLinks = document.querySelectorAll('.nav-link');
            const tabPanes = document.querySelectorAll('.tab-pane');

            // Fungsi untuk mengaktifkan tab dan tab-panel
            function activateTab(target) {
                // Hapus kelas 'active' dan 'show' dari semua nav-link dan tab-pane
                navLinks.forEach(link => link.classList.remove('active'));
                tabPanes.forEach(pane => {
                    pane.classList.remove('active');
                    pane.classList.remove('show');
                });

                // Tambahkan kelas 'active' ke link dan panel yang sesuai
                const activeLink = document.querySelector(`a[href="${target}"]`);
                const activePane = document.querySelector(target);
                if (activeLink) activeLink.classList.add('active');
                if (activePane) {
                    activePane.classList.add('active');
                    activePane.classList.add('show');
                }
            }

            // Aktifkan tab berdasarkan hash di URL saat halaman dimuat
            const hash = window.location.hash;
            if (hash) {
                activateTab(hash);
            } else {
                // Aktifkan tab default jika tidak ada hash
                activateTab('#v-pills-personal');
            }

            // Tambahkan event listener pada setiap nav-link
            navLinks.forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault(); // Mencegah default anchor behavior
                    const target = this.getAttribute('href'); // Ambil href
                    window.location.hash = target; // Perbarui hash di URL
                    activateTab(target); // Aktifkan tab yang diklik
                });
            });
        });
    </script>
    {{-- CRUD JS --}}
    <script>
        $(document).ready(function () {
            function handleFormSubmission(formSelector, url, method = 'POST', overrideMethod = null) {
                $(formSelector).on('submit', function (e) {
                    e.preventDefault();

                    const form = $(this);
                    const formData = new FormData(this);

                    const headers = {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    };

                    if (overrideMethod) {
                        headers['X-HTTP-METHOD-OVERRIDE'] = overrideMethod;
                    }

                    fetch(url, {
                        method: method,
                        headers: headers,
                        body: formData,
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire("Success", data.success, "success")
                                    .then(() => location.reload());
                            } else {
                                Swal.fire("Error", data.error, "error");
                            }
                        })
                        .catch(() => Swal.fire("Error", "Something went wrong!", "error"));
                });
            }

            function handleDeleteAction(buttonSelector, urlTemplate) {
                $(document).on('click', buttonSelector, function () {
                    const id = $(this).data('id');
                    const url = urlTemplate.replace(':id', id);

                    Swal.fire({
                        title: "Are you sure?",
                        text: "You won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "Cancel",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(url, {
                                method: "DELETE",
                                headers: {
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                                },
                            })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire("Deleted!", "Your data has been deleted.", "success")
                                            .then(() => location.reload());
                                    }
                                });
                        }
                    });
                });
            }

            // Social Media
            handleFormSubmission('#createFormSosmed', "{{ route('social_media.store') }}");
            @foreach($socialMedia as $item)
                handleFormSubmission(`#editFormSosmed{{ $item->id }}`, `/social_media/{{ $item->id }}`, 'POST', 'PUT');
            @endforeach
            handleDeleteAction('#deleteFormSosmed', '/social_media/:id');

            // Size
            handleFormSubmission('#createFormSize', "{{ route('size.store') }}");
            @foreach($size as $item)
                handleFormSubmission(`#editFormSize{{ $item->id }}`, `/size/{{ $item->id }}`, 'POST', 'PUT');
            @endforeach
            handleDeleteAction('#deleteFormSize', '/size/:id');

            // Family
            handleFormSubmission('#createFormFamily', "{{ route('family.store') }}");
            @foreach($family as $item)
                handleFormSubmission(`#editFormFamily{{ $item->id }}`, `/family/{{ $item->id }}`, 'POST', 'PUT');
            @endforeach
            handleDeleteAction('#deleteFormFamily', '/family/:id');

            // Address
            handleFormSubmission('#createFormAddress', "{{ route('address.store') }}");
            @foreach($address as $item)
                handleFormSubmission(`#editFormAddress{{ $item->id }}`, `/address/{{ $item->id }}`, 'POST', 'PUT');
            @endforeach
            handleDeleteAction('#deleteFormAddress', '/address/:id');

            // Communication
            handleFormSubmission('#createFormCommunication', "{{ route('communication.store') }}");
            @foreach($communication as $item)
                handleFormSubmission(`#editFormCommunication{{ $item->id }}`, `/communication/{{ $item->id }}`, 'POST', 'PUT');
            @endforeach
            handleDeleteAction('#deleteFormCommunication', '/communication/:id');

            // Reference
            handleFormSubmission('#createFormReference', "{{ route('reference.store') }}");
            @foreach($reference as $item)
                handleFormSubmission(`#editFormReference{{ $item->id }}`, `/reference/{{ $item->id }}`, 'POST', 'PUT');
            @endforeach
            handleDeleteAction('#deleteFormReference', '/reference/:id');

            // Education
            handleFormSubmission('#createFormEducation', "{{ route('education.store') }}");
            @foreach($education as $item)
                handleFormSubmission(`#editFormEducation{{ $item->id }}`, `/education/{{ $item->id }}`, 'POST', 'PUT');
            @endforeach
            handleDeleteAction('#deleteFormEducation', '/education/:id');

            // Experience
            handleFormSubmission('#createFormExperience', "{{ route('experience.store') }}");
            @foreach($experience as $item)
                handleFormSubmission(`#editFormExperience{{ $item->id }}`, `/experience/{{ $item->id }}`, 'POST', 'PUT');
            @endforeach
            handleDeleteAction('#deleteFormExperience', '/experience/:id');

            // Language
            handleFormSubmission('#createFormLanguage', "{{ route('language.store') }}");
            @foreach($language as $item)
                handleFormSubmission(`#editFormLanguage{{ $item->id }}`, `/language/{{ $item->id }}`, 'POST', 'PUT');
            @endforeach
            handleDeleteAction('#deleteFormLanguage', '/language/:id');

            // Skill
            handleFormSubmission('#createFormSkill', "{{ route('skill.store') }}");
            @foreach($skill as $item)
                handleFormSubmission(`#editFormSkill{{ $item->id }}`, `/skill/{{ $item->id }}`, 'POST', 'PUT');
            @endforeach
            handleDeleteAction('#deleteFormSkill', '/skill/:id');

            // Bank
            handleFormSubmission('#createFormBank', "{{ route('bank.store') }}");
            @foreach($bank as $item)
                handleFormSubmission(`#editFormBank{{ $item->id }}`, `/bank/{{ $item->id }}`, 'POST', 'PUT');
            @endforeach
            handleDeleteAction('#deleteFormBank', '/bank/:id');

            // Tax
            handleFormSubmission('#createFormTax', "{{ route('tax.store') }}");
            @foreach($tax as $item)
                handleFormSubmission(`#editFormTax{{ $item->id }}`, `/tax/{{ $item->id }}`, 'POST', 'PUT');
            @endforeach
            handleDeleteAction('#deleteFormTax', '/tax/:id');

            // Document
            handleFormSubmission('#createFormDocument', "{{ route('document.store') }}");
            @foreach($document as $item)
                handleFormSubmission(`#editFormDocument{{ $item->id }}`, `/document/{{ $item->id }}`, 'POST', 'PUT');
            @endforeach
            handleDeleteAction('#deleteFormDocument', '/document/:id');

        });
    </script>

@endsection