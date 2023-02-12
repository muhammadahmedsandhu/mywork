@extends('front.layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-7">
                @include('layouts.errorsAlert')
                <div class="card">
                    <div class="card-header">
                        <h4>Profile Setting</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('save-profile') }}" method="POST" enctype="multipart/form-data" class="row">
                            @csrf
                            <div class="col-md-6 mb-4">
                                <label class="mb-2">First Name*</label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                    placeholder="First name..." name="first_name"
                                    value="{{ auth()->user()->first_name ? auth()->user()->first_name : old('first_name') }}">
                                @error('first_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="mb-2">Last Name*</label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                    placeholder="Last name..." name="last_name"
                                    value="{{ auth()->user()->last_name ? auth()->user()->last_name : old('last_name') }}">
                                @error('last_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="mb-2">Payment receiving method*</label>
                                <select class="form-control" name="payment_method">
                                    <option value="easypaisa"
                                        {{ auth()->user()->payment_method == 'easypaisa' ? 'selected' : '' }}>Easypaisa
                                    </option>
                                    <option value="jazzcash"
                                        {{ auth()->user()->payment_method == 'jazzcash' ? 'selected' : '' }}>Jazzcash
                                    </option>
                                    <option value="bank" {{ auth()->user()->payment_method == 'bank' ? 'selected' : '' }}>
                                        Bank</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="mb-2">Correct account number*</label>
                                <input type="text" class="form-control @error('account_number') is-invalid @enderror"
                                    placeholder="Account number..." name="account_number"
                                    value="{{ auth()->user()->account_number ? auth()->user()->account_number : old('account_number') }}">
                                @error('account_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="mb-2">Correct account name*</label>
                                <input type="text" class="form-control @error('account_name') is-invalid @enderror"
                                    placeholder="Account ower name..." name="account_name"
                                    value="{{ auth()->user()->account_name ? auth()->user()->account_name : old('account_name') }}">
                                @error('account_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="mb-2">Professional Headline*</label>
                                <input type="text" class="form-control @error('head_line') is-invalid @enderror"
                                    placeholder="Professional Headline..." name="head_line"
                                    value="{{ auth()->user()->head_line ? auth()->user()->head_line : old('head_line') }}">
                                @error('head_line')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="mb-2">Profile Image*</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                    placeholder="Profile Image..." name="image"
                                    value="{{ auth()->user()->image ? auth()->user()->image : old('image') }}">
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-4">
                                <label class="mb-2">Summary about you*</label>
                                <textarea class="form-control " placeholder="Summary about you..." name="summary">{{ auth()->user()->summary ? auth()->user()->summary : old('summary') }}</textarea>
                                @error('summary')
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
