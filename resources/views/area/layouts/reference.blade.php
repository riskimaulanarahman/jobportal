<div class="col-lg-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">Reference</h4>
            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#createModalReference">Create</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Actions</th>
                            <th>Relation</th>
                            <th>Name</th>
                            <th>Number</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reference as $item)
                        <tr>
                            <td>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModalReference{{ $item->id }}">Edit</button>
                                <button class="btn btn-danger btn-sm" id="deleteFormReference" data-id="{{ $item->id }}">Delete</button>
                            </td>
                            <td>{{ $item->relation }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->number }}</td>
                        </tr>

                        <!-- Edit Modal Reference -->
                        <div class="modal fade" id="editModalReference{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <form id="editFormReference{{ $item->id }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Reference</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label>Relation</label>
                                                <input type="text" name="relation" class="form-control" value="{{ $item->relation }}">
                                            </div>
                                            <div class="mb-3">
                                                <label>Name</label>
                                                <input type="text" name="name" class="form-control" value="{{ $item->name }}">
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
<!-- Create Modal Reference -->
<div class="modal fade" id="createModalReference" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="createFormReference">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Reference</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Relation</label>
                        <input type="text" name="relation" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
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