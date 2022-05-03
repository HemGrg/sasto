<div class="ibox">
    <ul class="plain-nav-tabs nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link @if(request()->routeIs('product.create') || request()->routeIs('product.edit')) active @endif" href="{{ $updateMode ? route('product.edit', $product) : route('product.create') }}"><strong>General Information</strong></a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if(request()->routeIs('product.pricing')) active @endif" href="{{ $updateMode ? route('product.pricing', $product) : '#' }}"><strong>Pricing</strong></a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if(request()->routeIs('product-images.*')) active @endif" href="{{ $updateMode ? route('product-images.index', $product->id) : '#' }}"><strong>Images </strong></a>
        </li>
    </ul>
</div>