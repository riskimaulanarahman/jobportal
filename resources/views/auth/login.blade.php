@extends('layouts.master-without-nav')
@section('title')
@lang('translation.Login')
@endsection
@section('content')

        <div class="auth-page">
            <div class="container-fluid p-0">
                <div class="row g-0 align-items-center">
                    <div class="col-xxl-4 col-lg-4 col-md-6">
                        <div class="row justify-content-center g-0">
                            <div class="col-xl-9">
                                <div class="p-4">
                                    <div class="mb-4 mb-md-4">
                                        <a href="index" class="d-block auth-logo">
                                            <img src="{{ URL::asset('assets/images/logo-ihm.png') }}" alt="" height="50"
                                                class="auth-logo-dark me-start">
                                        </a>
                                    </div>
                                    <div class="card mb-0">
                                        <div class="card-body">
                                            <div class="auth-full-page-content rounded d-flex p-3 my-2">
                                                <div class="w-100">
                                                    <div class="d-flex flex-column h-100">
                                                        
                                                        <div class="mb-4 mb-md-1">
                                                            <a href="{{ url('/') }}" class="d-block auth-logo">
                                                                <center><b style="font-size: 30px;">{{ env('APP_NAME') }}</b></center>
                                                            </a>
                                                        </div>
                                                        <div class="auth-content my-auto">
                                                            <div class="text-center">
                                                                <p class="text-muted mt-2">Sign in to continue.</p>
                                                            </div>
                                                            <form class="mt-4 pt-2" id="loginForm" action="{{ route('login') }}" method="POST">
                                                                @csrf
                                                                <div class="form-floating form-floating-custom mb-4">
                                                                    <input type="text" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" id="input-username" placeholder="Enter User Name" name="username">
                                                                    @error('username')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <label for="input-username">Username</label>
                                                                    <div class="form-floating-icon">
                                                                        <i data-eva="people-outline"></i>
                                                                    </div>
                                                                </div>

                                                                <div class="form-floating form-floating-custom mb-4 auth-pass-inputgroup">
                                                                    <input type="password" class="form-control pe-5 @error('password') is-invalid @enderror" name="password" id="password-input" placeholder="Enter Password">
                                                                    @error('password')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <button type="button" class="btn btn-link position-absolute h-100 end-0 top-0" id="password-addon">
                                                                        <i class="mdi mdi-eye-outline font-size-18 text-muted"></i>
                                                                    </button>
                                                                    <label for="input-password">Password</label>
                                                                    <div class="form-floating-icon">
                                                                        <i data-feather="lock"></i>
                                                                    </div>
                                                                    {{-- <div id="capslock-indicator" style="display: none; color: red;">Caps Lock is ON</div> --}}
                                                                </div>

                                                                <div id="capslock-indicator-on">
                                                                    <i class="mdi mdi-lock-open-outline"></i>
                                                                    <p>Caps Lock is ON</p>
                                                                </div>
                                                                <div id="capslock-indicator-off">
                                                                    <i class="mdi mdi-lock-outline"></i>
                                                                    <p>Caps Lock is OFF</p>
                                                                </div>

                                                                <div class="d-flex justify-content-center mb-3">
                                                                    <button class="btn btn-success w-50 mx-2 waves-effect waves-light" type="button" onclick="formSubmit()">Sign In</button>
                                                                    <button class="btn btn-primary w-50 mx-2 waves-effect waves-light" type="button" data-bs-toggle="modal" data-bs-target="#registerModal">Register</button>
                                                                </div>
                                                                @if(session('error'))
                                                                    <div class="alert alert-danger">
                                                                        {{ session('error') }}
                                                                    </div>
                                                                @endif
                                                            </form>
                                                        </div>
                                                        <div class="mt-1 text-center">
                                                            {{-- <button id="downloadBtn" class="btn btn-danger" data-bs-toggle="modal"
                                                                    data-bs-target=".bs-modal-panduan"><i class="fa fa-download"></i> Download Panduan <i class="fa fa-download"></i></button> --}}
                                                            <p class="mb-0 mt-4"><b>© <script>document.write(new Date().getFullYear())</script> {{ env('APP_NAME') }} </b>. Crafted with <i class="mdi mdi-heart text-danger"></i><br>by <b>{{ env('APP_AUTHOR') }}</b></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end auth full page content -->
                    </div>
                    <!-- end col -->
                    <div class="col-xxl-8 col-lg-8 col-md-6">
                        <div class="auth-bg bg-white py-md-5 p-4 d-flex">
                            <div class="bg-overlay bg-white"></div>
                            <!-- end bubble effect -->
                            <div class="row justify-content-center align-items-center">
                                <div class="col-xl-8">
                                    <div class="mt-4">
                                        <img src="{{ URL::asset('./assets/images/login-job.png') }}" class="img-fluid" alt="">
                                    </div>
                                    <div class="p-0 p-sm-4 px-xl-0 py-5">
                                        <div id="reviewcarouselIndicators" class="carousel slide auth-carousel"
                                            data-bs-ride="carousel">
                                            <div class="carousel-indicators carousel-indicators-rounded">
                                                <button type="button" data-bs-target="#reviewcarouselIndicators"
                                                    data-bs-slide-to="0" class="active" aria-current="true"
                                                    aria-label="Slide 1"></button>
                                                <button type="button" data-bs-target="#reviewcarouselIndicators"
                                                    data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                <button type="button" data-bs-target="#reviewcarouselIndicators"
                                                    data-bs-slide-to="2" aria-label="Slide 3"></button>
                                            </div>
    
                                            <!-- end carouselIndicators -->
                                            <div class="carousel-inner w-75 mx-auto">
                                                <div class="carousel-item active">
                                                    <div class="testi-contain text-center">
                                                        <h5 class="font-size-20 mt-4">“Join Itci Hutani Manunggal!”</h5>
                                                        <p class="font-size-15 text-muted mt-3 mb-0">Seize the opportunity to join a leader in the Industrial Forestry Plantation sector. Become a part of Itci Hutani Manunggal and advance your career with sustainable projects.</p>
                                                    </div>
                                                </div>
                                            
                                                <div class="carousel-item">
                                                    <div class="testi-contain text-center">
                                                        <h5 class="font-size-20 mt-4">“Start your career at Itci Hutani Manunggal”</h5>
                                                        <p class="font-size-15 text-muted mt-3 mb-0">
                                                            Find the role that matches your skills at a leading forestry management company. Itci Hutani Manunggal offers a professional development platform to shape your future.
                                                        </p>
                                                    </div>
                                                </div>
                                            
                                                <div class="carousel-item">
                                                    <div class="testi-contain text-center">
                                                        <h5 class="font-size-20 mt-4">“Unlock your career success with us”</h5>
                                                        <p class="font-size-15 text-muted mt-3 mb-0">
                                                            With a commitment to environmental conservation, Itci Hutani Manunggal seeks dedicated talents for green innovation. Be part of a team that makes a real difference.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end carousel-inner -->
                                        </div>
                                        <!-- end review carousel -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container fluid -->
        </div>

        <!-- The Modal -->
        <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registerModalLabel">Register</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="registerForm">
                            @csrf
        
                            <!-- Personal Information Section -->
                            <h6><strong>Personal Information</strong></h6>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nik" class="form-label">NIK</label>
                                        <input type="text" class="form-control" id="nik" name="nik">
                                    </div>
                                    <div class="mb-3">
                                        <label for="first_name" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="known_as" class="form-label">Known As</label>
                                        <input type="text" class="form-control" id="known_as" name="known_as">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="gender" class="form-label">Gender</label>
                                        <select class="form-control" id="gender" name="gender">
                                            <option value="">- Select -</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="date_of_birth" class="form-label">Date of Birth</label>
                                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth">
                                    </div>
                                    <div class="mb-3">
                                        <label for="place_of_birth" class="form-label">Place of Birth</label>
                                        <input type="text" class="form-control" id="place_of_birth" name="place_of_birth">
                                    </div>
                                    <div class="mb-3">
                                        <label for="country_of_birth" class="form-label">Country of Birth</label>
                                        <select class="form-control" id="country_of_birth" name="country_of_birth">
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
                                </div>
                            </div>
        
                            <!-- Marital Status Section -->
                            <hr>
                            <h6><strong>Marital</strong></h6>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="marital_status" class="form-label">Status</label>
                                        <select class="form-control" id="marital_status" name="marital_status">
                                            <option value="">- Select -</option>
                                            <option value="single">Single</option>
                                            <option value="married">Married</option>
                                            <option value="divorced">Divorced</option>
                                            <option value="widowed">Widowed</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="since" class="form-label">Since</label>
                                        <input type="number" class="form-control" id="since" name="since">
                                    </div>
                                </div>
                            </div>
        
                            <!-- Contact Information Section -->
                            <hr>
                            <h6><strong>Contact Information</strong></h6>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="whatsapp_number" class="form-label">WhatsApp Number</label>
                                        <input type="tel" class="form-control" id="whatsapp_number" name="whatsapp_number">
                                    </div>
                                </div>
                            </div>

                            <!-- Account Information Section -->
                            <hr>
                            <h6><strong>Account Information</strong></h6>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" name="username">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password">
                                    </div>
                                </div>
                            </div>
        
                            <p><strong>Declaration:</strong></p>
                            <p>By applying, you authorize the company to verify all data you provide and confirm that all information is truthful and accurate.</p>
        
                            <button type="submit" class="btn btn-primary">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @endsection
        @section('script')
            <script src="{{ URL::asset('assets/js/pages/pass-addon.init.js') }}"></script>
            <script src="{{ URL::asset('assets/js/pages/eva-icon.init.js') }}"></script>
            <script>

                $('#registerForm').on('submit', async function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);

                    // Clear previous error messages
                    $('.error-message').remove();
                    $('.is-invalid').removeClass('is-invalid');

                    try {
                        const response = await fetch("{{ route('register') }}", {
                            method: "POST",
                            body: formData,
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            },
                        });

                        const result = await response.json();

                        if (result.status === "success") {
                            Swal.fire({
                                title: "Berhasil!",
                                text: result.message,
                                icon: "success",
                                confirmButtonColor: "#3b76e1",
                            }).then(() => {
                                window.location.href = result.redirect_url;
                            });

                        } else if (result.status === "validation_error") {
                            // Display validation errors
                            for (const [field, errors] of Object.entries(result.errors)) {
                                const fieldElement = $(`[name="${field}"]`);
                                fieldElement.addClass('is-invalid');
                                errors.forEach(error => {
                                    fieldElement.after(`<div class="error-message text-danger">${error}</div>`);
                                });
                            }
                        } else if (result.status === "error") {
                            Swal.fire({
                                title: "Gagal!",
                                text: result.message || "Periksa input Anda.",
                                icon: "error",
                                confirmButtonColor: "#3b76e1",
                            });
                        }
                    } catch (error) {
                        Swal.fire({
                            title: "Error!",
                            text: "Terjadi kesalahan saat memproses data.",
                            icon: "error",
                            confirmButtonColor: "#3b76e1",
                        });
                    }
                });

                $('#input-username, #password-input').on('keypress', function(e) {
                    if (e.which == 13) { // 13 adalah kode tombol enter
                        formSubmit(); // Panggil fungsi formSubmit di sini
                    }
                });

                var input = document.getElementById("password-input");
                input.addEventListener("keyup", function(event) {
                    if (event.getModifierState("CapsLock")) {
                        $('#capslock-indicator-on').show();
                    } else {
                        $('#capslock-indicator-on').hide();
                    }
                });

                const formSubmit = async () => {

                    const username = $('#input-username').val();
                    const password = $('#password-input').val();

                    if(username == '' || password == '') {
                        Swal.fire(
                            {
                                title: 'Error!',
                                text: 'Please enter your login information.',
                                icon: 'error',
                                showCancelButton: false,
                                confirmButtonColor: '#3b76e1',
                            }
                        )
                    } else {

                        const formData = new FormData();

                        formData.append('username', username);
                        formData.append('password', password);

                        const response = await fetch('api/getlogin',{
                            method: 'POST',
                            body: formData
                        });
                        const data = await response.json();

                        if(data.code == 0) {

                            // $("#loginForm").submit();
                            Swal.fire(
                                {
                                    title: 'Error!',
                                    text: 'User Not Found.',
                                    icon: 'error',
                                    showCancelButton: false,
                                    confirmButtonColor: '#3b76e1',
                                }
                            )

                        } else if(data.code == 401) {

                            Swal.fire(
                                {
                                    title: 'Error!',
                                    text: 'Unauthorized access. Invalid password.',
                                    icon: 'error',
                                    showCancelButton: false,
                                    confirmButtonColor: '#3b76e1',
                                }
                            )
                            
                        } else if(data.code == 409) {

                            Swal.fire(
                                {
                                    title: 'Error!',
                                    html: 'Someone has accessed your account. <br> ( ip : '+data.ip+' )',
                                    icon: 'error',
                                    showCancelButton: false,
                                    confirmButtonColor: '#3b76e1',
                                }
                            )

                        } else if(data.code == 200) {
                            $("#loginForm").submit();
                        }
                    }

                }
            </script>
        @endsection
