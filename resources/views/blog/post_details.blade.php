@extends('blog.layouts.master')
@section('content')
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v9.0" nonce="n1EzKOuc"></script>

<div class="page-title wb">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <h2><i class="fa fa-leaf bg-green"></i> Blog</h2>
                    </div><!-- end col -->
                    <div class="col-lg-4 col-md-4 col-sm-12 hidden-xs-down hidden-sm-down">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active">{{$postDetails->title}}</li>
                        </ol>
                    </div><!-- end col -->                    
                </div><!-- end row -->
            </div><!-- end container -->
        </div><!-- end page-title -->

        <section class="section wb">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                      
                        <div class="page-wrapper">
                            <div class="blog-title-area">
                            @foreach($postDetails->categories as $category)
                                <span class="color-green" style="float: right; margin-right: 4px;"><a href="#" title="">{{$category->name}}</a></span>
                               @endforeach
                                <h3>{{$postDetails->title}}</h3>
                                 
                                <div class="blog-meta big-meta">
                                    <small><a href="garden-single.html" title="">{{$postDetails->created_at->diffForHumans()}}</a></small>
                                    <small><a href="blog-author.html" title="">by Jessica</a></small>
                                    <small><a href="#" title=""><i class="fa fa-eye"></i> 2344</a></small>
                                </div><!-- end meta -->
                            </div><!-- end title -->
                            <div class="single-post-media">
                               
                                <img src="{{asset('uploads/Posts/'.$postDetails->image)}}" alt="" class="img-fluid">
                            
                            </div><!-- end media -->

                            <div class="blog-content">  
                                <div class="pp">
                                    {!! $postDetails->body !!}

                                </div><!-- end pp -->
                            </div><!-- end content -->
                            <div class="blog-title-area">
                                <div class="tag-cloud-single">
                                    <span>Tags</span>
                                    @foreach($postDetails->tags as $tag)
                                    <small><a href="#" title="">{{$tag->name}}</a></small>
                                    @endforeach
                                </div><!-- end meta -->
                            </div>
                        </div>
                        <hr class="invis1">
                <div class="fb-comments" data-href="{{ Request::url() }}" data-width="" data-numposts="5"></div>
        </section>
@endsection
