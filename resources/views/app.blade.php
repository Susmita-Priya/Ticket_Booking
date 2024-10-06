<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    @vite('resources/js/app.js')
    {{-- Frontend Template Styles Start--}}
    <link rel="stylesheet" type="text/css" href="{{asset('frontend/styles/bootstrap4/bootstrap.min.css')}}">
    <link href="{{asset('frontend/plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet')}}" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{asset('frontend/plugins/OwlCarousel2-2.2.1/owl.carousel.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('frontend/plugins/OwlCarousel2-2.2.1/owl.theme.default.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('frontend/plugins/OwlCarousel2-2.2.1/animate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('frontend/styles/main_styles.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('frontend/styles/responsive.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('frontend/styles/about_styles.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('frontend/styles/about_responsive.css')}}">





    {{-- Frontend Template Styles End--}}
    @inertiaHead
</head>
<body>
@inertia

{{-- Frontend Template Scripts --}}
<script src="{{asset('frontend/js/jquery-3.2.1.min.js')}}"></script>
<script src="{{asset('frontend/styles/bootstrap4/popper.js')}}"></script>
<script src="{{asset('frontend/styles/bootstrap4/bootstrap.min.js')}}"></script>
<script src="{{asset('frontend/plugins/OwlCarousel2-2.2.1/owl.carousel.js')}}"></script>
<script src="{{asset('frontend/plugins/easing/easing.js')}}"></script>
<script src="{{asset('frontend/js/custom.js')}}"></script>



<script src="{{asset('frontend/plugins/greensock/TweenMax.min.js')}}"></script>
<script src="{{asset('frontend/plugins/greensock/TimelineMax.min.js')}}"></script>
<script src="{{asset('frontend/plugins/scrollmagic/ScrollMagic.min.js')}}"></script>
<script src="{{asset('frontend/plugins/greensock/animation.gsap.min.js')}}"></script>
<script src="{{asset('frontend/plugins/greensock/ScrollToPlugin.min.js')}}"></script>
<script src="{{asset('frontend/plugins/parallax-js-master/parallax.min.js')}}"></script>




{{-- End Frontend Template Scripts --}}
</body>
</html>
