@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-5">
            @include('layouts.errorsAlert')
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>User List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>User Name</th>
                                        <th>Payment Method</th>
                                        <th>Account Number</th>
                                        <th>Pending Payments</th>
                                        <th>Cleared Payments</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($users) > 0)
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->user_name }}</td>
                                                <td>
                                                    @if ($user->payment_method != null)
                                                        {{ $user->payment_method }}
                                                    @else
                                                        <span class="text-danger">N/A</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($user->account_number != null)
                                                        {{ $user->account_number }}
                                                    @else
                                                        <span class="text-danger">N/A</span>
                                                    @endif
                                                </td>
                                                <?php
                                                $biddingProjects = DB::table('project_bids')
                                                    ->where('user_id', $user->id)
                                                    ->get();
                                                $pendingAmount = 0;
                                                $clearedAmount = 0;
                                                foreach ($biddingProjects as $biddingProject) {
                                                    $pendingAmount += $biddingProject->pending_payment;
                                                    $clearedAmount += $biddingProject->cleared_payment;
                                                }
                                                ?>
                                                <td>
                                                    {{ $pendingAmount }}
                                                </td>
                                                <td>
                                                    {{ $clearedAmount }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('user-projects', ['id' => $user->id]) }}"
                                                        class="btn btn-sm btn-primary">
                                                        View Approved Projects
                                                    </a>
                                                    @if ($user->is_blocked == 0)
                                                        <a href="{{ route('block-user', ['id' => $user->id]) }}"
                                                            onclick="return confirm('Are you sure you want to block this user ?')"
                                                            class="btn btn-sm btn-danger">
                                                            Block
                                                        </a>
                                                    @else
                                                        <a href="{{ route('unblock-user', ['id' => $user->id]) }}"
                                                            onclick="return confirm('Are you sure you want to unblock this user ?')"
                                                            class="btn btn-sm btn-success">
                                                            Unblock
                                                        </a>
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
                            {{ $users->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
