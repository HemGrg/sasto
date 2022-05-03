<table class="table custom-table table-responsive-sm table-hover" id="example-table" cellspacing="0" width="100%">
    <thead>
        <tr class="border-0">
            <th>SN</th>
            <th>Image</th>
            <th style="width: 30%">Title</th>
            @if( auth()->user()->hasAnyRole('super_admin|admin'))
            <th>Vendor</th>
            @endif
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="sortable">
        @forelse ($products as $product)
        <tr>
            <td>{{ $products->firstItem() + $loop->index }}</td>
            <td>
                @if($product->image)
                <img class="rounded" src="{{ $product->imageUrl('thumbnail') }}" style="width: 4rem;">
                @else
                <p>N/A</p>
                @endif
            </td>
            <td>{{ $product->title }}</td>
            @if( auth()->user()->hasAnyRole('super_admin|admin'))
            <td>{{ @$product->user->vendor->shop_name }}</td>
            @endif
            <td>
                <input type="checkbox" id="toggle-event" data-toggle="toggle" class="ProductStatus btn btn-success btn-sm" rel="{{$product->id}}" data-on="Active" data-off="Inactive" data-onstyle="success" data-offstyle="danger" data-size="mini" @if($product->status == 1) checked @endif>
            </td>
            <td>
                <a title="view" class="btn btn-success btn-sm" href="{{route('product.view',$product->id)}}">
                    <i class="fa fa-eye"></i>View
                </a>

                <a title="Edit" class="btn btn-primary btn-sm" href="{{route('product.edit',$product->id)}}">
                    <i class="fa fa-edit"></i>Edit
                </a>
                <!-- <button class="btn btn-danger btn-sm delete" onclick="deleteProduct(this,'{{ $product->id }}')" style="display:inline"><i class="fa fa-trash"></i></button> -->
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8">No Products Yet </td>
        </tr>
        @endforelse
    </tbody>
</table>
