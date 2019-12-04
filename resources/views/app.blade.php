<html lang="{{  app()->getLocale() }}">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">

        <title>Gestion de vente</title>
      
    </head>
    <body>
            
      <div id="app">
            
      </div>
        
    </body>

    <script src="{{ asset('js/app.js') }}" ></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{asset('js/nombre_en_lettre.js')}}" type="text/javascript" charset="utf-8"></script>
    <script>window.Laravel={csrfToken:'{{ csrf_token() }}'}</script>
</html>
