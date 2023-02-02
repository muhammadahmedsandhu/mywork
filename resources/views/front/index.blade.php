@extends('front.layouts.master')

@section('content')
    <div class="container">
        <div class="row mt-5 justify-content-center">
            <div class="d-flex justify-content-center mb-4">
                <a href="{{ route('home') }}" class="btn btn-primary btn-block active">Active Projects</a>
                <a href="{{ route('expired-products') }}" class="btn btn-secondary btn-block ms-3">Expired Projects</a>
            </div>
            @if (count($products) > 0)
                @foreach ($products as $product)
                    <div class="col-md-8 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row p-2 bg-white rounded">
                                    <div class="col-md-7 mt-1">
                                        <h5 class="text-primary"><a
                                                href="{{ route('project', $product->id) }}">{{ $product->title }}</a></h5>
                                        @php
                                            $strCount = strlen($product->desc);
                                        @endphp
                                        <p class="text-justify para mt-2 mb-0" data-desc="{{ $product->desc }}"
                                            data-desc-elem="{{ $product->id }}">
                                            {{ str()->limit($product->desc, 150, '...') }}
                                            @if ($strCount > 150)
                                                <span><a data-collapsed="false" data-collapse-desc="{{ $product->id }}"
                                                        href="#">Read more</a></span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="text-end col-md-5 border-left mt-1">
                                        <div class="d-flex justify-content-end">
                                            <a class="btn btn-sm btn-outline-primary mb-4 me-2"
                                                onclick='viewNotes("{{ $product->title }}", "{{ $product->notes }}")'>
                                                Important Notes
                                            </a>
                                            <?php $projects = App\Models\ProjectBid::where('product_id', $product->id)->get(); ?>
                                            <a href="view-projects/{{ $product->id }}"
                                                class="btn btn-sm btn-outline-success mb-4 me-2">
                                                @if (count($projects) > 0)
                                                    {{ count($projects) }} works submitted
                                                @else
                                                    No work submitted
                                                @endif
                                            </a>
                                            <h4 class="mr-1">${{ $product->price }}</h4>
                                        </div>
                                        <div class="d-flex flex-column mt-5 align-items-end">
                                            @php
                                                $diff = \Carbon\Carbon::parse($product->deadline)->diffInDays();
                                                $expired = false;
                                                if (\Carbon\Carbon::now() > \Carbon\Carbon::parse($product->deadline)) {
                                                    $expired = true;
                                                }
                                            @endphp
                                            <a href="{{ asset("uploads/zip/$product->file") }}"
                                                class="btn btn-sm btn-outline-primary mb-4">Download attachment</a>
                                            @if ($expired == true)
                                                <span class="badge badge-pill bg-danger">Expired</span>
                                            @else
                                                <span class="badge badge-pill bg-success">Dead line : {{ $diff }}
                                                    days
                                                    left</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-md-8 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row p-2 bg-white rounded">
                                <div class="col-md-12 mt-1">
                                    <h5 class="text-center text-danger">No products found</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="row mt-5">
            <div class="col-12 d-flex justify-content-center">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_script')
    <script>
        $("a[data-collapse-desc]").each(function() {
            $(this).click(function() {
                let prId = $(this).data("collapse-desc");

                var elem = $(`p[data-desc-elem='${prId}']`);

                let desc = elem.data("desc");

                elem.html(desc);

            });
        });

        function viewNotes(title, notes) {
            $("#exampleModalLabel").html(title);
            $(".modal-body").html(notes);
            $("#exampleModal").modal("show");
        }
    </script>
@endsection
