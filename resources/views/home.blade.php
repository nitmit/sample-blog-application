@extends('master')
@section('content')
<main class="site-main" id="main" v-cloak>
    <!--================Hero Banner start =================-->
    <section class="mb-30px">
        <div class="container">
            <div class="hero-banner">
                <div class="hero-banner__content">
                    <h3>For the love of reading and spreading knowledge</h3>
                    <h1>Blogs for everyone</h1>
                    {{-- <h4>December12,2018</h4> --}}
                </div>
            </div>
        </div>
    </section>
    <!--================Hero Banner end =================-->

    <!--================ Blog slider start =================-->
    @include('category_slider')
    <!--================ Blog slider end =================-->

    <!--================ Start Blog Post Area =================-->
    <section class="blog-post-area section-margin mt-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="single-recent-blog-post" v-for="post in posts">
                        <div class="thumb">
                            <img class="img-fluid mx-auto d-block" :src="post.image" alt="">

                            <ul class="thumb-info">
                                <li><a href="#"><i class="ti-user"></i>@{{ post.user.name }}</a></li>
                                <li><a href="#"><i class="ti-notepad"></i>@{{ post.created_at }}</a></li>
                                <li><a href="#"><i class="ti-package"></i>@{{ post.category.name }}</a></li>
                            </ul>
                        </div>
                        <div class="details mt-20">
                            <a href="#" @click="getPostUrl(post)">
                                <h3>@{{ post.title }}</h3>
                            </a>
                            {{-- <p class="tag-list-inline">Tag: <a href="#">travel</a>, <a href="#">life style</a>, <a href="#">technology</a>, <a href="#">fashion</a></p> --}}
                            <p>@{{ getPostDescripton(post) }}</p>
                            <a class="button" href="#" @click="getPostUrl(post)">Read More <i class="ti-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 justify-content-center blog-pagination">
                            {!! $posts->links('pagination::bootstrap-4') !!}
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
</main>
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
