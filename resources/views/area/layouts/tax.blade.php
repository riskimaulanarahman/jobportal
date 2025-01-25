<div class="col-lg-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">Tax Information</h4>
            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#createModalTax">Create</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Actions</th>
                            <th>NPWP ID</th>
                            <th>Registered Date</th>
                            <th>NPWP Address</th>
                            <th>Married for Tax Purpose</th>
                            <th>Spouse Benefit</th>
                            <th>Number of Dependents</th>
                            <th>Jamsostek ID</th>
                            <th>BPJS ID</th>
                            <th>Benefit Class</th>
                            <th>Number of Dependents</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tax as $item)
                        <tr>
                            <td>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModalTax{{ $item->id }}">Edit</button>
                            </td>
                            <td>{{ $item->npwp }}</td>
                            <td>{{ $item->registered_date }}</td>
                            <td>{{ $item->npwp_address }}</td>
                            <td>{{ $item->married_for_tax_purpose }}</td>
                            <td>{{ $item->spouse_benefit }}</td>
                            <td>{{ $item->number_of_dependents }}</td>
                            <td>{{ $item->jamsostek_id }}</td>
                            <td>{{ $item->bpjs_id }}</td>
                            <td>{{ $item->benefit_class }}</td>
                            <td>{{ $item->dependents_count }}</td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModalTax{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <form id="editFormTax{{ $item->id }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Tax Information</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h4>Tax Data</h4>
                                            <div class="mb-3">
                                                <label>NPWP ID</label>
                                                <input type="text" name="npwp" class="form-control" value="{{ $item->npwp }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Registered Date</label>
                                                <input type="date" name="registered_date" class="form-control" value="{{ $item->registered_date }}">
                                            </div>
                                            <div class="mb-3">
                                                <label>NPWP Address</label>
                                                <textarea name="npwp_address" class="form-control" required>{{ $item->npwp_address }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label>Married for Tax Purpose</label>
                                                <select name="married_for_tax_purpose" class="form-control" required>
                                                    <option value="Yes" {{ $item->married_for_tax_purpose == 'Yes' ? 'selected' : '' }}>Yes</option>
                                                    <option value="No" {{ $item->married_for_tax_purpose == 'No' ? 'selected' : '' }}>No</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label>Spouse Benefit</label>
                                                <select name="spouse_benefit" class="form-control" required>
                                                    <option value="Yes" {{ $item->spouse_benefit == 'Yes' ? 'selected' : '' }}>Yes</option>
                                                    <option value="No" {{ $item->spouse_benefit == 'No' ? 'selected' : '' }}>No</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label>Number of Dependents</label>
                                                <input type="number" name="number_of_dependents" class="form-control" value="{{ $item->number_of_dependents }}" required>
                                            </div>
                                            <h4>Jamsostek</h4>
                                            <div class="mb-3">
                                                <label>Jamsostek ID</label>
                                                <input type="text" name="jamsostek_id" class="form-control" value="{{ $item->jamsostek_id }}">
                                            </div>
                                            <h4>BPJS</h4>
                                            <div class="mb-3">
                                                <label>BPJS ID</label>
                                                <input type="text" name="bpjs_id" class="form-control" value="{{ $item->bpjs_id }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Benefit Class</label>
                                                <input type="number" name="benefit_class" class="form-control" value="{{ $item->benefit_class }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Dependents Count</label>
                                                <input type="text" name="dependents_count" class="form-control" value="{{ $item->dependents_count }}" readonly>
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

<!-- Create Modal Tax -->
<div class="modal fade" id="createModalTax" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="createFormTax">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Tax Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <h4>Tax Data</h4>
                    <div class="mb-3">
                        <label>NPWP ID</label>
                        <input type="text" name="npwp" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Registered Date</label>
                        <input type="date" name="registered_date" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>NPWP Address</label>
                        <textarea name="npwp_address" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Married for Tax Purpose</label>
                        <select name="married_for_tax_purpose" class="form-control" required>
                            <option value="">- Select -</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Spouse Benefit</label>
                        <select name="spouse_benefit" class="form-control" required>
                            <option value="">- Select -</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Number of Dependents</label>
                        <input type="number" name="number_of_dependents" class="form-control" required>
                    </div>
                    <h4>Jamsostek</h4>
                    <div class="mb-3">
                        <label>Jamsostek ID</label>
                        <input type="text" name="jamsostek_id" class="form-control">
                    </div>
                    <h4>BPJS</h4>
                    <div class="mb-3">
                        <label>BPJS ID</label>
                        <input type="text" name="bpjs_id" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Benefit Class</label>
                        <input type="number" name="benefit_class" min="0" max="3" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Dependents Count</label>
                        <input type="text" name="dependents_count" class="form-control" value="Use Family Info" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Create</button>
                </div>
            </div>
        </form>
    </div>
</div>
