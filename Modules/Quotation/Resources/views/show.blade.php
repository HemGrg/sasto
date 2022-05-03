@extends('layouts.admin')

@section('page_title')Quotations @endsection

@push('styles')
<style>
    #quotation-detail-table tr td {
        padding-top: 15px;
        padding-bottom: 15px;
    }

    #quotation-detail-table tr td:first-of-type {
        font-weight: 600;
        color: gray;
    }

    @media screen AND (min-width: 700px) {
        #quotation-detail-table tr td:first-of-type {
            max-width: 5rem;
        }
    }

</style>
@endpush

@section('content')
<div class="page-content fade-in-up" style="font-family: Arial, Helvetica, sans-serif;">
    <div class="container">
        <div class="mb-3">
            <a href="{{ route('quotations.index') }}" class="btn btn-primary border-0">Back to listing</a>
        </div>
        
        <x-alerts></x-alerts>
        
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Quotation Details</div>
                <em>Posted On: {{ $quotation->created_at->diffForHumans() }}</em>
            </div>
            <div class="ibox-body">
                <table id="quotation-detail-table" class="table table-borderless table-hover table-responsive-sm">
                    <tr>
                        <td>Product</td>
                        <td>{{ $quotation->purchase }}</td>
                    </tr>
                    <tr>
                        <td>Quantity</td>
                        <td>{{ $quotation->quantity }} {{ $quotation->unit }}</td>
                    </tr>
                    <tr>
                        <td>Specifications</td>
                        <td>{{ $quotation->specifications }}</td>
                    </tr>
                    <tr>
                        <td>Requested By</td>
                        <td>
                            @if($quotation->user)
                            <div>{{ $quotation->user->name }}</div>
                            <div>{{ $quotation->user->email }}</div>
                            <div>{{ $quotation->user->phone_num }}</div>
                            @else
                                <div>N/A</div>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Ship To</td>
                        <td>{{ $quotation->ship_to }}</td>
                    </tr>
                    <tr>
                        <td>Expected Price</td>
                        <td>{{ $quotation->expected_price }}</td>
                    </tr>
                    <tr>
                        <td>Expected Delivery Time</td>
                        <td>{{ $quotation->expected_del_time }}</td>
                    </tr>
                    <tr>
                        <td>Other Contact</td>
                        <td>{{ $quotation->other_contact }}</td>
                    </tr>
                    <tr>
                        <td>Link</td>
                        <td>{{ $quotation->link }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Images</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="row">
                                @if($quotation->image1)
                                <div class="col-md-3">
                                    <img src="{{ asset('storage/'.$quotation->image1) }}" class="img-thumbnail">
                                </div>
                                @endif
                                @if($quotation->image2)
                                <div class="col-md-3">
                                    <img src="{{ asset('storage/'.$quotation->image2) }}" class="img-thumbnail">
                                </div>
                                @endif
                                @if($quotation->image3)
                                <div class="col-md-3">
                                    <img src="{{ asset('storage/'.$quotation->image3) }}" class="img-thumbnail">
                                </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @if(auth()->user()->hasAnyRole('super_admin|admin'))
                    <tr>
                        <td>Forwarded To</td>
                        <td>
                            <ul class="list-group">
                                @foreach($quotation->vendors as $vendor)
                                <li class="list-group-item">
                                    {{ $vendor->shop_name}}
                                </li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        @if(auth()->user()->hasAnyRole('vendor'))
        <div class="ibox border shadow-none rounded">
            <div class="ibox-head">
                <div class="ibox-title">Your Offer</div>
                @if($myReply)
                <em>Replied On: {{ $myReply->created_at->toDateString() }}</em>
                @endif
            </div>
            <div class="ibox-body">
                @if($myReply)
                <div id="my-reply">
                    <p>
                        {{ $myReply->message }}
                    </p>
                    <button type="button" onclick="showReplyForm()" class="btn btn-primary btn-rounded border-0 px-3"><i class="fa fa-edit mr-1"></i>Change Reply</button>
                </div>
                @endif
                <form id="reply-form" action="{{ route('quotations-reply.store', $quotation) }}" method="POST"  @if($myReply) style="display: none;" @endif>
                    @csrf
                    <div class="form-group">
                        <textarea name="message" id="message" cols="30" rows="10" class="form-control">{{ old('message', $myReply->message ?? null ) }}</textarea>
                    </div>
                    <div class="form-group text-right">
                        <button class="btn btn-primary btn-lg btn-rounded border-0 px-4">Reply</button>
                    </div>
                </form>
            </div>
        </div>
        @endif
        
    </div>
</div>
@endsection

@push('push_scripts')
<script>
    function showReplyForm() {
        document.getElementById('reply-form').style.display = 'block';
        document.getElementById('my-reply').style.display = 'none';
    }
</script>
@endpush
