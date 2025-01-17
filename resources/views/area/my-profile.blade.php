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
                                <div class="row">
                                    <!-- Column 1: Personal Information Section 1 -->
                                    <div class="col-lg-4">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Personal Information</h4>
                                            </div>
                                            <div class="card-body">
                                                <p><strong>NIK:</strong> {{ $personalInfo->nik }}</p>
                                                <p><strong>Title:</strong> {{ $personalInfo->title }}</p>
                                                <p><strong>First Name:</strong> {{ $personalInfo->first_name }}</p>
                                                <p><strong>Last Name:</strong> {{ $personalInfo->last_name }}</p>
                                                <p><strong>Known As:</strong> {{ $personalInfo->known_as }}</p>
                                                <p><strong>Gender:</strong> {{ $personalInfo->gender }}</p>
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <!-- Column 2: Personal Information Section 2 -->
                                    <div class="col-lg-4">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Additional Details</h4>
                                            </div>
                                            <div class="card-body">
                                                <p><strong>Date of Birth:</strong> {{ $personalInfo->date_of_birth->format('d-m-Y') }}</p>
                                                <p><strong>Place of Birth:</strong> {{ $personalInfo->place_of_birth }}</p>
                                                <p><strong>Country of Birth:</strong> {{ $personalInfo->country_of_birth }}</p>
                                                <p><strong>Marital Status:</strong> {{ $personalInfo->marital_status }}</p>
                                                <p><strong>Nationality:</strong> {{ $personalInfo->nationality }}</p>
                                                <p><strong>Language:</strong> {{ $personalInfo->language }}</p>
                                                <p><strong>Religion:</strong> {{ $personalInfo->religion }}</p>
                                                <p><strong>Ethnic:</strong> {{ $personalInfo->ethnic }}</p>
                                                <p><strong>Blood Type:</strong> {{ $personalInfo->blood_type }}</p>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <!-- Column 3: Profile Photo -->
                                    <div class="col-lg-4">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Profile Photo (Full Body)</h4>
                                            </div>
                                            
                                            <div class="card-body text-center">
                                                @if(!empty($personalInfo->profile_photo))
                                                <img src="{{ asset('upload/'.$personalInfo->profile_photo) }}" alt="Profile Photo"
                                                     class="rounded" style="width: 50%; height: auto; object-fit: cover; border: 2px solid #ccc;">
                                                @else
                                                <img src="{{ asset('upload/profile/unnamed.jpg') }}" alt="Profile Photo"
                                                     class="rounded" style="width: 100%; height: auto; object-fit: cover; border: 2px solid #ccc;">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4 class="card-title">Social Media</h4>
                                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#createModalSosmed">Create</button>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Actions</th>
                                                            <th>Platform</th>
                                                            <th>Username</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($socialMedia as $item)
                                                        <tr>
                                                            <td>
                                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModalSosmed{{ $item->id }}">Edit</button>
                                                                <button class="btn btn-danger btn-sm" onclick="deleteSocialMedia({{ $item->id }})">Delete</button>
                                                            </td>
                                                            <td>{{ $item->platform }}</td>
                                                            <td>{{ $item->username }}</td>
                                                        </tr>
                                
                                                        <!-- Edit Modal -->
                                                        <div class="modal fade" id="editModalSosmed{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <form id="editFormSosmed{{ $item->id }}">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Edit Social Media</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="mb-3">
                                                                                <label>Platform</label>
                                                                                <input type="text" name="platform" class="form-control" value="{{ $item->platform }}" readonly>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label>Username</label>
                                                                                <input type="text" name="username" class="form-control" value="{{ $item->username }}" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4 class="card-title">Family</h4>
                                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#createModalFamily">Create</button>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Actions</th>
                                                            <th>Relation</th>
                                                            <th>Name</th>
                                                            <th>Gender (M/F)</th>
                                                            <th>Birthplace</th>
                                                            <th>Date of Birth</th>
                                                            <th>Country of Birth</th>
                                                            <th>Nationality</th>
                                                            <th>Job Title</th>
                                                            <th>Employer</th>
                                                            <th>Employer Type</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($family as $item)
                                                        <tr>
                                                            <td>
                                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModalFamily{{ $item->id }}">Edit</button>
                                                                <button class="btn btn-danger btn-sm" onclick="deleteFamily({{ $item->id }})">Delete</button>
                                                            </td>
                                                            <td>{{ $item->members }}</td>
                                                            <td>{{ $item->name }}</td>
                                                            <td>{{ $item->gender }}</td>
                                                            <td>{{ $item->birth_place }}</td>
                                                            <td>{{ date_format(date_create($item->date_of_birth),'d-m-Y') }}</td>
                                                            <td>{{ $item->country_of_birth }}</td>
                                                            <td>{{ $item->nationality }}</td>
                                                            <td>{{ $item->job_title }}</td>
                                                            <td>{{ $item->employer }}</td>
                                                            <td>{{ $item->employer_type }}</td>
                                                        </tr>
                                
                                                        <!-- Edit Modal -->
                                                        <div class="modal fade" id="editModalFamily{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <form id="editFormFamily{{ $item->id }}">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Edit Family</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="mb-3">
                                                                                <label>Relation</label>
                                                                                <input type="text" name="members" class="form-control" value="{{ $item->members }}" readonly>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label>Name</label>
                                                                                <input type="text" name="name" class="form-control" value="{{ $item->name }}" required>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label>Gender (M/F)</label>
                                                                                <select class="form-control" id="gender" name="gender" required>
                                                                                    <option value="">- Select -</option>
                                                                                    <option value="M" {{ $item->gender == 'M' ? 'selected' : '' }}>Male</option>
                                                                                    <option value="F" {{ $item->gender == 'F' ? 'selected' : '' }}>Female</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label>Birthplace</label>
                                                                                <input type="text" name="birth_place" class="form-control" value="{{ $item->birth_place }}" required>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label>Date of Birth</label>
                                                                                <input type="date" name="date_of_birth" class="form-control" value="{{ $item->date_of_birth }}" required>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label>Country of Birth</label>
                                                                                <select class="form-control" id="country_of_birth" name="country_of_birth" required>
                                                                                    <option value="">- Select -</option>
                                                                                    <option value="Indonesia" {{ $personalInfo->country_of_birth == 'Indonesia' ? 'selected' : '' }}>Indonesia</option>
                                                                                    <option value="United States" {{ $personalInfo->country_of_birth == 'United States' ? 'selected' : '' }}>United States</option>
                                                                                    <option value="United Kingdom" {{ $personalInfo->country_of_birth == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                                                                                    <option value="Canada" {{ $personalInfo->country_of_birth == 'Canada' ? 'selected' : '' }}>Canada</option>
                                                                                    <option value="Australia" {{ $personalInfo->country_of_birth == 'Australia' ? 'selected' : '' }}>Australia</option>
                                                                                    <option value="Germany" {{ $personalInfo->country_of_birth == 'Germany' ? 'selected' : '' }}>Germany</option>
                                                                                    <option value="France" {{ $personalInfo->country_of_birth == 'France' ? 'selected' : '' }}>France</option>
                                                                                    <option value="Japan" {{ $personalInfo->country_of_birth == 'Japan' ? 'selected' : '' }}>Japan</option>
                                                                                    <option value="China" {{ $personalInfo->country_of_birth == 'China' ? 'selected' : '' }}>China</option>
                                                                                    <option value="India" {{ $personalInfo->country_of_birth == 'India' ? 'selected' : '' }}>India</option>
                                                                                    <option value="Brazil" {{ $personalInfo->country_of_birth == 'Brazil' ? 'selected' : '' }}>Brazil</option>
                                                                                    <option value="South Africa" {{ $personalInfo->country_of_birth == 'South Africa' ? 'selected' : '' }}>South Africa</option>
                                                                                    <option value="others" {{ $personalInfo->country_of_birth == 'others' ? 'selected' : '' }}>Others</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label>Nationality</label>
                                                                                <select class="form-control" id="nationality" name="nationality" required>
                                                                                    <option value="">- Select -</option>
                                                                                    <option value="Indonesia" {{ $personalInfo->nationality == 'Indonesia' ? 'selected' : '' }}>Indonesia</option>
                                                                                    <option value="United States" {{ $personalInfo->nationality == 'United States' ? 'selected' : '' }}>United States</option>
                                                                                    <option value="United Kingdom" {{ $personalInfo->nationality == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                                                                                    <option value="Canada" {{ $personalInfo->nationality == 'Canada' ? 'selected' : '' }}>Canada</option>
                                                                                    <option value="Australia" {{ $personalInfo->nationality == 'Australia' ? 'selected' : '' }}>Australia</option>
                                                                                    <option value="Germany" {{ $personalInfo->nationality == 'Germany' ? 'selected' : '' }}>Germany</option>
                                                                                    <option value="France" {{ $personalInfo->nationality == 'France' ? 'selected' : '' }}>France</option>
                                                                                    <option value="Japan" {{ $personalInfo->nationality == 'Japan' ? 'selected' : '' }}>Japan</option>
                                                                                    <option value="China" {{ $personalInfo->nationality == 'China' ? 'selected' : '' }}>China</option>
                                                                                    <option value="India" {{ $personalInfo->nationality == 'India' ? 'selected' : '' }}>India</option>
                                                                                    <option value="Brazil" {{ $personalInfo->nationality == 'Brazil' ? 'selected' : '' }}>Brazil</option>
                                                                                    <option value="South Africa" {{ $personalInfo->nationality == 'South Africa' ? 'selected' : '' }}>South Africa</option>
                                                                                    <option value="others" {{ $personalInfo->nationality == 'others' ? 'selected' : '' }}>Others</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label>Job Title</label>
                                                                                <input type="text" name="job_title" class="form-control" value="{{ $item->job_title }}">
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label>Employer</label>
                                                                                <input type="text" name="employer" class="form-control" value="{{ $item->employer }}">
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label>Employer Type</label>
                                                                                <input type="text" name="employer_type" class="form-control" value="{{ $item->employer_type }}" placeholder="Public Sector, Healthcare Providers, Military and Defense">
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4 class="card-title">Size</h4>
                                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#createModalSize">Create</button>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Actions</th>
                                                            <th>Height</th>
                                                            <th>Weight</th>
                                                            <th>Clothing Size</th>
                                                            <th>Pants Size</th>
                                                            <th>Shoe Size</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($size as $item)
                                                        <tr>
                                                            <td>
                                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModalSize{{ $item->id }}">Edit</button>
                                                                <button class="btn btn-danger btn-sm" onclick="deleteSize({{ $item->id }})">Delete</button>
                                                            </td>
                                                            <td>{{ $item->height }}</td>
                                                            <td>{{ $item->weight }}</td>
                                                            <td>{{ $item->clothing_size }}</td>
                                                            <td>{{ $item->pants_size }}</td>
                                                            <td>{{ $item->shoe_size }}</td>
                                                        </tr>
                                
                                                        <!-- Edit Modal -->
                                                        <div class="modal fade" id="editModalSize{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <form id="editFormSize{{ $item->id }}">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Edit Size</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="mb-3">
                                                                                <label>Height</label>
                                                                                <input type="text" name="height" class="form-control" value="{{ $item->height }}" required>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label>Weight</label>
                                                                                <input type="text" name="weight" class="form-control" value="{{ $item->weight }}" required>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label>Clothing Size</label>
                                                                                <input type="text" name="clothing_size" class="form-control" value="{{ $item->clothing_size }}" required>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label>Pants Size</label>
                                                                                <input type="text" name="pants_size" class="form-control" value="{{ $item->pants_size }}" required>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label>Shoe Size</label>
                                                                                <input type="text" name="shoe_size" class="form-control" value="{{ $item->shoe_size }}" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="tab-pane fade" id="v-pills-contact" role="tabpanel"
                                aria-labelledby="v-pills-contact-tab">
                                <h5>Contact Information</h5>

                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4 class="card-title">Address</h4>
                                            <button type="button" class="btn btn-sm btn-success">Create</button>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Actions</th>
                                                            <th>Address Type</th>
                                                            <th>Street and House Number</th>
                                                            <th>City</th>
                                                            <th>Postal Code</th>
                                                            <th>Country</th>
                                                            <th>Tel. Number</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><button class="btn btn-primary btn-sm">Edit</button> <button class="btn btn-danger btn-sm">Delete</button></td>
                                                            <td>Home</td>
                                                            <td>123 Main St.</td>
                                                            <td>Jakarta</td>
                                                            <td>10001</td>
                                                            <td>Indonesia</td>
                                                            <td>08123456789</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4 class="card-title">Communication</h4>
                                            <button type="button" class="btn btn-sm btn-success">Create</button>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Actions</th>
                                                            <th>Type</th>
                                                            <th>Number</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><button class="btn btn-primary btn-sm">Edit</button> <button class="btn btn-danger btn-sm">Delete</button></td>
                                                            <td>Mobile</td>
                                                            <td>08123456789</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4 class="card-title">Reference</h4>
                                            <button type="button" class="btn btn-sm btn-success">Create</button>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Actions</th>
                                                            <th>Relations</th>
                                                            <th>Number</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><button class="btn btn-primary btn-sm">Edit</button> <button class="btn btn-danger btn-sm">Delete</button></td>
                                                            <td>Superior</td>
                                                            <td>08123456789</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="v-pills-professional" role="tabpanel"
                                aria-labelledby="v-pills-professional-tab">
                                <h5>Professional Information</h5>   

                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4 class="card-title">Education</h4>
                                            <button type="button" class="btn btn-sm btn-success">Create</button>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Actions</th>
                                                            <th>Start Date</th>
                                                            <th>End Date</th>
                                                            <th>Education Establishment</th>
                                                            <th>Institute / Location</th>
                                                            <th>Country</th>
                                                            <th>Certificate</th>
                                                            <th>Duration Year/Month/Day</th>
                                                            <th>Branch of Study 1 (Major)</th>
                                                            <th>Branch of Study (Major/Minor)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><button class="btn btn-primary btn-sm">Edit</button> <button class="btn btn-danger btn-sm">Delete</button></td>
                                                            <td>01/09/2009</td>
                                                            <td>31/05/2013</td>
                                                            <td>University XYZ</td>
                                                            <td>Jakarta</td>
                                                            <td>Indonesia</td>
                                                            <td>Bachelor</td>
                                                            <td>4 Years</td>
                                                            <td>Computer Science</td>
                                                            <td>(Major)</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4 class="card-title">Experience</h4>
                                            <button type="button" class="btn btn-sm btn-success">Create</button>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Actions</th>
                                                            <th>Start Date</th>
                                                            <th>End Date</th>
                                                            <th>Company</th>
                                                            <th>Industry Type</th>
                                                            <th>City/Country</th>
                                                            <th>Last Position Held</th>
                                                            <th>Name of Superior</th>
                                                            <th>Designation of Superior</th>
                                                            <th>Last Drawn Salary</th>
                                                            <th>Reason for Leaving</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><button class="btn btn-primary btn-sm">Edit</button> <button class="btn btn-danger btn-sm">Delete</button></td>
                                                            <td>01/06/2015</td>
                                                            <td>31/12/2020</td>
                                                            <td>PT. ABC</td>
                                                            <td>Software</td>
                                                            <td>Jakarta/Indonesia</td>
                                                            <td>Software Engineer</td>
                                                            <td>Mr. Lee</td>
                                                            <td>Manager</td>
                                                            <td>$5000</td>
                                                            <td>Career Growth</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4 class="card-title">Qualification Skills</h4>
                                            <button type="button" class="btn btn-sm btn-success">Create</button>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Actions</th>
                                                            <th>Language/Skills</th>
                                                            <th>Read</th>
                                                            <th>Write</th>
                                                            <th>Speak</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><button class="btn btn-primary btn-sm">Edit</button> <button class="btn btn-danger btn-sm">Delete</button></td>
                                                            <td>English</td>
                                                            <td>Fluently</td>
                                                            <td>Fluently</td>
                                                            <td>Fluently</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="tab-pane fade" id="v-pills-documents" role="tabpanel"
                                aria-labelledby="v-pills-documents-tab">

                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4 class="card-title">Bank Details</h4>
                                            <button type="button" class="btn btn-sm btn-success">Create</button>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Actions</th>
                                                            <th>Payee</th>
                                                            <th>Bank Country</th>
                                                            <th>Bank Name</th>
                                                            <th>Bank Key/Branch/Address</th>
                                                            <th>Bank Account Number</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><button class="btn btn-primary btn-sm">Edit</button></td>
                                                            <td>John Doe</td>
                                                            <td>Indonesia</td>
                                                            <td>Bank Indonesia</td>
                                                            <td>Jakarta Branch</td>
                                                            <td>123456789</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4 class="card-title">Tax Information</h4>
                                            <button type="button" class="btn btn-sm btn-success">Create</button>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Actions</th>
                                                            <th>Personal Tax ID (NPWP)</th>
                                                            <th>Registered Date</th>
                                                            <th>NPWP Address</th>
                                                            <th>Married for Tax Purpose</th>
                                                            <th>Spouse Benefit</th>
                                                            <th>Number of Dependents</th>
                                                            <th>Identification Number</th>
                                                            <th>BPJS ID</th>
                                                            <th>Benefit Class</th>
                                                            <th>Number of Dependents</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><button class="btn btn-primary btn-sm">Edit</button></td>
                                                            <td>1234567890</td>
                                                            <td>01/01/2014</td>
                                                            <td>123 Tax St., Jakarta</td>
                                                            <td>Yes</td>
                                                            <td>Yes</td>
                                                            <td>2</td>
                                                            <td>ID123456789</td>
                                                            <td>BPJS12345</td>
                                                            <td>1</td>
                                                            <td>2</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
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
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end card -->
        </div>
    </div>
</div>

{{-- modal section --}}
<!-- Modal for Editing Personal Data -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('my-profile.update', $personalInfo->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Personal Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6><strong>Basic Information</strong></h6>
                            <div class="mb-3">
                                <label for="nik" class="form-label">NIK</label>
                                <input type="text" class="form-control" id="nik" name="nik" value="{{ $personalInfo->nik }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ $personalInfo->title }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $personalInfo->first_name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $personalInfo->last_name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="known_as" class="form-label">Known As</label>
                                <input type="text" class="form-control" id="known_as" name="known_as" value="{{ $personalInfo->known_as }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="">- Select -</option>
                                    <option value="male" {{ $personalInfo->gender == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ $personalInfo->gender == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6><strong>Additional Information</strong></h6>
                            <div class="mb-3">
                                <label for="date_of_birth" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ $personalInfo->date_of_birth->format('Y-m-d') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="place_of_birth" class="form-label">Place of Birth</label>
                                <input type="text" class="form-control" id="place_of_birth" name="place_of_birth" value="{{ $personalInfo->place_of_birth }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="country_of_birth" class="form-label">Country of Birth</label>
                                <select class="form-control" id="country_of_birth" name="country_of_birth" required>
                                    <option value="">- Select -</option>
                                    <option value="Indonesia" {{ $personalInfo->country_of_birth == 'Indonesia' ? 'selected' : '' }}>Indonesia</option>
                                    <option value="United States" {{ $personalInfo->country_of_birth == 'United States' ? 'selected' : '' }}>United States</option>
                                    <option value="United Kingdom" {{ $personalInfo->country_of_birth == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                                    <option value="Canada" {{ $personalInfo->country_of_birth == 'Canada' ? 'selected' : '' }}>Canada</option>
                                    <option value="Australia" {{ $personalInfo->country_of_birth == 'Australia' ? 'selected' : '' }}>Australia</option>
                                    <option value="Germany" {{ $personalInfo->country_of_birth == 'Germany' ? 'selected' : '' }}>Germany</option>
                                    <option value="France" {{ $personalInfo->country_of_birth == 'France' ? 'selected' : '' }}>France</option>
                                    <option value="Japan" {{ $personalInfo->country_of_birth == 'Japan' ? 'selected' : '' }}>Japan</option>
                                    <option value="China" {{ $personalInfo->country_of_birth == 'China' ? 'selected' : '' }}>China</option>
                                    <option value="India" {{ $personalInfo->country_of_birth == 'India' ? 'selected' : '' }}>India</option>
                                    <option value="Brazil" {{ $personalInfo->country_of_birth == 'Brazil' ? 'selected' : '' }}>Brazil</option>
                                    <option value="South Africa" {{ $personalInfo->country_of_birth == 'South Africa' ? 'selected' : '' }}>South Africa</option>
                                    <option value="others" {{ $personalInfo->country_of_birth == 'others' ? 'selected' : '' }}>Others</option>
                                    <!-- Add more countries as needed -->
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="marital_status" class="form-label">Status</label>
                                        <select class="form-control" id="marital_status" name="marital_status" onchange="toggleSinceField(this)" required>
                                            <option value="">- Select -</option>
                                            <option value="single" {{ $personalInfo->marital_status == 'single' ? 'selected' : '' }}>Single</option>
                                            <option value="married" {{ $personalInfo->marital_status == 'married' ? 'selected' : '' }}>Married</option>
                                            <option value="divorced" {{ $personalInfo->marital_status == 'divorced' ? 'selected' : '' }}>Divorced</option>
                                            <option value="widowed" {{ $personalInfo->marital_status == 'widowed' ? 'selected' : '' }}>Widowed</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6" id="since-field" style="display: none;">
                                    <div class="mb-3">
                                        <label for="since" class="form-label">Since</label>
                                        <input type="number" class="form-control" id="since" name="since" value="{{ $personalInfo->since }}">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="nationality" class="form-label">Nationality</label>
                                <select class="form-control" id="nationality" name="nationality" required>
                                    <option value="">- Select -</option>
                                    <option value="Indonesia" {{ $personalInfo->nationality == 'Indonesia' ? 'selected' : '' }}>Indonesia</option>
                                    <option value="United States" {{ $personalInfo->nationality == 'United States' ? 'selected' : '' }}>United States</option>
                                    <option value="United Kingdom" {{ $personalInfo->nationality == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                                    <option value="Canada" {{ $personalInfo->nationality == 'Canada' ? 'selected' : '' }}>Canada</option>
                                    <option value="Australia" {{ $personalInfo->nationality == 'Australia' ? 'selected' : '' }}>Australia</option>
                                    <option value="Germany" {{ $personalInfo->nationality == 'Germany' ? 'selected' : '' }}>Germany</option>
                                    <option value="France" {{ $personalInfo->nationality == 'France' ? 'selected' : '' }}>France</option>
                                    <option value="Japan" {{ $personalInfo->nationality == 'Japan' ? 'selected' : '' }}>Japan</option>
                                    <option value="China" {{ $personalInfo->nationality == 'China' ? 'selected' : '' }}>China</option>
                                    <option value="India" {{ $personalInfo->nationality == 'India' ? 'selected' : '' }}>India</option>
                                    <option value="Brazil" {{ $personalInfo->nationality == 'Brazil' ? 'selected' : '' }}>Brazil</option>
                                    <option value="South Africa" {{ $personalInfo->nationality == 'South Africa' ? 'selected' : '' }}>South Africa</option>
                                    <option value="others" {{ $personalInfo->nationality == 'others' ? 'selected' : '' }}>Others</option>
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <h6><strong>Language & Religion</strong></h6>
                            <div class="mb-3">
                                <label for="language" class="form-label">Language</label>
                                {{-- <input type="text" class="form-control" id="language" name="language" value="{{ $personalInfo->language }}" required> --}}
                                <select class="form-control" id="language" name="language" required>
                                    <option value="">- Select -</option>
                                    <option value="Bahasa" {{ $personalInfo->language == 'Bahasa' ? 'selected' : '' }}>Bahasa</option>
                                    <option value="English" {{ $personalInfo->language == 'English' ? 'selected' : '' }}>English</option>
                                    <option value="Spanish" {{ $personalInfo->language == 'Spanish' ? 'selected' : '' }}>Spanish</option>
                                    <option value="French" {{ $personalInfo->language == 'French' ? 'selected' : '' }}>French</option>
                                    <option value="German" {{ $personalInfo->language == 'German' ? 'selected' : '' }}>German</option>
                                    <option value="Mandarin" {{ $personalInfo->language == 'Mandarin' ? 'selected' : '' }}>Mandarin</option>
                                    <option value="Japanese" {{ $personalInfo->language == 'Japanese' ? 'selected' : '' }}>Japanese</option>
                                    <option value="Arabic" {{ $personalInfo->language == 'Arabic' ? 'selected' : '' }}>Arabic</option>
                                    <!-- Add more languages as needed -->
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="religion" class="form-label">Religion</label>
                                {{-- <input type="text" class="form-control" id="religion" name="religion" value="{{ $personalInfo->religion }}" required> --}}
                                <select class="form-control" id="religion" name="religion" required>
                                    <option value="">- Select -</option>
                                    <option value="Islam" {{ $personalInfo->religion == 'Islam' ? 'selected' : '' }}>Islam</option>
                                    <option value="Christianity" {{ $personalInfo->religion == 'Christianity' ? 'selected' : '' }}>Christianity</option>
                                    <option value="Hinduism" {{ $personalInfo->religion == 'Hinduism' ? 'selected' : '' }}>Hinduism</option>
                                    <option value="Buddhism" {{ $personalInfo->religion == 'Buddhism' ? 'selected' : '' }}>Buddhism</option>
                                    <option value="Confucianism" {{ $personalInfo->religion == 'Confucianism' ? 'selected' : '' }}>Confucianism</option>
                                    <option value="Others" {{ $personalInfo->religion == 'Others' ? 'selected' : '' }}>Others</option>
                                    <!-- Add more religions if necessary -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6><strong>Miscellaneous</strong></h6>
                            <div class="mb-3">
                                <label for="ethnic" class="form-label">Ethnic</label>
                                {{-- <input type="text" class="form-control" id="ethnic" name="ethnic" value="{{ $personalInfo->ethnic }}"> --}}
                                <select class="form-control" id="ethnic" name="ethnic" required>
                                    <option value="">- Select -</option>
                                    <option value="Acehnese" {{ $personalInfo->ethnic == 'Acehnese' ? 'selected' : '' }}>Acehnese</option>
                                    <option value="Balinese" {{ $personalInfo->ethnic == 'Balinese' ? 'selected' : '' }}>Balinese</option>
                                    <option value="Banjarese" {{ $personalInfo->ethnic == 'Banjarese' ? 'selected' : '' }}>Banjarese</option>
                                    <option value="Banten" {{ $personalInfo->ethnic == 'Banten' ? 'selected' : '' }}>Banten</option>
                                    <option value="Batak" {{ $personalInfo->ethnic == 'Batak' ? 'selected' : '' }}>Batak</option>
                                    <option value="Betawi" {{ $personalInfo->ethnic == 'Betawi' ? 'selected' : '' }}>Betawi</option>
                                    <option value="Bugis" {{ $personalInfo->ethnic == 'Bugis' ? 'selected' : '' }}>Bugis</option>
                                    <option value="Chinese" {{ $personalInfo->ethnic == 'Chinese' ? 'selected' : '' }}>Chinese</option>
                                    <option value="Dayak" {{ $personalInfo->ethnic == 'Dayak' ? 'selected' : '' }}>Dayak</option>
                                    <option value="Javanese" {{ $personalInfo->ethnic == 'Javanese' ? 'selected' : '' }}>Javanese</option>
                                    <option value="Madurese" {{ $personalInfo->ethnic == 'Madurese' ? 'selected' : '' }}>Madurese</option>
                                    <option value="Minangkabau" {{ $personalInfo->ethnic == 'Minangkabau' ? 'selected' : '' }}>Minangkabau</option>
                                    <option value="Sasak" {{ $personalInfo->ethnic == 'Sasak' ? 'selected' : '' }}>Sasak</option>
                                    <option value="Sundanese" {{ $personalInfo->ethnic == 'Sundanese' ? 'selected' : '' }}>Sundanese</option>
                                    <option value="Toba" {{ $personalInfo->ethnic == 'Toba' ? 'selected' : '' }}>Toba</option>
                                    <option value="Others" {{ $personalInfo->ethnic == 'Others' ? 'selected' : '' }}>Others</option>
                                    <!-- Add more ethnicities as needed -->
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="blood_type" class="form-label">Blood Type</label>
                                {{-- <input type="text" class="form-control" id="blood_type" name="blood_type" value="{{ $personalInfo->blood_type }}" required> --}}
                                <select class="form-control" id="blood_type" name="blood_type" required>
                                    <option value="">- Select -</option>
                                    <option value="A" {{ $personalInfo->blood_type == 'A' ? 'selected' : '' }}>A</option>
                                    <option value="B" {{ $personalInfo->blood_type == 'B' ? 'selected' : '' }}>B</option>
                                    <option value="AB" {{ $personalInfo->blood_type == 'AB' ? 'selected' : '' }}>AB</option>
                                    <option value="O" {{ $personalInfo->blood_type == 'O' ? 'selected' : '' }}>O</option>
                                    <!-- Add more blood types if necessary -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6><strong>Profile Photo (Full Body)</strong></h6>
                            <div class="mb-3">
                                <label for="profile_photo" class="form-label">Upload New Photo</label>

                                <!-- Pratinjau foto jika sudah ada -->
                                @if(!empty($personalInfo->profile_photo))
                                    <div class="mb-2">
                                        <img src="{{ asset('upload/' . $personalInfo->profile_photo) }}" alt="Profile Photo" class="img-thumbnail" style="max-width: 150px;">
                                    </div>
                                @endif

                                {{-- <input type="file" class="form-control" id="profile_photo" name="profile_photo" accept="image/*"> --}}
                                <input type="file" class="form-control" id="profile_photo" name="profile_photo" accept="image/*" {{ empty($personalInfo->profile_photo) ? 'required' : '' }}>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Create Modal Sosmed-->
<div class="modal fade" id="createModalSosmed" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="createFormSosmed">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Social Media</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Platform</label>
                        <select class="form-control" id="platform" name="platform" required>
                            <option value="">- Select -</option>
                            <option value="Linkedin">Linkedin</option>
                            <option value="Instagram">Instagram</option>
                            <option value="Facebook">Facebook</option>
                            <option value="Github">Github</option>
                            <option value="xTwitter">xTwitter</option>
                            <!-- Add more countries as needed -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Create</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Create Modal Family -->
<div class="modal fade" id="createModalFamily" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="createFormFamily">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Family Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Relation</label>
                        <select name="members" class="form-control" required>
                            <option value="">- Select -</option>
                            <option value="Father">Father</option>
                            <option value="Mother">Mother</option>
                            <option value="Spouse">Spouse</option>
                            <option value="Child">Child</option>
                            <option value="Sibling">Sibling</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Gender (M/F)</label>
                        <select name="gender" class="form-control" required>
                            <option value="">- Select -</option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Birthplace</label>
                        <input type="text" name="birth_place" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Date of Birth</label>
                        <input type="date" name="date_of_birth" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Country of Birth</label>
                        <select class="form-control" id="country_of_birth" name="country_of_birth" required>
                            <option value="">- Select -</option>
                            <option value="Indonesia" selected>Indonesia</option>
                            <option value="United States">United States</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="Canada">Canada</option>
                            <option value="Australia">Australia</option>
                            <option value="Germany">Germany</option>
                            <option value="France">France</option>
                            <option value="Japan">Japan</option>
                            <option value="China">China</option>
                            <option value="India">India</option>
                            <option value="Brazil">Brazil</option>
                            <option value="South Africa">South Africa</option>
                            <option value="others">Others</option>
                            <!-- Add more countries as needed -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Nationality</label>
                        <select class="form-control" id="nationality" name="nationality" required>
                            <option value="">- Select -</option>
                            <option value="Indonesia" selected>Indonesia</option>
                            <option value="United States">United States</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="Canada">Canada</option>
                            <option value="Australia">Australia</option>
                            <option value="Germany">Germany</option>
                            <option value="France">France</option>
                            <option value="Japan">Japan</option>
                            <option value="China">China</option>
                            <option value="India">India</option>
                            <option value="Brazil">Brazil</option>
                            <option value="South Africa">South Africa</option>
                            <option value="others">Others</option>
                            <!-- Add more countries as needed -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Job Title</label>
                        <input type="text" name="job_title" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Employer</label>
                        <input type="text" name="employer" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Employer Type</label>
                        <input type="text" name="employer_type" class="form-control" placeholder="Public Sector, Healthcare Providers, Military and Defense">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Create</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Create Modal Size-->
<div class="modal fade" id="createModalSize" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="createFormSize">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Size</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Height</label>
                        <input type="number" name="height" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Weight</label>
                        <input type="number" name="weight" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Clothing Size</label>
                        <input type="number" name="clothing_size" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Pants Size</label>
                        <input type="number" name="pants_size" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Shoe Size</label>
                        <input type="number" name="shoe_size" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Create</button>
                </div>
            </div>
        </form>
    </div>
</div>


@endsection

@section('script')
<!-- Add any specific JS you need here -->
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
{{-- main-my-profile-socialmedia.js --}}
<script>
    // Handle Create Form Submission
    document.getElementById('createFormSosmed').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);

        fetch("{{ route('social_media.store') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
            },
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

    // Handle Edit Form Submission
    @foreach($socialMedia as $item)
    document.getElementById('editFormSosmed{{ $item->id }}').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);

        fetch(`/social_media/{{ $item->id }}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                'X-HTTP-METHOD-OVERRIDE': 'PUT',
            },
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
    @endforeach

    function deleteSocialMedia(id) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/social_media/${id}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
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
    }
</script>
{{-- main-my-profile-size.js --}}
<script>
    // Handle Create Form Submission
    document.getElementById('createFormSize').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);

        fetch("{{ route('size.store') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
            },
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

    // Handle Edit Form Submission
    @foreach($size as $item)
    document.getElementById('editFormSize{{ $item->id }}').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);

        fetch(`/size/{{ $item->id }}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                'X-HTTP-METHOD-OVERRIDE': 'PUT',
            },
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
    @endforeach

    function deleteSize(id) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/size/${id}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
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
    }
</script>
{{-- main-my-profile-family.js --}}
<script>
    // Handle Create Form Submission
    document.getElementById('createFormFamily').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);

        fetch("{{ route('family.store') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
            },
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

    // Handle Edit Form Submission
    @foreach($family as $item)
    document.getElementById('editFormFamily{{ $item->id }}').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);

        fetch(`/family/{{ $item->id }}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                'X-HTTP-METHOD-OVERRIDE': 'PUT',
            },
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
    @endforeach

    function deleteFamily(id) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/family/${id}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
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
    }
</script>
@endsection