<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.head')
</head>

<body id="page-top">
    <div id="wrapper">
<!-- Header -->
{{-- @include('layouts.sidebar') --}}

@yield('content')

{{-- @include('layouts.footer') --}}
    </div>
</body>
</html>