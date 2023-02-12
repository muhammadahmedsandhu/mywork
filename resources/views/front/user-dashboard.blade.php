@extends('front.layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-7">
                @include('layouts.errorsAlert')
                <div class="card">
                    <div class="card-header">
                        <h4>Dashboard</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        @if (auth()->user()->image)
                                            <img src="{{ asset('images/' . auth()->user()->image) }}" alt="profile image"
                                                class="img-fluid profile_img">
                                        @else
                                            <img src="{{ asset('images/default.png') }}" alt="profile image"
                                                class="img-fluid">
                                        @endif
                                    </div>
                                    <?php
                                    $biddingProjects = DB::table('project_bids')
                                        ->where('user_id', auth()->user()->id)
                                        ->get();
                                    $totalEarning = 0;
                                    foreach ($biddingProjects as $biddingProject) {
                                        $totalEarning += $biddingProject->cleared_payment;
                                    }
                                    ?>
                                    <div class="col-md-12 mb-3">
                                        <input type="text" class="form-control" placeholder="Total Earning"
                                            value="Total Earnings: ${{ $totalEarning }}" readonly disabled>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <input type="text" class="form-control" placeholder="Number of Entries"
                                            value="{{ auth()->user()->total_entries }}" readonly disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <input type="text" class="form-control" placeholder="Name"
                                            value="{{ auth()->user()->user_name }}" readonly disabled>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <input type="text" class="form-control" placeholder="Professional headline"
                                            value="{{ auth()->user()->head_line }}" readonly disabled>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <textarea class="form-control" placeholder="Summary" rows="5" readonly disabled>{{ auth()->user()->summary }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
