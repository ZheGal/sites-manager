<a 
    @if (isset($attributes['route']))
    href="{{ route($attributes['route']) }}"
    @endif
    class="btn btn-pill @if(isset($attributes['class']))btn-{{ $attributes['class'] }}@endif btn-sm">
    @if (isset($attributes['icon']))
    <i class="{{ $attributes['icon'] }}"></i> 
    @endif
    @if (isset($attributes['value'])) {{ $attributes['value']}} @endif
</a>