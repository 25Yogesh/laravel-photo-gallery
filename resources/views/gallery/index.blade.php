@extends('layouts.app')
@section('title','Gallery')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Your Photo Gallery</h3>
    @auth
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPhotoModal">Add</button>
    @endauth
</div>


<!-- Gallery rendering -->
<div class="container">
    @php
    $rows = [];
    $tempVerticals = [];

    foreach ($photos as $photo) {
    if ($photo->view_type === 'horizontal') {
    // horizontal = own row
    $rows[] = [$photo];
    } else {
    // vertical = pair with another vertical if exists
    $tempVerticals[] = $photo;
    if (count($tempVerticals) === 2) {
    $rows[] = $tempVerticals;
    $tempVerticals = [];
    }
    }
    }
    if (count($tempVerticals) === 1) {
    // leftover vertical single image
    $rows[] = $tempVerticals;
    }
    @endphp

    @forelse($rows as $row)
    <div class="row mb-3">
        @foreach($row as $photo)
        @if($photo->view_type === 'horizontal')
        <div class="col-12">
            <div class="card photo-card">
                <img src="{{ asset('storage/' . $photo->path) }}" alt="{{ $photo->name }}" class="img-fluid">
                <div class="card-body">
                    <h5 class="card-title">{{ $photo->name }}</h5>
                    <p class="card-text"><small class="text-muted">Horizontal</small></p>
                    <form method="POST" action="{{ route('photos.destroy', $photo) }}" onsubmit="return confirm('Delete this photo?');">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
        @else
        <div class="col-md-6">
            <div class="card photo-card">
                <img src="{{ asset('storage/' . $photo->path) }}" alt="{{ $photo->name }}" class="img-fluid">
                <div class="card-body">
                    <h5 class="card-title">{{ $photo->name }}</h5>
                    <p class="card-text"><small class="text-muted">Vertical</small></p>
                    <form method="POST" action="{{ route('photos.destroy', $photo) }}" onsubmit="return confirm('Delete this photo?');">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
        @endif
        @endforeach
    </div>
    @empty
    <div class="alert alert-info">No photos yet. Click Add to upload your first photo.</div>
    @endforelse
</div>


<!-- Add photo modal -->
<div class="modal fade" id="addPhotoModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('photos.store') }}" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Add Photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Image Name</label>
                    <input name="name" value="{{ old('name') }}" class="form-control" required>
                    @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                <div class="mb-3">
                    <label>View Type</label>
                    <select name="view_type" class="form-select" required>
                        <option value="vertical" @selected(old('view_type')=='vertical' )>Vertical</option>
                        <option value="horizontal" @selected(old('view_type')=='horizontal' )>Horizontal</option>
                    </select>
                    @error('view_type')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                <div class="mb-3">
                    <label>Upload Image</label>
                    <input type="file" name="image" accept="image/*" class="form-control" required>
                    @error('image')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary">Upload</button>
            </div>
        </form>
    </div>
</div>
@endsection