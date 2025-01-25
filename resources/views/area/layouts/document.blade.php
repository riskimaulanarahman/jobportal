<div class="col-lg-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">Documents</h4>
            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#createModalDocument">Create</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Type Document</th>
                            <th>File</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($document as $doc)
                        <tr>
                            <td>{{ $doc->typeDocument->name }}</td>
                            <td>
                                @if($doc->path)
                                <a href="{{ asset('upload/'.$doc->path) }}" class="btn btn-secondary btn-sm" target="_blank">
                                    <img src="{{ asset('upload/'.$doc->path) }}" alt="doc" height="30" width="30">
                                </a>
                                @else
                                <span class="text-danger">No file uploaded</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModalDocument{{ $doc->id }}">Edit</button>
                                <button class="btn btn-danger btn-sm" id="deleteFormDocument" data-id="{{ $doc->id }}">Delete</button>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModalDocument{{ $doc->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <form id="editFormDocument{{ $doc->id }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Document</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label>Type Document</label>
                                                <select name="type_document_id" class="form-control" required>
                                                    @foreach($refTypeDocuments as $type)
                                                    <option value="{{ $type->id }}" @if($type->id == $doc->type_document_id) selected @endif>
                                                        {{ $type->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label>Replace File</label>
                                                <input type="file" name="document" class="form-control">
                                                @if($doc->path)
                                                <small class="text-muted">Current file: <a href="{{ asset('upload/'.$doc->path) }}" target="_blank">{{ $doc->path }}</a></small>
                                                @endif
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

<!-- Create Modal Document -->
<div class="modal fade" id="createModalDocument" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="createFormDocument">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Document</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Type Document</label>
                        <select name="type_document_id" class="form-control" required>
                            <option value="">- Select -</option>
                            @foreach($refTypeDocuments as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Upload File</label>
                        <input type="file" name="document" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Create</button>
                </div>
            </div>
        </form>
    </div>
</div>
