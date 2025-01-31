@extends('layouts.master')

@section('title') @lang('Job Posting') @endsection

@section('css')
<!-- Add any specific CSS you need here -->
@endsection

@section('content')

{{-- @section('pagetitle') <small>My Profile</small> @endsection --}}

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">List Data Job Posting</h4>
            </div>
            <div class="card-body">
                <p class="card-title-desc"></p>

                <!-- Search Bar -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModalJobPosting">Add Data</button>
                    </div>
                    <div class="col-md-6">
                        <div class="float-end">
                            <a href="{{ route('job_posting.index') }}" class="btn btn-danger me-2" id="resetButton" style="display: {{ (request('keyword') == null) ? 'none' : 'inline-block'  }};">Reset</a>
                            <form method="GET" action="{{ route('job_posting.index') }}" class="d-inline">
                                <input type="text" id="searchInput" name="keyword" class="form-control d-inline w-auto" placeholder="Search by keywords..." value="{{ request('keyword') }}">
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End Search Bar -->

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Actions</th>
                                <th>Job Title</th>
                                <th>Job Code</th>
                                <th>Category</th>
                                <th>Contract Status</th>
                                <th>Location</th>
                                <th>Experience Required</th>
                                <th>Job Description</th>
                                <th>Skills Required</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $item)
                            <tr>
                                <td>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModalJobPosting{{ $item->id }}">Edit</button>
                                    <button class="btn btn-danger btn-sm" id="deleteFormJobPosting" data-id="{{ $item->id }}">Delete</button>
                                </td>
                                <td>{{ $item->job_title }}</td>
                                <td>{{ $item->code_job }}</td>
                                <td>{{ $item->category }}</td>
                                <td>{{ ucwords($item->contract_status) }}</td>
                                <td>{{ $item->location }}</td>
                                <td>{{ $item->experience_years }}</td>
                                <td>{{ $item->job_description }}</td>
                                <td>{{ implode(', ', $item->skills_required) }}</td>
                            </tr>
    
                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModalJobPosting{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form id="editFormJobPosting{{ $item->id }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Job Posting</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label>Job Title</label>
                                                    <input type="text" name="job_title" class="form-control" value="{{ $item->job_title }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Job Code</label>
                                                    <input type="text" name="code_job" class="form-control" value="{{ $item->code_job }}" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Category</label>
                                                    <input type="text" name="category" class="form-control" value="{{ $item->category }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Contract Status</label>
                                                    <select name="contract_status" class="form-control" required>
                                                        <option value="full-time" {{ $item->contract_status == 'full-time' ? 'selected' : '' }}>Full-Time</option>
                                                        <option value="contract" {{ $item->contract_status == 'contract' ? 'selected' : '' }}>Contract</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Location</label>
                                                    <input type="text" name="location" class="form-control" value="{{ $item->location }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Experience Required</label>
                                                    <input type="number" name="experience_years" class="form-control" value="{{ $item->experience_years }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Job Description</label>
                                                    <textarea name="job_description" class="form-control" required>{{ $item->job_description }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Skills Required</label>
                                                    <input type="text" name="skills_required" class="form-control skills_required" 
                                                    value="{{ is_string($item->skills_required) ? implode(', ', json_decode($item->skills_required, true)) : implode(', ', $item->skills_required) }}" 
                                                    required>
                                                    <span class="text-muted"><small>Press Enter for add new skill</small></span>
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
                <!-- Pagination Links -->
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="pagination float-end pagination-rounded mb-2">
                            {{ $data->links('pagination::bootstrap-4') }}
                        </ul>
                    </div>
                </div>
                <!-- End Pagination Links -->
              
            </div>
            <!-- end card -->
        </div>
    </div>
</div>

<!-- Create Modal Job Posting -->
<div class="modal fade" id="createModalJobPosting" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="createFormJobPosting">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Job Posting</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Job Title</label>
                        <input type="text" name="job_title" class="form-control" required>
                    </div>
                    {{-- <div class="mb-3">
                        <label>Job Code</label>
                        <input type="text" name="code_job" class="form-control" required>
                    </div> --}}
                    <div class="mb-3">
                        <label>Category</label>
                        <input type="text" name="category" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Contract Status</label>
                        <select name="contract_status" class="form-control" required>
                            <option value="full-time">Full-Time</option>
                            <option value="contract">Contract</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Location</label>
                        <input type="text" name="location" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Experience Required</label>
                        <input type="number" name="experience_years" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Job Description</label>
                        <textarea name="job_description" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Skills Required</label>
                        <input type="text" name="skills_required" class="form-control skills_required" required>
                        <span class="text-muted"><small>Press Enter for add new skill</small></span>
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

    {{-- CRUD JS --}}
    <script>
        $(document).ready(function () {

            handleFormSubmission('#createFormJobPosting', "{{ route('job_posting.store') }}");
            @foreach($data as $item)
                handleFormSubmission(`#editFormJobPosting{{ $item->id }}`, `/job_posting/{{ $item->id }}`, 'POST', 'PUT');
            @endforeach
            handleDeleteAction('#deleteFormJobPosting', '/job_posting/:id');

        });

        $(".skills_required").keypress(function (e) {
            if (e.key === "Enter") {
                e.preventDefault();
                $(this).val($(this).val() + ", ");
            }
        });
    </script>

@endsection