@extends('master')
@section('content')
<!--================ Hero sm Banner start =================-->
<section class="mb-30px">
    <div class="container">
        <div class="hero-banner hero-banner--sm">
            <div class="hero-banner__content">
                <h1>{{ $post->title }}</h1>
                <nav aria-label="breadcrumb" class="banner-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $post->title }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!--================ Hero sm Banner end =================-->




<!--================ Start Blog Post Area =================-->
<section class="blog-post-area section-margin">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="main_blog_details">
                    <img class="img-fluid" src="{!! $post->image !!}" alt="" />
                    <a href="#">
                        <h4>{{ $post->title }}</h4>
                    </a>
                    <div class="user_details">
                        <div class="float-left">
                            <a href="#">{{ $post->category->name }}</a>
                        </div>
                        <div class="float-right mt-sm-0 mt-3">
                            <div class="media">
                                <div class="media-body">
                                    <h5>{{ $post->user->name }}</h5>
                                    <p>{{ $post->created_at }}</p>
                                </div>
                                {{-- <div class="d-flex">
                                    <img width="42" height="42" src="img/blog/user-img.png" alt="">
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <p>MCSE boot camps have its supporters and its detractors. Some people do not understand why you should have to spend money on boot camp when you can get the MCSE study materials yourself at a fraction of the camp price. However, who has the willpower</p>
                    <p>{!! $post->content !!}</p>
                </div>


                <div class="navigation-area">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12 nav-left flex-row d-flex justify-content-start align-items-center">
                            @if($prevPost)
                            <div class="thumb">
                                <a href="#"><img class="img-fluid" width="100px" src="{{ $prevPost->image }}" alt=""></a>
                            </div>
                            <div class="arrow">
                                <a href="#"><span class="lnr text-white lnr-arrow-left"></span></a>
                            </div>

                            <div class="detials">
                                <p>Prev Post</p>
                                <a href="{{ url('posts').'/'.$prevPost->id }}">
                                    <h4>{{ $prevPost->title }}</h4>
                                </a>
                            </div>
                            @endif
                        </div>
                        <div class="col-lg-6 col-md-6 col-12 nav-right flex-row d-flex justify-content-end align-items-center">
                            @if($nextPost)
                            <div class="detials">
                                <p>Next Post</p>
                                <a href="{{ url('posts').'/'.$nextPost->id }}">
                                    <h4>{{ $nextPost->title }}</h4>
                                </a>
                            </div>
                            <div class="arrow">
                                <a href="#"><span class="lnr text-white lnr-arrow-right"></span></a>
                            </div>
                            <div class="thumb">
                                <a href="#"><img class="img-fluid" width="100px" src="{{ $nextPost->image }}" alt=""></a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Start Blog Post Siddebar -->
            @include('layouts.sidebar')
        </div>
        <!-- End Blog Post Siddebar -->
    </div>
</section>
<!--================ End Blog Post Area =================-->

@endsection
