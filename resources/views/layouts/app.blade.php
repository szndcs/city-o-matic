<!DOCTYPE html>
     <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
     <head>
     <meta charset="UTF-8" />
          <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
          <meta property="og:locale" content="hu_HU" />
          <meta name="robots" content="index, follow" />
          <meta name="revisit-after" content="14 days" />
          <meta name="csrf-token" content="{{ csrf_token() }}">
          <link rel="icon" type="image/png" href="favicon.png" />
          <title>{{ config('app.name') }}</title>
          <!-- jQuery -->
          <script src="assets/js/jquery-3.5.1/jquery-3.5.1.min.js"></script>
          <!-- Semantic UI -->
          <script src="assets/js/semantic-2.4/semantic.min.js"></script>
          <link rel="stylesheet" type="text/css" href="assets/css/semantic-2.4/semantic.min.css">
          <link rel="stylesheet" type="text/css" href="assets/css/semantic-2.4/icon.css">
          <!-- app default css -->
          <link rel="stylesheet" type="text/css" href="assets/css/app.css">
     </head>
     <body>
          <div class="ui hidden divider"></div>

          <div class="ui container">
               <div class="ui raised very padded container segment">

@yield('content')

               </div>
          </div>
@yield('footer')

@yield('scripts', '')

     </body>
</html>