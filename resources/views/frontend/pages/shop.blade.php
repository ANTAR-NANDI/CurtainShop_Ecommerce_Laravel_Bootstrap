<!DOCTYPE html>
<html lang="en">

<head>

    @include('frontend.layouts.head')

</head>

<body id="product-sidebar-left" class="product-grid-sidebar-left">

    @include('frontend.layouts.header')


    <!-- main content -->
    <div class="main-content">
        <div id="wrapper-site">
            <div id="content-wrapper" class="full-width">
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
                                                <span>Shop</span>
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
                                    <div class="sidebar-3 sidebar-collection col-lg-3 col-md-4 col-sm-4">

                                        <!-- category menu -->
                                        <div class="sidebar-block">
                                            <div class="title-block">Categories</div>
                                            <div class="block-content">
                                                <div class="cateTitle hasSubCategory open level1">
                                                    <span class="arrow collapsed collapse-icons" data-toggle="collapse" data-target="#livingroom" aria-expanded="false" role="status">
                                                        <i class="zmdi zmdi-minus"></i>
                                                        <i class="zmdi zmdi-plus"></i>
                                                    </span>
                                                    @php
                                                    $menu=App\Models\Category::getAllParentWithChild();
                                                    @endphp
                                                    @if($menu)
                                                    <li>
                                                        @foreach($menu as $cat_info)
                                                        @if($cat_info->child_cat->count()>0)
                                                    <li><a href="{{route('product-cat',$cat_info->slug)}}">{{$cat_info->title}}</a>
                                                        <ul>
                                                            @foreach($cat_info->child_cat as $sub_menu)
                                                            <li><a href="{{route('product-sub-cat',[$cat_info->slug,$sub_menu->slug])}}">{{$sub_menu->title}}</a></li>
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                    @else
                                                    <li><a href="{{route('product-cat',$cat_info->slug)}}">{{$cat_info->title}}</a></li>
                                                    @endif
                                                    @endforeach
                                                    </li>
                                                    @endif
                                                    {{-- @foreach(Helper::productCategoryList('products') as $cat)
                                            @if($cat->is_parent==1)
												<li><a href="{{route('product-cat',$cat->slug)}}">{{$cat->title}}</a></li>
                                                    @endif
                                                    @endforeach --}}
                                                    <a class="cateItem" href="#">Living Room</a>
                                                    <div class="subCategory collapse" id="livingroom" aria-expanded="true" role="status">
                                                        <div class="cateTitle">
                                                            <a href="#" class="cateItem">Side Table</a>
                                                            <div class="subCategory collapse" id="subCategory-fruits" aria-expanded="true" role="status">
                                                                <div class="cateTitle">
                                                                    <a href="#" class="cateItem">Side Table</a>
                                                                </div>
                                                                <div class="cateTitle">
                                                                    <a href="#" class="cateItem">FIREPLACE</a>
                                                                </div>
                                                                <div class="cateTitle">
                                                                    <a href="#" class="cateItem">FIREPLACE</a>
                                                                </div>
                                                                <div class="cateTitle">
                                                                    <a href="#" class="cateItem">floor lamp</a>
                                                                </div>
                                                                <div class="cateTitle">
                                                                    <a href="#" class="cateItem">ottoman</a>
                                                                </div>
                                                                <div class="cateTitle">
                                                                    <a href="#" class="cateItem">armchair</a>
                                                                </div>
                                                                <div class="cateTitle">
                                                                    <a href="#" class="cateItem">cushion</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="cateTitle">
                                                            <a href="#" class="cateItem">FIREPLACE</a>
                                                        </div>
                                                        <div class="cateTitle">
                                                            <a href="#" class="cateItem">FIREPLACE</a>
                                                        </div>
                                                        <div class="cateTitle">
                                                            <a href="#" class="cateItem">floor lamp</a>
                                                        </div>
                                                        <div class="cateTitle">
                                                            <a href="#" class="cateItem">ottoman</a>
                                                        </div>
                                                        <div class="cateTitle">
                                                            <a href="#" class="cateItem">armchair</a>
                                                        </div>
                                                        <div class="cateTitle">
                                                            <a href="#" class="cateItem">cushion</a>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <!-- best seller -->
                                        <div class="sidebar-block">
                                            <div class="title-block">Catalog</div>
                                            <div class="new-item-content">
                                                <h3 class="title-product">Brand</h3>
                                                <ul class="scroll-product">
                                                    @php
                                                    $brands=DB::table('brands')->orderBy('title','ASC')->where('status','active')->get();
                                                    @endphp
                                                    @foreach($brands as $brand)
                                                    <li>
                                                        <label class="check">
                                                            <input type="checkbox">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <a href="{{route('product-brand',$brand->slug)}}">
                                                            <b>{{$brand->title}}</b>
                                                            <span class="quantity">(21)</span>
                                                        </a>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </div>

                                            <div class="tiva-filter-price new-item-content sidebar-block">
                                                <h3 class="title-product">By Price</h3>
                                                <div id="block_price_filter" class="block">
                                                    <div class="block-content">
                                                        @php
                                                        $max=DB::table('products')->max('price');
                                                        // dd($max);
                                                        @endphp
                                                        <div id="slider-range" data-min="0" data-max="{{$max}}" class="tiva-filter">
                                                            <div class="filter-itemprice-filter">
                                                                <div class="layout-slider">
                                                                    <input id="price-filter" name="price" value="0:{{$max}}" />
                                                                </div>
                                                                <div class="layout-slider-settings"></div>
                                                            </div>
                                                            <!-- extra -->
                                                            <div class="product_filter">
                                                                <button type="submit" class="filter_button">Filter</button>
                                                                <div class="label-input">
                                                                    <span>Range:</span>
                                                                    <input style="" type="text" id="amount" readonly />
                                                                    <input type="hidden" name="price_range" id="price_range" value="@if(!empty($_GET['price'])){{$_GET['price']}}@endif" />
                                                                </div>
                                                            </div>
                                                            <!-- extra end -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <!-- product tag -->
                                        <div class="sidebar-block product-tags">
                                            <div class="title-block">
                                                Product Tags
                                            </div>
                                            <div class="block-content">
                                                <ul class="listSidebarBlog list-unstyled">
                                                    <li>
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
                                                    </li>

                                                    <li>
                                                        <a href="#" title="Show products matching tag Shoes">Shoes</a>
                                                    </li>

                                                    <li>
                                                        <a href="#" title="Show products matching tag Summer">Summer</a>
                                                    </li>

                                                    <li>
                                                        <a href="#" title="Show products matching tag Sweaters">Sweaters</a>
                                                    </li>

                                                    <li>
                                                        <a href="#" title="Show products matching tag Winter">Winter</a>
                                                    </li>

                                                    <li>
                                                        <a href="#" title="Show products matching tag Woman">Woman</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-8 col-lg-9 col-md-8 product-container">
                                        <h1>Lingving Room</h1>
                                        <div class="js-product-list-top firt nav-top">
                                            <div class="d-flex justify-content-around row">
                                                <div class="col col-xs-12">
                                                    <ul class="nav nav-tabs">
                                                        <li>
                                                            <a href="#grid" data-toggle="tab" class="active show fa fa-th-large"></a>
                                                        </li>
                                                        <li>
                                                            <a href="#list" data-toggle="tab" class="fa fa-list-ul"></a>
                                                        </li>
                                                    </ul>
                                                    <div class="hidden-sm-down total-products">
                                                        <p>There are <?php echo count($products) ?> products.</p>
                                                    </div>
                                                </div>
                                                <div class="col col-xs-12">
                                                    <div class="d-flex sort-by-row justify-content-lg-end justify-content-md-end">

                                                        <div class="products-sort-order dropdown">
                                                            <select class="select-title">
                                                                <option value="">Sort by</option>
                                                                <option value="">Name, A to Z</option>
                                                                <option value="">Name, Z to A</option>
                                                                <option value="">Price, low to high</option>
                                                                <option value="">Price, high to low</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-content product-items">
                                            <div id="grid" class="related tab-pane fade in active show">
                                                <div class="row">
                                                    @if(count($products)>0)
                                                    @foreach($products as $product)
                                                    <div class="item text-center col-md-4">
                                                        <div class="product-miniature js-product-miniature item-one first-item">
                                                            <div class="thumbnail-container border">
                                                                <a href="product-detail.html">
                                                                    <img class="img-fluid image-cover" src="{{asset('/uploads/images/products'). '/' . $product->photo}}" alt="img">
                                                                    <img class="img-fluid image-secondary" src="{{asset('/uploads/images/products'). '/' . $product->photo}}" alt="img">
                                                                </a>
                                                                <div class="highlighted-informations">
                                                                    <div class="variant-links">
                                                                        <a href="#" class="color beige" title="Beige"></a>
                                                                        <a href="#" class="color orange" title="Orange"></a>
                                                                        <a href="#" class="color green" title="Green"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="product-description">
                                                                <div class="product-groups">
                                                                    <div class="product-title">
                                                                        <a href="{{route('product-detail',$product->slug)}}">{{$product->title}}</a>
                                                                    </div>
                                                                    <div class="rating">
                                                                        <div class="star-content">
                                                                            <div class="star"></div>
                                                                            <div class="star"></div>
                                                                            <div class="star"></div>
                                                                            <div class="star"></div>
                                                                            <div class="star"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="product-group-price">
                                                                        <div class="product-price-and-shipping">
                                                                            <span class="price">{{$product->price}}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="product-buttons d-flex justify-content-center">
                                                                    <form action="#" method="post" class="formAddToCart">
                                                                        <input type="hidden" name="id_product" value="1">
                                                                        <a class="add-to-cart" href="{{route('add-to-cart',$product->slug)}}" data-button-action="add-to-cart">
                                                                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                                                        </a>
                                                                    </form>
                                                                    <a class="addToWishlist" href="{{route('add-to-wishlist',$product->slug)}}" data-rel="1" onclick="">
                                                                        <i class="fa fa-heart" aria-hidden="true"></i>
                                                                    </a>
                                                                    <a href="#" class="quick-view hidden-sm-down" data-link-action="quickview">
                                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    @else
                                                    <h4 class="text-warning" style="margin:100px auto;">There are no products.</h4>
                                                    @endif
                                                </div>
                                            </div>
                                            <div id="list" class="related tab-pane fade">
                                                <div class="row">
                                                    @if(count($products)>0)
                                                    @foreach($products as $product)
                                                    <div class="item col-md-12">
                                                        <div class="product-miniature item-one first-item">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="thumbnail-container border">
                                                                        <a href="product-detail.html">
                                                                            <img class="img-fluid image-cover" src="img/product/1.jpg" alt="img">
                                                                            <img class="img-fluid image-secondary" src="img/product/22.jpg" alt="img">
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <div class="product-description">
                                                                        <div class="product-groups">
                                                                            <div class="product-title">
                                                                                <a href="product-detail.html">Nulla et justo non augue</a>
                                                                                <span class="info-stock">
                                                                                    <i class="fa fa-check-square-o" aria-hidden="true"></i>
                                                                                    In Stock
                                                                                </span>
                                                                            </div>
                                                                            <div class="rating">
                                                                                <div class="star-content">
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="product-group-price">
                                                                                <div class="product-price-and-shipping">
                                                                                    <span class="price">£28.08</span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="discription">
                                                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ultricies eget velit vitae bibendum. Cras condimentum libero
                                                                                a lectus ultricies...
                                                                            </div>
                                                                        </div>
                                                                        <div class="product-buttons d-flex">
                                                                            <form action="#" method="post" class="formAddToCart">
                                                                                <a class="add-to-cart" href="#" data-button-action="add-to-cart">
                                                                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>Add to cart
                                                                                </a>
                                                                            </form>
                                                                            <a class="addToWishlist" href="#" data-rel="1" onclick="">
                                                                                <i class="fa fa-heart" aria-hidden="true"></i>
                                                                            </a>
                                                                            <a href="#" class="quick-view hidden-sm-down" data-link-action="quickview">
                                                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    @else
                                                    <h4 class="text-warning" style="margin:100px auto;">There are no products.</h4>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- pagination -->
                                        <div class="pagination">
                                            <div class="js-product-list-top ">
                                                <div class="d-flex justify-content-around row">
                                                    <div class="showing col col-xs-12">
                                                        <span>SHOWING 1-3 OF 3 ITEM(S)</span>
                                                    </div>
                                                    <div class="page-list col col-xs-12">
                                                        <ul>
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
                                                                <a rel="nofollow" href="#" class="disabled js-search-link">
                                                                    3
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

                                    <!-- end col-md-9-1 -->
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