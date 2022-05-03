<table class="table table-striped table-bordered table-hover" id="example1" cellspacing="0"
                width="100%">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Title</th>
                        <!-- <th>Slug</th> -->
                        <th>Image</th>
                        <th>Publish</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($details as $key=>$detail)

                <tr>
                <td>{{$key+1}}</td>
                <td>{{$detail->title}}</td>
                <!-- <td>{{$detail->slug}}</td> -->
                <td>
                @if($detail->image)
                    <img src="{{asset('images/listing/'.$detail->image)}}">
                    @else
                    <p>N/A</p>
                @endif
			</td>
                <td>{{$detail->publish==1? 'Published':'Not published'}}</td>
                <td>
                <a title="view" class="btn btn-success btn-sm" href="{{route('offer.view',$detail->id)}}">
                    <i class="fa fa-eye"></i>
                </a> 
                <!-- <button type="button" title="View" class="btn btn-success btn-sm view" onclick="viewrole({{ $detail->id }})" data-id="{{$detail->id}}">
                    <i class="fa fa-eye"></i>
                </button> -->
                <a title="Edit" class="btn btn-primary btn-sm" href="{{route('offer.edit',$detail->id)}}">
                    <i class="fa fa-edit"></i>
                </a> 
                <button class="btn btn-danger delete" onclick="deleteOffer({{ $detail->id }})"  class="btn btn-danger" style="display:inline"><i class="fa fa-trash"></i></button>
                </td>
                </tr>
                @empty
        <tr>
            <td colspan="3">No Records </td>
        </tr>
        @endforelse
        

                    
                </tbody>

            </table>
 
 

            <script> 
            function viewrole(id){
                debugger
                $.ajax({ 
           type: "get", 
		//   url: url,

           url:"/api/view-role", 
           data:{id:id},
           success: function(response) {
               console.log(response.data.id)
            //    $('#appendRole').html(response.html)
                // $("#modal-body #title").html(response.data.name);
                // $('#myModal').modal('show');
        //    location.reload();
           }
       });
            }
            </script>