<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>MSO Evenements</title>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <script src="https://kit.fontawesome.com/516b3c06f4.js" crossorigin="anonymous"></script>

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
{{-- 
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-2GF5S9YNMX"></script> --}}

  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-181923758-1"></script>

  <script>

    window.dataLayer = window.dataLayer || [];

    function gtag(){dataLayer.push(arguments);}

    gtag('js', new Date());

    gtag('config', 'UA-181923758-1');

  </script>

  {{-- <script type="module">

    let gaConfigs = {
      mazda: "G-2GF5S9YNMX",
      ford: "G-6PTLTEMMK1",
      kia: "G-Z4E54M3MP7",
      ds: "G-WYDQRCJY9Q",
      jvm: "G-GEG4FN04KP",
      macard47: "G-9JX1LQJNE8",
      mazda: "G-0KXNTPYSSG",
    }

    function gtag(){
      dataLayer.push(arguments);
    }

    function integrate(id) {
      var script = document.createElement("script");
      script.src = "https://www.googletagmanager.com/gtag/js?id=" + id;
      document.head.appendChild(script);

      window.dataLayer = window.dataLayer || [];
      gtag('js', new Date());
      gtag('config', id);
    }

    const subdomainName = window.location.hostname.split(".").shift()
    if (gaConfigs.hasOwnProperty(subdomainName)) integrate(gaConfigs[subdomainName]);

  </script> --}}



</head>
<body>
  <div id="app">
    @yield('app')
  </div>
</body>
</html>
