<!-- footer -->
<br>
<br>
<footer class="footer-one">
    <div class="inner-footer">
        <div class="container">
            <div class="footer-top col-lg-12 col-xs-12">
                <div class="row">
                    <div class="tiva-html col-lg-4 col-md-12 col-xs-12">
                        <div class="block">
                            <div class="block-content">
                                @php
                                $settings=DB::table('settings')->get();
                                @endphp
                                <p class="logo-footer">
                                    <img src="img/home/logo.png" alt="img">
                                </p>
                                <p class="content-logo">@foreach($settings as $data) {{$data->short_des}} @endforeach
                                </p>
                            </div>
                        </div>
                        <div class="block">
                            <div class="block-content">
                                <ul>
                                    <li>
                                        <a href="#">About Us</a>
                                    </li>
                                    <li>
                                        <a href="#">Reasons to shop</a>
                                    </li>
                                    <li>
                                        <a href="#">What our customers say</a>
                                    </li>
                                    <li>
                                        <a href="#">Meet the teaml</a>
                                    </li>
                                    <li>
                                        <a href="#">Contact our buyers</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="block">
                            <div class="block-content">
                                <p class="img-payment ">
                                    <img class="img-fluid" src="img/home/payment-footer.png" alt="img">
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="tiva-html col-lg-4 col-md-6">
                        <div class="block m-top">
                            <div class="title-block">
                                Contact Us
                            </div>
                            <div class="block-content">
                                <div class="contact-us">
                                    <div class="title-content">
                                        <i class="fa fa-home" aria-hidden="true"></i>
                                        <span>Address :</span>
                                    </div>
                                    <div class="content-contact address-contact">
                                        <p>@foreach($settings as $data) {{$data->address}} @endforeach</p>
                                    </div>
                                </div>
                                <div class="contact-us">
                                    <div class="title-content">
                                        <i class="fa fa-envelope" aria-hidden="true"></i>
                                        <span>Email :</span>
                                    </div>
                                    <div class="content-contact mail-contact">
                                        <p>@foreach($settings as $data) {{$data->email}} @endforeach</p>
                                    </div>
                                </div>
                                <div class="contact-us">
                                    <div class="title-content">
                                        <i class="fa fa-phone" aria-hidden="true"></i>
                                        <span>Hotline :</span>
                                    </div>
                                    <div class="content-contact phone-contact">
                                        <p>@foreach($settings as $data) {{$data->phone}} @endforeach</p>
                                    </div>
                                </div>
                                <div class="contact-us">
                                    <div class="title-content">
                                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                                        <span>Opening Hours :</span>
                                    </div>
                                    <div class="content-contact hours-contact">
                                        <p>Monday - Sunday / 08.00AM - 19.00</p>
                                        <span>(Except Holidays)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tiva-modules col-lg-4 col-md-6">
                        <div class="block m-top">
                            <div class="block-content">
                                <div class="title-block">Newsletter</div>
                                <div class="sub-title">Sign up to our newsletter to get the latest articles, lookbooks voucher codes direct
                                    to your inbox
                                </div>
                                <div class="block-newsletter">
                                    <form action="#" method="post">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="email" value="" placeholder="Enter Your Email">
                                            <span class="input-group-btn">
                                                <button class="effect-btn btn btn-secondary " name="submitNewsletter" type="submit">
                                                    <span>subscribe</span>
                                                </button>
                                            </span>
                                        </div>
                                        <input type="hidden" name="action" value="0">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="block m-top1">
                            <div class="block-content">
                                <div class="social-content">
                                    <div class="title-block">
                                        Follow us on
                                    </div>
                                    <div id="social-block">
                                        <div class="social">
                                            <ul class="list-inline mb-0 justify-content-end">
                                                <li class="list-inline-item mb-0">
                                                    <a href="#" target="_blank">
                                                        <i class="fa fa-facebook"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item mb-0">
                                                    <a href="#" target="_blank">
                                                        <i class="fa fa-twitter"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item mb-0">
                                                    <a href="#" target="_blank">
                                                        <i class="fa fa-google"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item mb-0">
                                                    <a href="#" target="_blank">
                                                        <i class="fa fa-instagram"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="block m-top1">
                            <div class="block-content">
                                <div class="payment-content">
                                    <div class="title-block">
                                        Payment accept
                                    </div>
                                    <div class="payment-image">
                                        <img class="img-fluid" src="img/home/payment.png" alt="img">
                                    </div>
                                </div>
                                <!-- Popup newsletter -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="tiva-copyright">
        <div class="container">
            <div class="row">
                <div class="text-center col-lg-12 ">
                    <span>
                        <p>Copyright © {{date('Y')}} <a href="#" target="_blank">Curtain Shop UAE</a> - All Rights Reserved.</p>
                    </span>
                </div>
            </div>
        </div>
    </div>
</footer>
<script src="{{asset('frontend/libs/jquery/jquery.min.js')}}"></script>
<script src="{{asset('frontend/libs/popper/popper.min.js')}}"></script>
<script src="{{asset('frontend/libs/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('frontend/libs/nivo-slider/js/jquery.nivo.slider.js')}}"></script>
<script src="{{asset('frontend/libs/owl-carousel/owl.carousel.min.js')}}"></script>
<script src="{{ asset('frontend/libs/slider-range/js/tmpl.js') }}"></script>
<script src="{{ asset('frontend/libs/slider-range/js/jquery.dependClass-0.1.js') }}"></script>
<script src="{{ asset('frontend/libs/slider-range/js/draggable-0.1.js') }}"></script>
<script src="{{ asset('frontend/libs/slider-range/js/jquery.slider.js') }}"></script>
<script src="{{asset('frontend/js/theme.js')}}"></script>