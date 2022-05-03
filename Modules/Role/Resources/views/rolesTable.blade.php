<table class="table table-striped table-bordered table-hover" id="appendRole" cellspacing="0"
                width="100%">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <td>Name</td>
                        <th>Publish</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($details as $key=>$detail)

                <tr>
                <td>{{$key+1}}</td>
                <td>{{$detail->name}}</td>
                <td>
                <div style="display:inline-block; width:100px" class="badge {{ $detail->publish==1 ? 'bg-primary' : 'badge-danger' }} text-capitalize">
                        {{ $detail->publish == 1 ? 'Published' : 'Not Published' }}
                        </div>
                </td>
                <td>
                <a title="view" class="btn btn-success btn-sm" href="{{route('role.view',$detail->id)}}">
                    <i class="fa fa-eye"></i>View
                </a> 
                <!-- <a title="Edit" class="btn btn-primary btn-sm" href="{{route('role.edit',$detail->id)}}">
                    <i class="fa fa-edit"></i>
                </a>  -->
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