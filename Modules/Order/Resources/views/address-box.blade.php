 <div class="card">
     <div class="card-body">
         <h6 class="h6-responsive">{{ $title }}</h6>
         <div>{{ $address->full_name }}</div>
         <div>{{ $address->phone }}</div>
         <div>{{ $address->email }}</div>
         <div>{{ $address->company_name }}</div>
         <div>{{ $address->vat }}</div>
         <address>
             <div>
                 {{ $address->street_address }}
             </div>
             @if ($address->nearest_landmark)
             <div>
                 Near {{ $address->nearest_landmark }}
             </div>
             @endif
             <div>
                 {{ $address->city }}
                 <span>,</span>
                 {{ $address->country }}
             </div>
         </address>
         {{-- <table class="table table-sm mt-3">
             <tbody>
                 <tr>
                     <th>Full Name</th>
                     <td>{{ @$address->full_name }}</td>
                 </tr>
                 <tr>
                     <th>Company</th>
                     <td>
                         <div>{{ @$address->company_name }}</div>
                         <div>{{ @$address->vat }}</div>
                     </td>
                 </tr>
                 <tr>
                     <th>Address</th>
                     <td>
                         <address>
                             <div>
                                 {{ @$address->street_address }}
                             </div>
                             <div>
                                 Near {{ @$address->nearest_landmark }}
                             </div>
                             <div>
                                 {{ @$address->city }}
                                 <span>,</span>
                                 {{ @$address->country }}
                             </div>
                         </address>
                     </td>
                 </tr>
                 <tr>
                     <th>Contact</th>
                     <td>
                         <div>Mobile: {{ @$address->phone }}</div>
                         <div>Email: {{ @$address->email }}</div>
                     </td>
                 </tr>
             </tbody>
         </table> --}}
     </div>
 </div>
