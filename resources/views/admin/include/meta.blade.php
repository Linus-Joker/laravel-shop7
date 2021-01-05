<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
{{--  CSRF Token  --}}
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Shop7-後台管理介面</title>
{{--  Icon  --}}
<link rel="Shortcut Icon" type="image/x-icon" href="{{ asset('favicon.ico',true) }}">
<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

{{--  Styles  --}}
<link href="{{ asset('css/app.css',true) }}" rel="stylesheet">
<link href="{{ asset('css/other.css',true) }}" rel="stylesheet">
