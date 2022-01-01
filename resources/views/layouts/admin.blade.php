<!DOCTYPE html>
<html lang="tr-TR">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ShopTY - Dashboard</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/favicon.ico')}}">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,400italic,700,700italic,900,900italic&amp;subset=latin,latin-ext" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open%20Sans:300,400,400italic,600,600italic,700,700italic&amp;subset=latin,latin-ext" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/animate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/font-awesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/chosen.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/color-01.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/flexslider.css')}}">
    {{--link for select2.org tool--}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @stack('css')
    @livewireStyles
    <link
    rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <link
      rel="shortcut icon"
      href="{{asset('dashboard/assets/imgs/shopty-dash.png')}}"
      type="image/x-icon"
    />

    <link rel="stylesheet" href="{{asset('dashboard/assets/css/style.css')}}" />


  </head>

  <body>
    <!-- ### YAN MENÜ ### -->
    <section id="menu">

      <div class="menu-logo">
        <img src="{{asset('dashboard/assets/imgs/shopty-dash.png')}}">
      </div>

      <div class="items">
        @if(Route::has('login'))
        @auth
          @if (Auth::user()->utype=='ADM')

                <li><i class="fa fa-home" aria-hidden="true"></i>
                  <a title="Dashboard" href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>	             

                <li><i class="fa fa-list-ul"></i>
                  <a title="Categories" href="{{route('admin.categories')}}">Categories</a>
                </li>	
                <li><i class="fa fa-user-secret"></i>
                  <a title="Product Attributes" href="{{route('admin.attributes')}}">Product Attributes</a>
                </li>	

                <li><i class="fa fa-list-ul"></i>
                  <a title="Products" style="margin-left: 2px" href="{{route('admin.products')}}">Products</a>
                </li>	

                <li> <i class="fal fa-images"></i>
                  <a title="Manage Home Slider" href="{{route('admin.homeSlider')}}">Manage Home Slider</a>
                </li>

                <li> <i class="fa fa-th-list" aria-hidden="true"></i>
                  <a title="Manage Home Categories" href="{{route('admin.home.categories')}}">Manage Home Categories</a>
                </li>

                <li><i class="fa fa-dollar-sign"></i>
                  <a title="Sale Setting" href="{{route('admin.sale')}}">Sale Setting</a>
                </li>

                <li><i class="fa fa-code" aria-hidden="true"></i>
                  <a title="Coupons" href="{{route('admin.coupons')}}">Coupons</a>
                </li>

                <li><i class="fas fa-handshake-alt    "></i>
                  <a title="Show Orders" href="{{route('admin.orders')}}">Show Orders</a>
                </li>

                <li><i class="fas fa-mail-bulk"></i>
                  <a title="Contact Messages" href="{{route('admin.contact')}}">Contact Messages</a>
                </li>

                <li><i class="fas fa-user-cog"></i>
                  <a title="Settings" href="{{route('admin.settings')}}">Settings</a>
                </li>
            @endif													          
        @endif
        @endif

      </div>
    </section>

      <section id="interface">
        <div class="navigation">
          <!--Search-->
          <div class="n1">
            <div>
              <i id="menu-btn" class="fas fa-bars"></i>
            </div>
            <div class="search">
              <i class="far fa-search"></i>
              <form>
                <input type="text" placeholder="search" />
              </form>
            </div>
          </div>

          <!--Profile-->
          <div class="profile">                   

              <div style="padding-right: 30px; !important">

                <a href="{{ route('index') }}">SHOPTY</a>
              </div>

              <div>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout_id').submit(); "><i class="fa fa-sign-out" aria-hidden="true"> Logout</i></a>   

                <form id="logout_id" action="{{ route('logout') }}" method="POST">
                  @csrf															
                </form>	
              </div>

            <img src="{{asset('dashboard/assets/imgs/1.jpeg')}}" />
          </div>
        </div>

        <div class="container-fluid my-5" style="margin-top: 100px; !important">
          {{$slot}}
        </div>
      </section>


    <script>
      $("#menu-btn").click(function () {
        $("#menu").toggleClass("active");
      });
    </script>

<script
src="https://code.jquery.com/jquery-3.6.0.min.js"
integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
crossorigin="anonymous"
></script>

<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/chosen.jquery.min.js')}}"></script>
<script src="{{asset('assets/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.countdown.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.sticky.js')}}"></script>
<script src="{{asset('assets/js/functions.js')}}"></script>
{{--select2.org script--}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
{{--tinymce Editör--}}
<script src="https://cdn.tiny.cloud/1/jsyyyhgmz6sggrtg0pd9ur4dcwkguymw0jul0u0gdtfl0df7/tinymce/5/tinymce.min.js" referrerpolicy="origin">
</script>
@stack('scripts')
@livewireScripts


</body>
</html>