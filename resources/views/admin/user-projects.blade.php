@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-5">
            @include('layouts.errorsAlert')
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Approved Projects</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>Project Title</th>
                                        <th>Amount</th>
                                        <th>Payment Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($projects) > 0)
                                        @foreach ($projects as $project)
                                            <?php
                                            $projectDetail = DB::table('products')
                                                ->where('id', $project->product_id)
                                                ->first();
                                            ?>
                                            <tr>
                                                <td>{{ $projectDetail->title }}</td>
                                                <td>
                                                    {{ $projectDetail->price_per_work }}
                                                </td>
                                                <td class="w-25">
                                                    <form action="{{ route('update-payment-status') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $project->id }}">
                                                        <div class="form-group d-flex">
                                                            <select name="payment_status" id="status"
                                                                class="form-control project_status">
                                                                <option value="approved"
                                                                    {{ $project->cleared_payment > 0 ? 'selected' : '' }}>
                                                                    Approved</option>
                                                                <option value="pending"
                                                                    {{ $project->cleared_payment == 0 ? 'selected' : '' }}>
                                                                    Pending
                                                                </option>
                                                            </select>
                                                            <button type="submit"
                                                                class="btn btn-primary ms-2">Update</button>
                                                        </div>
                                                    </form>
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
                            {{ $projects->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
