@extends('layouts.master')
@section('title') @lang('translation.Dashboards') @endsection

@section('content')
@section('pagetitle') {{ auth::user()->fullname }}, <small>Welcome to Job Portal.</small> @endsection

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Job Listings</h4>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-xl-4 col-sm-6">
                        {{-- <h6 class="text-uppercase">Filter</h6> --}}
                        <!-- Search Input for Keywords -->
                        <form method="GET" action="{{ route('root') }}">
                            <!-- Search Input for Keywords -->
                            <div class="mb-3">
                                <input type="text" name="keyword" class="form-control" placeholder="Search by keywords..." value="{{ request('keyword') }}">
                            </div>
                        
                            <div class="d-flex justify-content-between mb-3">
                                <!-- Dropdown for Job Categories -->
                                <div class="dropdown">
                                    <!-- Mobile button -->
                                    <button class="btn btn-sm btn-secondary dropdown-toggle d-lg-none" type="button" id="categoryDropdown1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Select Job Categories
                                    </button>
                                    <!-- Desktop button -->
                                    <button class="btn btn-lg btn-secondary dropdown-toggle d-none d-lg-inline-block" type="button" id="categoryDropdown1Desktop" data-bs-toggle="dropdown" aria-expanded="false">
                                        Select Job Categories
                                    </button>
                                    <ul class="dropdown-menu p-3" aria-labelledby="categoryDropdown1">
                                        @foreach($distinctCategories as $category)
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category }}" id="category{{ $loop->index }}" {{ in_array($category, request('categories', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="category{{ $loop->index }}">
                                                    {{ $category }}
                                                </label>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            
                                <!-- Dropdown for Job Locations -->
                                <div class="dropdown">
                                    <!-- Mobile button -->
                                    <button class="btn btn-sm btn-secondary dropdown-toggle d-lg-none" type="button" id="locationDropdown2" data-bs-toggle="dropdown" aria-expanded="false">
                                        Select Job Locations
                                    </button>
                                    <!-- Desktop button -->
                                    <button class="btn btn-lg btn-secondary dropdown-toggle d-none d-lg-inline-block" type="button" id="locationDropdown2Desktop" data-bs-toggle="dropdown" aria-expanded="false">
                                        Select Job Locations
                                    </button>
                                    <ul class="dropdown-menu p-3" aria-labelledby="locationDropdown2">
                                        @foreach($distinctLocations as $location)
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="locations[]" value="{{ $location }}" id="location{{ $loop->index }}" {{ in_array($location, request('locations', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="location{{ $loop->index }}">
                                                    {{ $location }}
                                                </label>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        
                            <div class="d-flex justify-content-start mt-3">
                                <button type="submit" class="btn btn-primary me-2">Filter</button>
                                <a href="{{ route('root') }}" class="btn btn-danger">Reset</a>
                            </div>
                        </form>
                    </div>

                    <div class="col-xl-8 col-sm-6">
                        <form class="mt-4 mt-sm-0 float-sm-end d-sm-flex align-items-center">
                            <ul class="nav nav-pills product-view-nav justify-content-end mt-3 mt-sm-0" role="tablist">
                                <li class="nav-item waves-effect waves-light">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#job-list" role="tab">
                                        <i class="bx bx-list-ul"></i>
                                    </a>
                                </li>
                            </ul>
                        </form>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-xl-12">
                        <div class="tab-content">
                            <div class="tab-pane active" id="job-list" role="tabpanel">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="table-responsive px-3">
                                                        <table class="table table-striped align-middle table-nowrap">
                                                            <tbody>
                                                                @foreach($jobs as $job)
                                                                <tr>
                                                                    <td>
                                                                        <div>
                                                                            <h5 class="font-size-18">
                                                                                <a href="{{ route('jobs.show', $job->id) }}" class="text-dark">{{ $job->job_title }}</a>
                                                                            </h5>
                                                                            <p class="text-muted mb-0 mt-2 pt-2">{{ $job->code_job }} | {{ $job->category }}</p>
                                                                        </div>
                                                                    </td>
                
                                                                    <td>
                                                                        <ul class="list-unstyled ps-0 mb-0">
                                                                            <li>
                                                                                <p class="text-muted mb-0">
                                                                                    <i class="mdi mdi-circle-medium align-middle text-primary me-1"></i>
                                                                                    <i class="fa fa-briefcase"></i> {{ ucwords($job->contract_status) }}
                                                                                </p>
                                                                            </li>
                                                                            <li>
                                                                                <p class="text-muted mb-0">
                                                                                    <i class="mdi mdi-circle-medium align-middle text-primary me-1"></i>
                                                                                    <i class="fa fa-map-pin"></i> {{ $job->location }}
                                                                                </p>
                                                                            </li>
                                                                        </ul>
                                                                    </td>
                
                                                                    <td>
                                                                        <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#jobModal{{ $job->id }}">See Details</button>
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                
                                            <!-- Pagination Links -->
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <ul class="pagination float-end pagination-rounded mb-2">
                                                        {{ $jobs->links('pagination::bootstrap-4') }}
                                                    </ul>
                                                </div>
                                            </div>
                                            <!-- End Pagination Links -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
</div>

<!-- Modal Section for Job Details (Assuming a Modal for each job) -->
@foreach($jobs as $job)
<div class="modal fade" id="jobModal{{ $job->id }}" tabindex="-1" aria-labelledby="jobModalLabel{{ $job->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="jobModalLabel{{ $job->id }}">{{ $job->job_title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Job Code:</strong> {{ $job->code_job }}</p>
                <p><strong>Category:</strong> {{ $job->category }}</p>
                <p><strong>Contract Status:</strong> {{ ucwords($job->contract_status) }}</p>
                <p><strong>Location:</strong> {{ $job->location }}</p>
                <p><strong>Experience Required:</strong> {{ $job->experience_years }} years</p>
                <p><strong>Job Description:</strong></p>
                <p>{{ $job->job_description }}</p>
                <p><strong>Skills Required:</strong> {{ implode(', ', $job->skills_required) }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#applyModal{{ $job->id }}">Apply Now</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Section for Application Requirements -->
<div class="modal fade" id="applyModal{{ $job->id }}" tabindex="-1" aria-labelledby="applyModalLabel{{ $job->id }}" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="applyModalLabel{{ $job->id }}">Application Requirements for {{ $job->job_title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Please ensure you have the following information filled out before applying:</p>
                <ul>
                    <li>CV - My Profile (Documents)</li>
                    <li>Education - from the education table</li>
                    <li>Communication - from the communication table</li>
                    <li>Marital Status - from the marital table</li>
                    <li>Address - from the address table</li>
                    <li>Social Media - from the social table</li>
                    <li>Full Body Photo - from the photo table</li>
                </ul>
                <p><strong>Declaration:</strong></p>
                <p>By applying, you authorize the company to verify all data you provide and confirm that all information is truthful and accurate.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Submit</button>
            </div>
        </div>
    </div>
</div>
@endforeach


@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/wnumb/wnumb.min.js') }}"></script>
@endsection
