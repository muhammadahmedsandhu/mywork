@extends('front.layouts.master')

@section('content')
    <div class="container">
        <div class="row mt-5 justify-content-center">
            @foreach ($products as $product)
            <div class="col-md-8 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row p-2 bg-white rounded">
                            <div class="col-md-8 mt-1">
                                <h5 class="text-primary">{{ $product->title }}</h5>
                                @php
                                    $strCount = strlen($product->desc);
                                @endphp
                                <p class="text-justify para mt-2 mb-0" data-desc="{{ $product->desc }}" data-desc-elem="{{ $product->id }}">
                                    {{ str()->limit($product->desc,150,"...") }}
                                    @if ($strCount > 150)
                                        <span><a data-collapsed="false" data-collapse-desc="{{ $product->id }}" href="#">Read more</a></span>
                                    @endif
                                </p>
                            </div>
                            <div class="text-end col-md-4 border-left mt-1">
                                <h4 class="mr-1">${{ $product->price }}</h4>
                                <div class="d-flex flex-column mt-5 align-items-end">
                                    @php
                                        $diff = \Carbon\Carbon::parse($product->deadline)->diffInDays();
                                        $expired = false;
                                        if(\Carbon\Carbon::now() > \Carbon\Carbon::parse($product->deadline))
                                        {
                                            $expired = true;
                                        }
                                    @endphp
                                    <a href="{{ asset("uploads/zip/$product->file") }}" class="btn btn-sm btn-outline-primary mb-4">Download attachment</a>
                                    @if ($expired == true)
                                        <span class="badge badge-pill bg-danger">Expired</span>
                                    @else
                                        <span class="badge badge-pill bg-success">Dead line : {{ $diff }} days left</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            @endforeach
        </div>
        <div class="row mt-5">
            <div class="col-12 d-flex justify-content-center">
                {{ $products->links("pagination::bootstrap-5") }}
            </div>
        </div>
    </div>
@endsection

@section('custom_script')
    <script>
        $("a[data-collapse-desc]").each(function(){
            $(this).click(function() {
                let prId = $(this).data("collapse-desc");

                var elem = $(`p[data-desc-elem='${prId}']`);

                let desc = elem.data("desc");

                elem.html(desc);
                
            });
        });
    </script>
@endsection