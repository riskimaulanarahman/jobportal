<div class="col-lg-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">Address</h4>
            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#createModalAddress">Create</button>
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
                            <th>Contact Person</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($address as $item)
                        <tr>
                            <td>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModalAddress{{ $item->id }}">Edit</button>
                                <button class="btn btn-danger btn-sm" id="deleteFormAddress" data-id="{{ $item->id }}">Delete</button>
                            </td>
                            <td>{{ $item->address_type }}</td>
                            <td>{{ $item->street_and_house_number }}</td>
                            <td>{{ $item->city }}</td>
                            <td>{{ $item->postal_code }}</td>
                            <td>{{ $item->country }}</td>
                            <td>{{ $item->tel_number }}</td>
                            <td>{{ $item->name_contact_person }}</td>
                        </tr>

                        <!-- Edit Modal Address -->
                        <div class="modal fade" id="editModalAddress{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <form id="editFormAddress{{ $item->id }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Address</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label>Address Type</label>
                                                <input type="text" name="address_type" class="form-control" value="{{ $item->address_type }}" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label>Street and House Number</label>
                                                <input type="text" name="street_and_house_number" class="form-control" value="{{ $item->street_and_house_number }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>City</label>
                                                <input type="text" name="city" class="form-control" value="{{ $item->city }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Postal Code</label>
                                                <input type="text" name="postal_code" class="form-control" value="{{ $item->postal_code }}">
                                            </div>
                                            <div class="mb-3">
                                                <label>Country</label>
                                                <select class="form-control" id="country" name="country" required>
                                                    <option value="">- Select -</option>
                                                    <option value="Indonesia" {{ $item->country == 'Indonesia' ? 'selected' : '' }}>Indonesia</option>
                                                    <option value="United States" {{ $item->country == 'United States' ? 'selected' : '' }}>United States</option>
                                                    <option value="United Kingdom" {{ $item->country == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                                                    <option value="Canada" {{ $item->country == 'Canada' ? 'selected' : '' }}>Canada</option>
                                                    <option value="Australia" {{ $item->country == 'Australia' ? 'selected' : '' }}>Australia</option>
                                                    <option value="Germany" {{ $item->country == 'Germany' ? 'selected' : '' }}>Germany</option>
                                                    <option value="France" {{ $item->country == 'France' ? 'selected' : '' }}>France</option>
                                                    <option value="Japan" {{ $item->country == 'Japan' ? 'selected' : '' }}>Japan</option>
                                                    <option value="China" {{ $item->country == 'China' ? 'selected' : '' }}>China</option>
                                                    <option value="India" {{ $item->country == 'India' ? 'selected' : '' }}>India</option>
                                                    <option value="Brazil" {{ $item->country == 'Brazil' ? 'selected' : '' }}>Brazil</option>
                                                    <option value="South Africa" {{ $item->country == 'South Africa' ? 'selected' : '' }}>South Africa</option>
                                                    <option value="others" {{ $item->country == 'others' ? 'selected' : '' }}>Others</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label>Tel. Number</label>
                                                <input type="text" name="tel_number" class="form-control" value="{{ $item->tel_number }}">
                                            </div>
                                            <div class="mb-3">
                                                <label>Contact Person</label>
                                                <input type="text" name="name_contact_person" class="form-control" value="{{ $item->name_contact_person }}">
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
<!-- Create Modal Address -->
<div class="modal fade" id="createModalAddress" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="createFormAddress">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Address Type</label>
                        <select class="form-control" id="address_type" name="address_type" required>
                            <option value="">- Select -</option>
                            <option value="Current">Current</option>
                            <option value="Home">Home</option>
                            <option value="Emergency">Emergency</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Street and House Number</label>
                        <input type="text" name="street_and_house_number" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>City</label>
                        <input type="text" name="city" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Postal Code</label>
                        <input type="text" name="postal_code" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Country</label>
                        <select class="form-control" id="country" name="country" required>
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
                        <label>Tel. Number</label>
                        <input type="text" name="tel_number" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Contact Person</label>
                        <input type="text" name="name_contact_person" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Create</button>
                </div>
            </div>
        </form>
    </div>
</div>