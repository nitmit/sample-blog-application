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
<main class="site-main" id="main" v-cloak>
    <!--================Hero Banner start =================-->
    <section class="mb-30px">
        <div class="container">
            <div class="hero-banner">
                <div class="hero-banner__content">
                    <h1>Your Posts</h1>
                    <button class="btn btn-outline-dark" @click="openModal">Add New Post</button>
                    {{-- <h4>December12,2018</h4> --}}
                </div>
            </div>
        </div>
    </section>
    <!--================Hero Banner end =================-->



    <!--================ Start Blog Post Area =================-->
    <section class="blog-post-area section-margin mt-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    @if ($errors->any())
                    @foreach($errors->all() as $error)
                    <div class="alert alert-danger alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{$error}}
                    </div>
                    @endforeach
                    @endif

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{session('success')}}
                    </div>
                    @endif

                    <div class="card col-sm-8 offset-2">
                        <div class="card-body p-3 text-center">
                            <form>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Filter By Category</label>
                                    <div class="col-md-12">
                                        <select class="form-control custom-select" required name="category_id" v-model="selectedCategoryId" id="category_id" @change="getPosts()">
                                            <option value="">Filter By Category</option>
                                            <option v-for="cat, index in categories" :value="cat.id" :selected="selectedCategoryId == cat.id">
                                                @{{ cat.name }}</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>


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
                            <a class="button" href="#" @click="editPost(post)">Edit <i class="ti-pencil"></i></a>
                            <a class="button" href="#" @click="deletePost(post)">Delete<i class="ti-trash"></i></a>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 justify-content-center blog-pagination">
                            {!! $posts->links('pagination::bootstrap-4') !!}
                        </div>
                    </div>
                </div>

            </div>
            <!-- End Blog Post Siddebar -->
        </div>
    </section>
    <!--================ End Blog Post Area =================-->

    <!-- Post Modal-->
    <div class="modal" tabindex="-1" role="dialog" id="post-modal">
        <div class="modal-dialog modal-lg" role="document">
            <form id="post-form" class="form-horizontal" enctype="multipart/form-data" method="post" @submit.prevent="addUpdatePost()">
                {{ csrf_field() }}
                <input type="hidden" name="_method" v-model="formMethod">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@{{ modalTitle }}</h5>
                        <button type=" button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="container-fluid">
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="control-label col-sm-4">Title:*</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" v-model="title" placeholder="Enter Title" name="title" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="control-label col-sm-4">Category:*</label>
                                    <div class="col-sm-12">
                                        <select class="form-control" name="category" v-model="category" id="category" required>
                                            <option value="" selected disabled>Select Category</option>
                                            <option v-for="(cat, key) in categories" :value="cat.id" :selected="cat.id == category">&nbsp;@{{cat.name}}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="control-label col-sm-4">Image:*</label>
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <input type="file" class="form-control" name="image" :required="formMethod == 'post'">
                                        </div>
                                        <div v-show="previewImageUrl != ''" class="col-sm-4">
                                            <img :src="previewImageUrl" height="50px">
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-4">Content:*</label>
                                <div class="col-sm-12">
                                    <textarea class="form-control" name="content" v-model="content" rows=20 placeholder="Enter your content here" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeModal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary" @submit="addUpdatePost()">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- End Post Modal -->
</main>

@endsection
@section('js')
<script type="text/javascript">
    var baseUrl = "{{ url('/posts') }}";
    var documentInsatnce = new Vue({
        el: '#main'
        , data: {
            posts: @json($posts->getCollection())
            , categories: @json($categories)
            , title: ""
            , content: ""
            , category: ""
            , modalTitle: "New Post"
            , formUrl: baseUrl
            , formMethod: "post"
            , previewImageUrl: ""
            , selectedCategoryId: ""
        , }
        , mounted: function() {}
        , computed: {}
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
            , getCategoryImageUrl: function(cat) {
                return "{{ asset('img/cat') }}" + '/' + cat.image;
            }
            , setupModal: function() {
                this.title = "";
                this.content = "";
                this.category = "";
                this.formUrl = baseUrl;
                this.formMethod = "post";
                this.modalTitle = "New Post";
                this.previewImageUrl = "";
            }
            , closeModal: function() {
                this.setupModal();
                $('#post-modal').modal('hide');
            }
            , openModal: function() {
                this.setupModal();
                $('#post-modal').modal('show');
            }
            , editPost: function(post) {
                this.title = post.title;
                this.category = post.category_id;
                this.content = post.content;
                this.previewImageUrl = post.image;
                this.modalTitle = "Edit Post";
                this.formUrl = baseUrl + '/' + post.id;
                this.formMethod = "put";
                $('#post-modal').modal('show');
            }
            , addUpdatePost: function() {
                let self = this;
                let data = new FormData($('#post-form')[0]);
                $.ajax({
                    url: self.formUrl
                    , method: "post"
                    , data: data
                    , processData: false
                    , contentType: false
                    , success: function(response) {
                        if (response.errors) {
                            $.each(response.errors, function(index, error) {
                                toastr.error(error);
                            });
                            return;
                        }
                        self.closeModal();
                        location.reload();
                    }
                    , error: function(response) {
                        console.log(response);
                    }
                });
            }
            , deletePost: function(post) {
                bootbox.confirm("Are you sure you want to delete post?", function(result) {
                    if (result) {
                        $.ajax({
                            url: baseUrl + '/' + post.id
                            , data: {
                                '_token': "{{ csrf_token() }}"
                            }
                            , method: 'delete'
                            , success: function(response) {
                                location.reload();
                            }
                            , error: function(response) {
                                console.log(response);
                            }
                        });
                    }
                });
            }
            , getPosts: function() {
                console.log('hi');
                var self = this;
                if (self.selectedCategoryId != '') {
                    window.location.href = baseUrl + '?category_id=' + self.selectedCategoryId;
                    return;
                }
                window.loaction.href = baseUrl;
            }

        , }
    });

</script>
@endsection
