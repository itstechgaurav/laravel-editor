<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="/js/app.js" defer></script>
<link href="/css/app.css" rel="stylesheet">
<title>@isset($title){{$title}}@else Document @endisset</title>
<link rel="shortcut icon" href="/favicon.ico" />
<link rel="canonical" href="{{url()->full()}}">