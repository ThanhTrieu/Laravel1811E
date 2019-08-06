<!doctype html>
<html lang="en">
  <head>
    <title> @yield('title') </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300, 400,700|Inconsolata:400,700" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/owl.carousel.min.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend/fonts/ionicons/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/fonts/fontawesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/fonts/flaticon/font/flaticon.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">

    @stack('stylesheets')
    
  </head>
  <body>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v3.3&appId=1872442989723952&autoLogAppEvents=1"></script>

    <div class="wrap">
      @include('frontend.partials.header')
      
      @if($info['homePage'] === 'fr.home')
      {{-- chi trang home moi goi layout nay --}}
        @include('frontend.partials.slider')
      @endif

      <section class="site-section py-sm">
        <div class="container">
          <div class="row">
            <div class="col-md-6">
              <h2 class="mb-4">@yield('lastest-post')</h2>
            </div>
          </div>
          <div class="row blog-entries">
            <div class="col-md-12 col-lg-8 main-content">
              @yield('content')
            </div>


            <div class="col-md-12 col-lg-4 sidebar">  
              @include('frontend.partials.popular')

              @include('frontend.partials.categories')

              @include('frontend.partials.tags')
            </div>

          </div>
        </div>
      </section>
    
      @include('frontend.partials.footer')

    </div>
    
    <!-- loader -->
    <div id="loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#f4b214"/></svg></div>

    <script type="text/javascript" src="{{ asset('frontend/js/jquery-3.2.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/jquery-migrate-3.0.0.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/owl.carousel.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/jquery.waypoints.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/jquery.stellar.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/main.js') }}"></script>
    <script src="https://firepitsly.com/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js" type="text/javascript"></script>

    {{-- search every where --}}
    <script type="text/javascript" src="{{ asset('frontend/js/search.js') }}"></script>
    
    @stack('scripts')
  </body>
</html>