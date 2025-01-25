<div class="col-lg-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">Communication</h4>
            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#createModalCommunication">Create</button>
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
                        @foreach($communication as $item)
                        <tr>
                            <td>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModalCommunication{{ $item->id }}">Edit</button>
                                <button class="btn btn-danger btn-sm" id="deleteFormCommunication" data-id="{{ $item->id }}">Delete</button>
                            </td>
                            <td>{{ $item->type }}</td>
                            <td>{{ $item->number }}</td>
                        </tr>

                        <!-- Edit Modal Communication -->
                        <div class="modal fade" id="editModalCommunication{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <form id="editFormCommunication{{ $item->id }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Communication</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label>Type</label>
                                                <input type="text" name="type" class="form-control" value="{{ $item->type }}" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label>Number</label>
                                                <input type="text" name="number" class="form-control" value="{{ $item->number }}">
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
<!-- Create Modal Communication -->
<div class="modal fade" id="createModalCommunication" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="createFormCommunication">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Communication</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Type</label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="">- Select -</option>
                            <option value="Handphone">Handphone</option>
                            <option value="Fax">Fax</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Number</label>
                        <input type="text" name="number" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Create</button>
                </div>
            </div>
        </form>
    </div>
</div>