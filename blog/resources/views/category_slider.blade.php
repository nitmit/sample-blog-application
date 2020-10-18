    <!--================ Blog slider start =================-->
    <section>
        <div class="container">
            <div class="owl-carousel owl-theme blog-slider">
                @foreach($categories as $cat)
                <div class="card blog__slide text-center">
                    <div class="blog__slide__img">
                        <img class="card-img rounded-0" src="{{ asset('img/cat') . '/' . $cat->image}}" alt=" {{ $cat->name }}">

                    </div>
                    <div class="blog__slide__content">
                        <a class="blog__slide__label" href="{{ url('category') .'/'.$cat->id}}">{{$cat->name}}</a>
                        {{-- <h3><a href="#">New york fashion week's continued the evolution</a></h3>
                        <p>2 days ago</p> --}}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <!--================ Blog slider end =================-->
