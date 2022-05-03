<table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
    <thead>
        <tr class="border-0">
            <th>S.N</th>
            <th>Name</td>
            <th>Image</td>
            <th>Include in main menu</td>
            <th>Hot Category</td>
            <th>Featured</td>
            <th>Publish</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="sortable">
        @forelse ($details as $detail)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $detail->name }}</td>
            <td>
                @if($detail->image)
                <img class="img-fluid rounded" src="{{ $detail->imageUrl('thumbnail') }}" style="width: 3rem;">
                @else
                <p>N/A</p>
                @endif
            </td>
            <td>{{ $detail->include_in_main_menu == 1 ? 'Yes' : 'No' }}</td>
            <td>{{ $detail->hot_category == 1 ? 'Yes' : 'No' }}</td>
            <td>{{ $detail->is_featured == 1 ? 'Yes' : 'No' }}</td>
            <td>{{ $detail->publish == 1 ? 'Published' : 'Not published' }}</td>
            <td class="text-nowrap">
                <a title="view" class="btn btn-success btn-sm" href="{{ route('category.view',$detail->id) }}">
                    <i class="fa fa-eye"></i>
                </a>
                <a title="Edit" class="btn btn-primary btn-sm" href="{{ route('category.edit',$detail->id) }}">
                    <i class="fa fa-edit"></i>
                </a>
                <button class="btn btn-danger btn-sm delete" onclick="return confirm('Do You want to delete this category??') && deleteCategory(this,'{{ $detail->id }}')"  class="btn btn-danger" style="display:inline"><i class="fa fa-trash"></i></button>
                <!-- <button type="button" class="btn btn-danger delete" onclick="deleteCategory({{ $detail->id }})" class="btn btn-danger" style="display: inline;" title="delete"><i class="fa fa-trash"></i></button> -->
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="42">No Categories found </td>
        </tr>
        @endforelse
    </tbody>
</table>
