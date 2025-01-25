<div class="col-lg-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">Size</h4>
            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#createModalSize">Create</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Actions</th>
                            <th>Height</th>
                            <th>Weight</th>
                            <th>Clothing Size</th>
                            <th>Pants Size</th>
                            <th>Shoe Size</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($size as $item)
                        <tr>
                            <td>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModalSize{{ $item->id }}">Edit</button>
                                <button class="btn btn-danger btn-sm" id="deleteFormSize" data-id="{{ $item->id }}">Delete</button>
                            </td>
                            <td>{{ $item->height }}</td>
                            <td>{{ $item->weight }}</td>
                            <td>{{ $item->clothing_size }}</td>
                            <td>{{ $item->pants_size }}</td>
                            <td>{{ $item->shoe_size }}</td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModalSize{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <form id="editFormSize{{ $item->id }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Size</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label>Height</label>
                                                <input type="text" name="height" class="form-control" value="{{ $item->height }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Weight</label>
                                                <input type="text" name="weight" class="form-control" value="{{ $item->weight }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Clothing Size</label>
                                                <select class="form-control" id="clothing_size" name="clothing_size" required>
                                                    <option value="">- Select -</option>
                                                    <option value="XS" {{ $item->clothing_size == 'XS' ? 'selected' : '' }}>XS</option>
                                                    <option value="S" {{ $item->clothing_size == 'S' ? 'selected' : '' }}>S</option>
                                                    <option value="M" {{ $item->clothing_size == 'M' ? 'selected' : '' }}>M</option>
                                                    <option value="L" {{ $item->clothing_size == 'L' ? 'selected' : '' }}>L</option>
                                                    <option value="XL" {{ $item->clothing_size == 'XL' ? 'selected' : '' }}>XL</option>
                                                    <option value="XXL" {{ $item->clothing_size == 'XXL' ? 'selected' : '' }}>XXL</option>
                                                    <option value="XXXL" {{ $item->clothing_size == 'XXXL' ? 'selected' : '' }}>XXXL</option>
                                                    <option value="XXXXL" {{ $item->clothing_size == 'XXXXL' ? 'selected' : '' }}>XXXXL</option>
                                                    <option value="XXXXXL" {{ $item->clothing_size == 'XXXXXL' ? 'selected' : '' }}>XXXXXL</option>
                                                    <!-- Add more countries as needed -->
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label>Pants Size</label>
                                                <input type="text" name="pants_size" class="form-control" value="{{ $item->pants_size }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Shoe Size</label>
                                                <input type="text" name="shoe_size" class="form-control" value="{{ $item->shoe_size }}" required>
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
<!-- Create Modal Size-->
<div class="modal fade" id="createModalSize" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="createFormSize">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Size</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Height</label>
                        <input type="number" name="height" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Weight</label>
                        <input type="number" name="weight" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Clothing Size</label>
                        <select class="form-control" id="clothing_size" name="clothing_size" required>
                            <option value="">- Select -</option>
                            <option value="XS">XS</option>
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                            <option value="XL">XL</option>
                            <option value="XXL">XXL</option>
                            <option value="XXXL">XXXL</option>
                            <option value="XXXXL">XXXXL</option>
                            <option value="XXXXXL">XXXXXL</option>
                            <!-- Add more countries as needed -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Pants Size</label>
                        <input type="number" name="pants_size" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Shoe Size</label>
                        <input type="number" name="shoe_size" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Create</button>
                </div>
            </div>
        </form>
    </div>
</div>