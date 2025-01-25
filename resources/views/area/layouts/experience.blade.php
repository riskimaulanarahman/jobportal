<div class="col-lg-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">Experience</h4>
            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#createModalExperience">Create</button>
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
                        @foreach($experience as $experience)
                        <tr>
                            <td>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModalExperience{{ $experience->id }}">Edit</button>
                                <button class="btn btn-danger btn-sm" id="deleteFormExperience" data-id="{{ $experience->id }}">Delete</button>
                            </td>
                            <td>{{ $experience->start_date }}</td>
                            <td>{{ $experience->end_date }}</td>
                            <td>{{ $experience->company }}</td>
                            <td>{{ $experience->industry_type }}</td>
                            <td>{{ $experience->city_or_country }}</td>
                            <td>{{ $experience->last_position_held }}</td>
                            <td>{{ $experience->name_of_superior }}</td>
                            <td>{{ $experience->designation_of_superior }}</td>
                            <td>{{ $experience->last_drawn_salary }}</td>
                            <td>{{ $experience->reason_for_leaving }}</td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModalExperience{{ $experience->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <form id="editFormExperience{{ $experience->id }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Experience</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label>Start Date</label>
                                                <input type="date" name="start_date" class="form-control" value="{{ $experience->start_date }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>End Date</label>
                                                <input type="date" name="end_date" class="form-control" value="{{ $experience->end_date }}">
                                            </div>
                                            <div class="mb-3">
                                                <label>Company</label>
                                                <input type="text" name="company" class="form-control" value="{{ $experience->company }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Industry Type</label>
                                                <select name="industry_type" class="form-control" required>
                                                    <option value="Software" {{ $experience->industry_type == 'Software' ? 'selected' : '' }}>Software</option>
                                                    <option value="Finance" {{ $experience->industry_type == 'Finance' ? 'selected' : '' }}>Finance</option>
                                                    <option value="Healthcare" {{ $experience->industry_type == 'Healthcare' ? 'selected' : '' }}>Healthcare</option>
                                                    <option value="Education" {{ $experience->industry_type == 'Education' ? 'selected' : '' }}>Education</option>
                                                    <option value="Manufacturing" {{ $experience->industry_type == 'Manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                                                    <option value="Retail" {{ $experience->industry_type == 'Retail' ? 'selected' : '' }}>Retail</option>
                                                    <option value="Construction" {{ $experience->industry_type == 'Construction' ? 'selected' : '' }}>Construction</option>
                                                    <option value="Technology" {{ $experience->industry_type == 'Technology' ? 'selected' : '' }}>Technology</option>
                                                    <option value="Transportation" {{ $experience->industry_type == 'Transportation' ? 'selected' : '' }}>Transportation</option>
                                                    <option value="Hospitality" {{ $experience->industry_type == 'Hospitality' ? 'selected' : '' }}>Hospitality</option>
                                                    <option value="Energy" {{ $experience->industry_type == 'Energy' ? 'selected' : '' }}>Energy</option>
                                                    <option value="Agriculture" {{ $experience->industry_type == 'Agriculture' ? 'selected' : '' }}>Agriculture</option>
                                                    <option value="Telecommunications" {{ $experience->industry_type == 'Telecommunications' ? 'selected' : '' }}>Telecommunications</option>
                                                    <option value="Entertainment" {{ $experience->industry_type == 'Entertainment' ? 'selected' : '' }}>Entertainment</option>
                                                    <option value="Real Estate" {{ $experience->industry_type == 'Real Estate' ? 'selected' : '' }}>Real Estate</option>
                                                    <option value="Food & Beverage" {{ $experience->industry_type == 'Food & Beverage' ? 'selected' : '' }}>Food & Beverage</option>
                                                    <option value="Automotive" {{ $experience->industry_type == 'Automotive' ? 'selected' : '' }}>Automotive</option>
                                                    <option value="Media" {{ $experience->industry_type == 'Media' ? 'selected' : '' }}>Media</option>
                                                    <option value="Public Sector" {{ $experience->industry_type == 'Public Sector' ? 'selected' : '' }}>Public Sector</option>
                                                    <option value="Aerospace" {{ $experience->industry_type == 'Aerospace' ? 'selected' : '' }}>Aerospace</option>
                                                    <option value="Pharmaceutical" {{ $experience->industry_type == 'Pharmaceutical' ? 'selected' : '' }}>Pharmaceutical</option>
                                                    <option value="Legal" {{ $experience->industry_type == 'Legal' ? 'selected' : '' }}>Legal</option>
                                                    <option value="Consulting" {{ $experience->industry_type == 'Consulting' ? 'selected' : '' }}>Consulting</option>
                                                    <option value="Logistics" {{ $experience->industry_type == 'Logistics' ? 'selected' : '' }}>Logistics</option>
                                                    <option value="Sports" {{ $experience->industry_type == 'Sports' ? 'selected' : '' }}>Sports</option>
                                                    <option value="E-commerce" {{ $experience->industry_type == 'E-commerce' ? 'selected' : '' }}>E-commerce</option>
                                                    <option value="Non-profit" {{ $experience->industry_type == 'Non-profit' ? 'selected' : '' }}>Non-profit</option>
                                                    <option value="Mining" {{ $experience->industry_type == 'Mining' ? 'selected' : '' }}>Mining</option>
                                                    <option value="Environmental" {{ $experience->industry_type == 'Environmental' ? 'selected' : '' }}>Environmental</option>
                                                    <option value="Insurance" {{ $experience->industry_type == 'Insurance' ? 'selected' : '' }}>Insurance</option>
                                                    <option value="Fashion" {{ $experience->industry_type == 'Fashion' ? 'selected' : '' }}>Fashion</option>
                                                    <option value="Chemical" {{ $experience->industry_type == 'Chemical' ? 'selected' : '' }}>Chemical</option>
                                                    <option value="Other" {{ $experience->industry_type == 'Other' ? 'selected' : '' }}>Other</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label>City/Country</label>
                                                <input type="text" name="city_or_country" class="form-control" value="{{ $experience->city_or_country }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Last Position Held</label>
                                                <input type="text" name="last_position_held" class="form-control" value="{{ $experience->last_position_held }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Name of Superior</label>
                                                <input type="text" name="name_of_superior" class="form-control" value="{{ $experience->name_of_superior }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Designation of Superior</label>
                                                <input type="text" name="designation_of_superior" class="form-control" value="{{ $experience->designation_of_superior }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Last Drawn Salary</label>
                                                <input type="number" name="last_drawn_salary" class="form-control" value="{{ $experience->last_drawn_salary }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Reason for Leaving</label>
                                                <textarea name="reason_for_leaving" class="form-control" required>{{ $experience->reason_for_leaving }}</textarea>
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

<!-- Create Modal -->
<div class="modal fade" id="createModalExperience" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="createFormExperience">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Experience</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Start Date</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>End Date</label>
                        <input type="date" name="end_date" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Company</label>
                        <input type="text" name="company" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Industry Type</label>
                            <select name="industry_type" class="form-control" required>
                                <option value="">- Select -</option>
                                <option value="Software">Software</option>
                                <option value="Finance">Finance</option>
                                <option value="Healthcare">Healthcare</option>
                                <option value="Education">Education</option>
                                <option value="Manufacturing">Manufacturing</option>
                                <option value="Retail">Retail</option>
                                <option value="Construction">Construction</option>
                                <option value="Technology">Technology</option>
                                <option value="Transportation">Transportation</option>
                                <option value="Hospitality">Hospitality</option>
                                <option value="Energy">Energy</option>
                                <option value="Agriculture">Agriculture</option>
                                <option value="Telecommunications">Telecommunications</option>
                                <option value="Entertainment">Entertainment</option>
                                <option value="Real Estate">Real Estate</option>
                                <option value="Food & Beverage">Food & Beverage</option>
                                <option value="Automotive">Automotive</option>
                                <option value="Media">Media</option>
                                <option value="Public Sector">Public Sector</option>
                                <option value="Aerospace">Aerospace</option>
                                <option value="Pharmaceutical">Pharmaceutical</option>
                                <option value="Legal">Legal</option>
                                <option value="Consulting">Consulting</option>
                                <option value="Logistics">Logistics</option>
                                <option value="Sports">Sports</option>
                                <option value="E-commerce">E-commerce</option>
                                <option value="Non-profit">Non-profit</option>
                                <option value="Mining">Mining</option>
                                <option value="Environmental">Environmental</option>
                                <option value="Insurance">Insurance</option>
                                <option value="Fashion">Fashion</option>
                                <option value="Chemical">Chemical</option>
                                <option value="Other">Other</option>
                            </select>
                    </div>
                    <div class="mb-3">
                        <label>City/Country</label>
                        <input type="text" name="city_or_country" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Last Position Held</label>
                        <input type="text" name="last_position_held" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Name of Superior</label>
                        <input type="text" name="name_of_superior" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Designation of Superior</label>
                        <input type="text" name="designation_of_superior" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Last Drawn Salary</label>
                        <input type="number" name="last_drawn_salary" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Reason for Leaving</label>
                        <textarea name="reason_for_leaving" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Create</button>
                </div>
            </div>
        </form>
    </div>
</div>
