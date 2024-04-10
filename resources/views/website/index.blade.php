<!DOCTYPE html>
<html lang="en">

@include('website.layouts.head')


<body id="page-top">

    <div id="wrapper">

        @include('website.layouts.sidenav')

        @yield('content')

    </div>


    @include('website.layouts.js')

</body>

</html>