@extends('master')
@section('css')
<style>
    .blog-pagination nav {
        padding-top: 10px;
        justify-content: center !important;
        display: flex !important;
    }

</style>
@endsection

@section('content')
<!--================ Hero sm Banner start =================-->
<section id="main" v-cloak>

    <section class="mb-30px">
        <div class="container">
            <div class="hero-banner hero-banner--sm">
                <div class="hero-banner__content">
                    <h1>{{ $category->name }}</h1>
                    <nav aria-label="breadcrumb" class="banner-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
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
                    <div class="row">
                        <div class="col-md-6" v-for="post in posts">
                            <div class="single-recent-blog-post card-view">
                                <div class="thumb">
                                    <img class="card-img rounded-0" :src="post.image" alt="">
                                    <ul class="thumb-info">
                                        <li><a href="#"><i class="ti-user"></i>@{{ post.user.name }}</a></li>
                                        {{-- <li><a href="#"><i class="ti-notepad"></i>@{{ post.created_at }}</a></li> --}}
                                    </ul>
                                </div>
                                <div class="details mt-20">
                                    <a href="#" @click="getPostUrl(post)">
                                        <h3>@{{ post.title }}</h3>
                                    </a>
                                    <p>@{{ getPostDescripton(post) }}</p>
                                    <a class="button" href="#" @click="getPostUrl(post)">Read More <i class="ti-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 justify-content-center blog-pagination">
                                {!! $posts->links('pagination::bootstrap-4') !!}
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
</section>

@endsection
@section('js')
<script type="text/javascript">
    var baseUrl = "{{ url('/posts') }}";
    var documentInsatnce = new Vue({
        el: '#main'
        , data: {
            posts: @json($posts->getCollection())
        , }
        , methods: {
            getPostDescripton: function(post) {
                if (post.content.length > 220) {
                    //trim the string to the maximum length
                    var trimmedString = post.content.substr(0, 220);
                    //re-trim if we are in the middle of a word and
                    trimmedString = trimmedString.substr(0, Math.min(trimmedString.length, trimmedString.lastIndexOf(" ")))
                    return trimmedString;
                }
                return post.content;
            }
            , getPostUrl: function(post) {
                    window.location.href = baseUrl + '/' + post.id;
                }

        , }
    });

</script>
@endsection
