<div class="grid grid-cols-1 md:grid-cols-2 gap-3">
    @foreach($templates as $value)
        @include('components.template.card' , ['template' => $value])
    @endforeach
</div>