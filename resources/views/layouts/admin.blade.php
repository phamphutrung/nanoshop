<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admins/css/adminlte.min.css') }}">
    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> 

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    {{--  <link rel="stylesheet" href="asset('admin/plugins/fontawesome-free/css/all.min.css') }}">  --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="csrf_token" content="{{ csrf_token() }}">
   @yield('css')
</head>
<body>
    <div class="wrapper">

        @include('layouts.inc.admin_navbar')
      
        @include('layouts.inc.admin_sidebar')
      
       <div class="content-wrapper">
          <div class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1 class="m-0">@yield('title')</h1>
                </div>
              </div>
            </div>
          </div>

          <div class="content">
            <div class="container-fluid">
              <div class="row">
                  @yield('content')
              </div>
            </div>
          </div>
  </div>
    
        @include('layouts.inc.admin_footer')
      </div>
      <script src="{{ asset('admins/plugin/jquery/jquery.min.js') }}"></script>
      <script src="{{ asset('admins/js/adminlte.min.js') }}"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
      {{-- js sweetalerr --}}
      <script src="{{ asset('admins/plugin/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
      <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
      <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      @if (session('status'))
        <script>
          Swal.fire(
            'Good job!',
            "{{ Session('status') }}",
            'success'
          )
        </script>
      @endif
      @yield('scripts')

</body>
</html>
