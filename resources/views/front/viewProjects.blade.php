@extends('front.layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-12 mb-4">
                <h3 class="text-center">Project List</h3>
            </div>
            @if (count($projectBids) > 0)
                @foreach ($projectBids as $projectBid)
                    <div class="card m-2 @if ($projectBid->status == 'rejected') bg-secondary text-white @endif"
                        style="width: 18rem;">
                        <div
                            class="border-bottom border-black pb-2 mb-3 mt-2 d-flex justify-content-between align-items-center">
                            <?php $user = App\Models\User::find($projectBid->user_id); ?>
                            <h5 class="card-title">{{ $user->user_name }}
                            </h5>
                            @if ($projectBid->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($projectBid->status == 'approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif($projectBid->status == 'rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </div>
                        @if ($projectBid->file != '')
                            @if ($projectBid->status == 'rejected')
                                @if (in_array(pathinfo($projectBid->file, PATHINFO_EXTENSION), ['png', 'jpg', 'jpeg', 'gif', 'svg', 'webp']))
                                    <img src="{{ asset("uploads/zip/$projectBid->file") }}" class="card-img-top"
                                        alt="..." height="250px">
                                @else
                                    <img src={{ asset('frontend-assets/images/default_project_img1.png') }}
                                        class="card-img-top" alt="..." height="250px">
                                @endif
                            @else
                                @if (in_array(pathinfo($projectBid->file, PATHINFO_EXTENSION), ['png', 'jpg', 'jpeg', 'gif', 'svg', 'webp']))
                                    <a href="{{ asset("uploads/zip/$projectBid->file") }}" data-lightbox="image-1">
                                        <img src="{{ asset("uploads/zip/$projectBid->file") }}" class="card-img-top"
                                            alt="..." height="250px">
                                    </a>
                                @else
                                    <a href="{{ asset('frontend-assets/images/default_project_img1.png') }}"
                                        data-lightbox="image-1">
                                        <img src={{ asset('frontend-assets/images/default_project_img1.png') }}
                                            class="card-img-top" alt="..." height="250px">
                                    </a>
                                @endif
                            @endif
                        @endif

                        <div class="card-body border-top border-black mt-2">
                            <a download="" href="{{ asset("uploads/zip/$projectBid->file") }}"
                                class="btn btn-primary w-100 @if ($projectBid->status == 'rejected') disabled @endif">Download</a>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-md-12">
                    <div class="alert alert-danger text-center">
                        No project submitted yet
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
