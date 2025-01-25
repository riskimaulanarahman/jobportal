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
