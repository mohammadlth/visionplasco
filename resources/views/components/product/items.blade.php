@foreach($products as $value)
    @include('components.product.card' , ['product' => $value])
@endforeach
