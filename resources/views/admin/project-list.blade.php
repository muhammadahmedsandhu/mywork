@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-5">
            @if (session()->has('success'))
                <div class="col-md-12">
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                </div>
            @endif
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Project List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>Project Title</th>
                                        <th>User Name</th>
                                        <th>Download</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($products) > 0)
                                        @foreach ($products as $product)
                                            <tr>
                                                <?php $productTitle = DB::table('products')
                                                    ->where('id', $product->product_id)
                                                    ->first(); ?>
                                                <td>{{ $productTitle->title }}</td>
                                                <?php $userName = DB::table('users')
                                                    ->where('id', $product->user_id)
                                                    ->first(); ?>
                                                <td>{{ $userName->name }}</td>
                                                <td>
                                                    @if ($product->file != '')
                                                        <a href="{{ asset("uploads/zip/$product->file") }}">Download</a>
                                                    @endif
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
                            {{ $products->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
