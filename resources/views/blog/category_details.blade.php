
@extends('blog.layouts.master')
@section('content')

<body>
    <div id="wrapper">

        <section class="section wb">
            <div class="container" id="app">
                <div class="row">
                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                  
                    <h2 style="font-size: 40px;">{{$category->name}}</h2>
                    <hr style="border: 1px solid;">
                        <div class="page-wrapper">
                            <div class="blog-list clearfix">
                            @foreach($category->posts as $post)
                                <div class="blog-box row">
                                    <div class="col-md-4">
                                        <div class="post-media">
                                            <a href="#" title="">
                                                <img src="{{asset('uploads/Posts/'.$post->image)}}" alt="" class="img-fluid">
                                                <div class="hovereffect"></div>
                                            </a>
                                        </div><!-- end media -->
                                    </div><!-- end col -->
                                    <div class="blog-meta big-meta col-md-8" style="color:#000 !important;">
                                       @foreach($post->categories as $category)
                                        <span class="bg-aqua" style="margin-right:10px;"><a href="{{url('/category-details/'.$category->id)}}" title="">{{$category->name}}</a></span>
                                        @endforeach
                                        <h4><a href="{{url('/post-details/'.$post->id)}}" title="">{{$post->title}}</a></h4>
                                         {!! $post->subtitle !!} <br>
                                        <small><a href="#" title=""><i class="fa fa-thumbs-up"></i> 1887</a></small>
                                        <small><a href="#" title="">{{$post->created_at->diffForHumans()}}</a></small>
                                        <small><a href="#" title="">by Matilda</a></small>
                                    </div>
                                </div><!-- end blog-box -->
                                @endforeach
                                <hr class="invis">
                            </div><!-- end blog-list -->
                        </div><!-- end page-wrapper -->

                        <hr class="invis">

                        <div class="row">
                            <div class="col-md-12">
                           
                            </div>
                        </div><!-- end row -->
                    </div><!-- end col -->

                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                        <div class="sidebar">
                            <div class="widget">
                                <h2 class="widget-title">Search</h2>
                                <form class="form-inline search-form" action="{{url('/')}}">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="search" placeholder="Search Posts" value="{{isset($post_search) ? $post_search : ''}}">
                                    </div>
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                </form>
                            </div><!-- end widget -->

                            <div class="widget">
                                <h2 class="widget-title">Recent Posts</h2>
                                <div class="blog-list-widget">
                                    <div class="list-group">
                                    @foreach($latestPost as $latestPost)
                                        <a href="{{url('/post-details/'.$latestPost->id)}}" class="list-group-item list-group-item-action flex-column align-items-start">
                                            <div class="w-100 justify-content-between">
                                                <img src="{{asset('uploads/Posts/'.$latestPost->image)}}" alt="" class="img-fluid float-left">
                                                <h5 class="mb-1">{{ $latestPost->title }}</h5>
                                                <small>{{$latestPost->created_at->diffForHumans()}}</small>
                                            </div>
                                        </a>
                                        @endforeach
                                    </div>
                                </div><!-- end blog-list -->
                            </div><!-- end widget -->

                        </div><!-- end sidebar -->
                    </div><!-- end col -->
                </div><!-- end row -->
            </div><!-- end container -->
        </section> 
    </div><!-- end wrapper -->

</body>
@endsection