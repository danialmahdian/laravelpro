{{--<ul>--}}
{{--    @foreach($categories as $category)--}}
{{--    <li>--}}
{{--        {{ $category->name }}--}}
{{--        @if($category->child)--}}
{{--            @include('layouts.list-categories', ['categories' => $category->child])--}}
{{--        @endif--}}
{{--    </li>--}}
{{--    @endforeach--}}
{{--</ul>--}}

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @foreach($categories->chunk(4) as $category)
                            <div class="col-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $product->title }}</h5>
                                        <p class="card-text">{{ $product->description }}</p>
                                        <a href="/products/{{ $product->id }}" class="btn btn-primary">جزئیات محصول</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
