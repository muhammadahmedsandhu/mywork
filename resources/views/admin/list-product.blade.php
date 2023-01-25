@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-5">
            @if (session()->has("success"))
                <div class="col-md-12">
                    <div class="alert alert-success">
                        {{ session()->get("success") }}
                    </div>
                </div>
            @endif
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Product List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Price</th>
                                        <th>Description</th>
                                        <th>Deadline</th>
                                        <th>File</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($products) > 0)
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>{{ $product->title }}</td>
                                                <td>{{ $product->price }} $</td>
                                                <td>{{ $product->desc }}</td>
                                                <td>{{ $product->deadline }}</td>
                                                <td>
                                                    @if($product->file != "")
                                                    <a href="{{ asset("uploads/zip/$product->file") }}">Download</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route("edit-page",["id"=>$product->id]) }}" class="btn btn-sm btn-warning">Edit</a>
                                                    <a href="{{ route("delete-product",["id" => $product->id]) }}" 
                                                        onclick="return confirm('Are you sure ?')"
                                                        class="btn btn-sm btn-danger">Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center text-danger">No records found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $products->links("pagination::bootstrap-5") }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection