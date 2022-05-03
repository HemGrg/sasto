@extends('vendor_front_layouts.master')

@section('content')
  <register :countries="{{ json_encode($countries) }}" :business_types="{{json_encode(config('constants.business_type'))}}"/>
@endsection