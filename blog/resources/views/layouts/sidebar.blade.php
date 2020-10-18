<div class="col-lg-4 sidebar-widgets">
    <div class="widget-wrap">
        <div class="single-sidebar-widget post-category-widget">
            <h4 class="single-sidebar-widget__title">Category</h4>
            <ul class="cat-list mt-20">
                @foreach($categories as $cat)
                <li>
                    <a href="{{ url('category') .'/'.$cat->id}}" class="d-flex justify-content-between">
                        <p>{{ $cat->name }}</p>
                        <p>({{ $cat->posts_count }})</p>
                    </a>
                </li>
                @endforeach
            </ul>
            <div class="single-sidebar-widget popular-post-widget">
                <h4 class="single-sidebar-widget__title">Popular Post</h4>
                <div class="popular-post-list">
                    @foreach($popularPosts as $ppost)
                    <div class="single-post-list">
                        <div class="thumb">
                            <img class="card-img rounded-0" src="{{ $ppost->image }}" alt="">
                            <ul class=" thumb-info">
                                <li><a href="#">{{ $ppost->user->name }}</a></li>
                            </ul>
                        </div>
                        <div class="details mt-20">
                            <a href="{{ url('posts') .'/'.$ppost->id }}">
                                <h6>{{ $ppost->title }}</h6>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
