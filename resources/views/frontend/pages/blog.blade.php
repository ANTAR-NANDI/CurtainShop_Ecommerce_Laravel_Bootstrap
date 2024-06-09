<!DOCTYPE html>
<html lang="en">

<head>

    @include('frontend.layouts.head')

</head>

<body id="blog-list-sidebar-left" class="blog">

    @include('frontend.layouts.header')


    <!-- main content -->
    <div class="main-content">
        <div id="wrapper-site">
            <div id="content-wrapper">
                <div id="main">
                    <div class="page-home">

                        <!-- breadcrumb -->
                        <nav class="breadcrumb-bg">
                            <div class="container no-index">
                                <div class="breadcrumb">
                                    <ol>
                                        <li>
                                            <a href="#">
                                                <span>Home</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <span>Blog</span>
                                            </a>
                                        </li>
                                        <!-- <li>
                                            <a href="#">
                                                <span>Sofa</span>
                                            </a>
                                        </li> -->
                                    </ol>
                                </div>
                            </div>
                        </nav>
                        <div class="container">
                            <div class="content">
                                <div class="row">
                                    <div class="sidebar-3 sidebar-collection col-lg-3 col-md-3 col-sm-4">

                                        <!-- category -->
                                        <div class="sidebar-block">
                                            <div class="title-block">Categories</div>
                                            <div class="block-content">
                                                @if(!empty($_GET['category']))
                                                @php
                                                $filter_cats=explode(',',$_GET['category']);
                                                @endphp
                                                @endif
                                                <form action="{{route('blog.filter')}}" method="POST">
                                                    @csrf
                                                    {{-- {{count(Helper::postCategoryList())}} --}}
                                                    @foreach(Helper::postCategoryList('posts') as $cat)
                                                    <div class="cateTitle hasSubCategory open level1">
                                                        <span class="arrow collapsed collapse-icons" data-toggle="collapse" data-target="#kitchen" aria-expanded="false" role="status">
                                                            <i class="zmdi zmdi-minus"></i>
                                                            <i class="zmdi zmdi-plus"></i>
                                                        </span>
                                                        <a class="cateItem" href="{{route('blog.category',$cat->slug)}}">{{$cat->title}}</a>

                                                    </div>
                                                    @endforeach
                                                </form>

                                            </div>
                                        </div>

                                        <!-- recent posts -->
                                        <div class="sidebar-block">
                                            <div class="title-block">Recent Posts</div>
                                            <div class="post-item-content">
                                                @foreach($recent_posts as $post)
                                                <div>
                                                    <div class="late-item first-child">
                                                        <a href="blog-detail.html">
                                                            <p class="content-title">{{$post->title}}</p>
                                                        </a>
                                                        @php
                                                        $author_info=DB::table('users')->select('name')->where('id',$post->added_by)->get();
                                                        @endphp
                                                        <span>
                                                            <i class="zmdi zmdi-comments"></i>@foreach($author_info as $data)
                                                            @if($data->name)
                                                            {{$data->name}}
                                                            @else
                                                            Anonymous
                                                            @endif
                                                            @endforeach
                                                        </span>
                                                        <span>
                                                            <i class="zmdi zmdi-calendar-note"></i>{{$post->created_at->format('d M, y')}}
                                                        </span>
                                                        <p class="description">{!! html_entity_decode($post->summary) !!}
                                                        </p>
                                                        <p class="remove">
                                                            <a href="{{route('blog.detail',$post->slug)}}">READ MORE</a>
                                                        </p>
                                                    </div>
                                                </div>
                                                @endforeach

                                                <!-- <div>
                                                    <div class="late-item">
                                                        <a href="blog-detail.html">
                                                            <p class="content-title">Lorem ipsum dolor sit amet</p>
                                                        </a>
                                                        <span>
                                                            <i class="zmdi zmdi-comments"></i>13 comment
                                                        </span>
                                                        <span>
                                                            <i class="zmdi zmdi-calendar-note"></i>20 APRIl 2017
                                                        </span>
                                                        <p class="description">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam
                                                            nonummy...
                                                        </p>
                                                        <p class="remove">
                                                            <a href="blog-detail.html">READ MORE</a>
                                                        </p>
                                                    </div>
                                                </div> -->
                                            </div>
                                        </div>

                                        <!-- product tag -->
                                        <div class="sidebar-block product-tags">
                                            <div class="title-block">
                                                Blog Tags
                                            </div>
                                            <div class="block-content">
                                                <ul class="listSidebarBlog list-unstyled">
                                                    <!-- <li>
                                                        <a href="#" title="Show products matching tag Hot Trend">Hot Trend</a>
                                                    </li>

                                                    <li>
                                                        <a href="#" title="Show products matching tag Jewelry">Jewelry</a>
                                                    </li>

                                                    <li>
                                                        <a href="man.html" title="Show products matching tag Man">Man</a>
                                                    </li>

                                                    <li>
                                                        <a href="#" title="Show products matching tag Party">Party</a>
                                                    </li>

                                                    <li>
                                                        <a href="#" title="Show products matching tag SamSung">SamSung</a>
                                                    </li>

                                                    <li>
                                                        <a href="#" title="Show products matching tag Shirt Dresses">Shirt Dresses</a>
                                                    </li> -->

                                                    @if(!empty($_GET['tag']))
                                                    @php
                                                    $filter_tags=explode(',',$_GET['tag']);
                                                    @endphp
                                                    @endif
                                                    <form action="{{route('blog.filter')}}" method="POST">
                                                        @csrf
                                                        @foreach(Helper::postTagList('posts') as $tag)

                                                        <li>
                                                            <a href="{{route('blog.tag',$tag->title)}}">{{$tag->title}} </a>
                                                        </li>

                                                        @endforeach
                                                    </form>
                                                </ul>
                                            </div>
                                        </div>

                                        <!-- advertising -->
                                        <div class="sidebar-block group-image-special">
                                            <div class="effect">
                                                <a href="#">
                                                    <img class="img-fluid" src="{{asset('frontend/img/blog/advertising.jpg')}}" alt="banner-2" title="banner-2">
                                                </a>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-sm-8 col-lg-9 col-md-9 flex-xs-first main-blogs">
                                        <h2>Recent Posts</h2>
                                        @foreach($recent_posts as $post)
                                        <div class="list-content row">
                                            <div class="hover-after col-md-5 col-xs-12">
                                                <a href="blog-detail.html">
                                                    <img src="{{asset('/uploads/images/posts'). '/' . $post->photo}}" alt="{{$post->photo}}" alt="img">
                                                </a>
                                            </div>
                                            <div class="late-item col-md-7 col-xs-12">
                                                <p class="content-title">
                                                    <a href="{{route('blog.detail',$post->slug)}}">{{$post->title}}</a>
                                                </p>
                                                <p class="post-info">
                                                    <span>{{$post->created_at->format('d M, y')}}</span>

                                                    @php
                                                    $author_info=DB::table('users')->select('name')->where('id',$post->added_by)->get();
                                                    @endphp
                                                    <span>@foreach($author_info as $data)
                                                        @if($data->name)
                                                        {{$data->name}}
                                                        @else
                                                        Anonymous
                                                        @endif
                                                        @endforeach</span>
                                                </p>
                                                <p class="description">{!! html_entity_decode($post->summary) !!}
                                                </p>
                                                <span class="view-more">
                                                    <a href="{{route('blog.detail',$post->slug)}}">view more</a>
                                                </span>
                                            </div>
                                        </div>
                                        
                                        @endforeach
                                        <div class="col-12">
                                            <!-- Pagination -->
                                            
                                            <!--/ End Pagination -->
                                        </div>
                                        <!-- <div class="list-content row">
                                            <div class="hover-after col-md-5 col-xs-12">
                                                <a href="blog-detail.html">
                                                    <img src="img/blog/5.jpg" alt="img">
                                                </a>
                                            </div>
                                            <div class="late-item col-md-7 col-xs-12">
                                                <p class="content-title">
                                                    <a href="blog-detail.html">Lorem ipsum dolor sit amet</a>
                                                </p>
                                                <p class="post-info">
                                                    <span>3 minitunes ago</span>
                                                    <span>113 Comments</span>
                                                    <span>TIVATHEME</span>
                                                </p>
                                                <p class="description">Proin gravida nibh vel velit auctor aliquet. Aenean sollicudin, lorem quis
                                                    bibendum auctor, nisi elit consequat ipsum, elit. Duis sed odio sit amet
                                                    nibh vultate cursus a sit amet mauris. Proin gravida...
                                                </p>
                                                <span class="view-more">
                                                    <a href="blog-detail.html">view more</a>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="list-content row">
                                            <div class="hover-after col-md-5 col-xs-12">
                                                <a href="blog-detail.html">
                                                    <img src="img/blog/6.jpg" alt="img">
                                                </a>
                                            </div>
                                            <div class="late-item  col-md-7 col-xs-12">
                                                <p class="content-title">
                                                    <a href="blog-detail.html">Lorem ipsum dolor sit amet</a>
                                                </p>
                                                <p class="post-info">
                                                    <span>3 minitunes ago</span>
                                                    <span>113 Comments</span>
                                                    <span>TIVATHEME</span>
                                                </p>
                                                <p class="description">Proin gravida nibh vel velit auctor aliquet. Aenean sollicudin, lorem quis
                                                    bibendum auctor, nisi elit consequat ipsum, elit. Duis sed odio sit amet
                                                    nibh vultate cursus a sit amet mauris. Proin gravida...
                                                </p>
                                                <span class="view-more">
                                                    <a href="blog-detail.html">view more</a>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="list-content row">
                                            <div class="hover-after col-md-5 col-xs-12">
                                                <a href="blog-detail.html">
                                                    <img src="img/blog/7.jpg" alt="img">
                                                </a>
                                            </div>
                                            <div class="late-item col-md-7 col-xs-12">
                                                <p class="content-title">
                                                    <a href="blog-detail.html">Lorem ipsum dolor sit amet</a>
                                                </p>
                                                <p class="post-info">
                                                    <span>3 minitunes ago</span>
                                                    <span>113 Comments</span>
                                                    <span>TIVATHEME</span>
                                                </p>
                                                <p class="description">Proin gravida nibh vel velit auctor aliquet. Aenean sollicudin, lorem quis
                                                    bibendum auctor, nisi elit consequat ipsum, elit. Duis sed odio sit amet
                                                    nibh vultate cursus a sit amet mauris. Proin gravida...
                                                </p>
                                                <span class="view-more">
                                                    <a href="blog-detail.html">view more</a>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="list-content row">
                                            <div class="hover-after col-md-5 col-xs-12">
                                                <a href="blog-detail.html">
                                                    <img src="img/blog/8.jpg" alt="img">
                                                </a>
                                            </div>
                                            <div class="late-item col-md-7 col-xs-12">
                                                <p class="content-title">
                                                    <a href="blog-detail.html">Lorem ipsum dolor sit amet</a>
                                                </p>
                                                <p class="post-info">
                                                    <span>3 minitunes ago</span>
                                                    <span>113 Comments</span>
                                                    <span>TIVATHEME</span>
                                                </p>
                                                <p class="description">Proin gravida nibh vel velit auctor aliquet. Aenean sollicudin, lorem quis
                                                    bibendum auctor, nisi elit consequat ipsum, elit. Duis sed odio sit amet
                                                    nibh vultate cursus a sit amet mauris. Proin gravida...
                                                </p>
                                                <span class="view-more">
                                                    <a href="blog-detail.html">view more</a>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="list-content row">
                                            <div class="hover-after col-md-5 col-xs-12">
                                                <a href="blog-detail.html">
                                                    <img src="img/blog/9.jpg" alt="img">
                                                </a>
                                            </div>
                                            <div class="late-item  col-md-7 col-xs-12">
                                                <p class="content-title">
                                                    <a href="blog-detail.html">Lorem ipsum dolor sit amet</a>
                                                </p>
                                                <p class="post-info">
                                                    <span>3 minitunes ago</span>
                                                    <span>113 Comments</span>
                                                    <span>TIVATHEME</span>
                                                </p>
                                                <p class="description">Proin gravida nibh vel velit auctor aliquet. Aenean sollicudin, lorem quis
                                                    bibendum auctor, nisi elit consequat ipsum, elit. Duis sed odio sit amet
                                                    nibh vultate cursus a sit amet mauris. Proin gravida...
                                                </p>
                                                <span class="view-more">
                                                    <a href="blog-detail.html">view more</a>
                                                </span>
                                            </div>
                                        </div> -->
                                        <div class="page-list col">
                                            <ul class="justify-content-center d-flex">
                                                <li>
                                                    <a rel="prev" href="#" class="previous disabled js-search-link">
                                                        Previous
                                                    </a>
                                                </li>
                                                <li class="current active">
                                                    <a rel="nofollow" href="#" class="disabled js-search-link">
                                                        1
                                                    </a>
                                                </li>
                                                <li>
                                                    <a rel="nofollow" href="#" class="disabled js-search-link">
                                                        2
                                                    </a>
                                                </li>
                                                <li>
                                                    <a rel="next" href="#" class="next disabled js-search-link">
                                                        Next
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- main content -->

    @include('frontend.layouts.footer')
</body>

</html>