@props(['field'])
@error($field)
<div class="invalid-feedback" role="alert">
    {{ $message  }}
</div>
@enderror