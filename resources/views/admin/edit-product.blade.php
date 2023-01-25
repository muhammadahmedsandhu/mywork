@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-5">
            @if (session()->has("success"))
                <div class="col-md-7">
                    <div class="alert alert-success">
                        {{ session()->get("success") }}
                    </div>
                </div>
            @endif
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Product</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route("update-product") }}" method="POST" enctype="multipart/form-data" class="row">
                            @csrf
                            <input type="hidden" value="{{ $product->id }}" name="productId">
                            <div class="col-md-12 mb-4">
                                <label class="mb-2">Title</label>
                                <input type="text" class="form-control @error("title") is-invalid @enderror" placeholder="Product title..." 
                                name="title" value="{{ $product->title }}">
                                @error("title")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-4">
                                <label class="mb-2">Price</label>
                                <input type="number" class="form-control @error("price") is-invalid @enderror" placeholder="Product price..." step="2" 
                                name="price" value="{{ $product->price }}">
                                @error("price")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-4">
                                <label class="mb-2">Description</label>
                                <textarea class="form-control " placeholder="Description..." name="desc">{{ $product->desc }}</textarea>
                            </div>
                            <div class="col-md-12 mb-4">
                                <label class="mb-2">Deadline</label>
                                <input type="date" class="form-control @error("deadline") is-invalid @enderror" name="deadline" value="{{ $product->deadline }}">
                                @error("deadline")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-4">
                                <label class="mb-2">Change File</label>
                                <input type="file" class="form-control" name="zip" accept=".zip,.rar,.7zip">
                            </div>
                            <div class="col-md-12 mb-4">
                                <button class="btn btn-primary" type="submit">Update</button>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection