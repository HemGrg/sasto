<table class="table table-bordered">
    <thead>
      <tr>
        <th>Partner Request </th>
        <th>Details</th>
      </tr>
    </thead>
    <tbody>
      <tr class="danger">
        <td>Company Name</td>
        <td>{{$detail->company_name}}</td>
      </tr>
      <tr class="danger">
        <td>Company Email</td>
        <td>{{$detail->company_email}}</td>
      </tr>
      <tr class="danger">
        <td>Company Phone</td>
        <td>{{$detail->company_phone}}</td>
      </tr>
      <tr class="danger">
        <td>Partner Type</td>
        <td>{{$detail->PartnerType->name}}</td>
      </tr>
      <tr class="danger">
        <td>Established Year</td>
        <td>{{$detail->eastablished_year}}</td>
      </tr>
      <tr class="danger">
        <td>Website</td>
        <td>{{$detail->company_web}}</td>
      </tr>
      <tr class="danger">
        <td>Email:</td>
        <td>{{ $detail->email }}</td>
      </tr>
      <tr class="danger">
        <td>Name</td>
        <td>{{ $detail->full_name }}</td>
      </tr>
      <tr class="danger">
        <td>Address</td>
        <td>{{$detail->address }}</td>
      </tr>
      <tr class="warning">
        <td>Designation</td>
        <td>{{$detail->designation}}</td>
      </tr>
      <tr class="danger">
        <td>Phone</td>
        <td>{{$detail->phone}}</td>
      </tr>
    </tbody>
  </table>