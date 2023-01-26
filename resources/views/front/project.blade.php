@extends('front.layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center mt-5">
            @if (session()->has('success'))
                <div class="col-md-7">
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                </div>
            @endif
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">
                        <h4>Submit Project</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('submit-project') }}" method="POST" enctype="multipart/form-data"
                            class="row">
                            @csrf
                            <input type="hidden" name="project_id" value="{{ $id }}">
                            <div class="col-md-12 mb-4">
                                <label class="mb-2">Title</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    placeholder="Product title..." name="title" value="{{ old('title') }}">
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-4">
                                <label class="mb-2">Description</label>
                                <textarea class="form-control " placeholder="Description..." name="description">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-4">
                                <label class="mb-2">File</label>
                                <input type="file" class="form-control" name="file" accept=".zip,.rar,.7zip">
                                @error('file')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-4">
                                <button class="btn btn-success" type="submit">Save</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
