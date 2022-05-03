<table class="table table-striped table-responsive-sm table-bordered table-hover" id="example-table" style="width:100%">
    <thead>
        <tr class="border-0">
            <th>S.N</th>
            <th>Title</th>
            <th>Image</th>
            <th style="width: 30%">Link</th>
            <th>Publish</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="sortable">
        @forelse ($details as $key=>$detail)

        <tr>
            <td>{{$key+1}}</td>
            <td>{{$detail->title}}</td>
            <td>
                @if($detail->image)
                <img src="{{asset('images/listing/'.$detail->image)}}">
                @else
                <p>N/A</p>
                @endif
            </td>
            <td>{{$detail->link}}</td>

            <td>{{$detail->status=='Publish'? 'Published':'Not published'}}</td>
            <td>
                <a title="Edit" class="btn btn-primary btn-sm" href="{{route('advertisement.edit',$detail->id)}}">
                    <i class="fa fa-edit"></i>
                </a>
                <button class="btn btn-danger btn-sm delete" onclick="deleteAdvertisement({{ $detail->id }})" class="btn btn-danger" style="display:inline"><i class="fa fa-trash"></i></button>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="3">No Records </td>
        </tr>
        @endforelse
    </tbody>
</table>