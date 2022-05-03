<table class="table table-striped table-bordered table-hover" id="appendRole" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>S.N</th>
            <th>Title</th>
            <th>Publish</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($details as $key=>$detail)

        <tr>
            <td>{{$key+1}}</td>
            <td>{{ucfirst($detail->title)}}</td>
            <td>{{$detail->publish==1? 'Published':'Not published'}}</td>
            <td>
                {{-- <a title="view" class="btn btn-success btn-sm" href="{{route('brand.view',$detail->id)}}">
                <i class="fa fa-eye"></i>
                </a> --}}
                <a title="Edit" class="btn btn-primary btn-sm" href="{{route('productattribute.edit',$detail->id)}}">
                    <i class="fa fa-edit"></i>
                </a>
                {{-- <button class="btn btn-danger delete" onclick="deleteBrand({{ $detail->id }})" class="btn
                btn-danger"
                style="display:inline"><i class="fa fa-trash"></i></button> --}}
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4">No Records </td>
        </tr>
        @endforelse
    </tbody>

</table>
