@include('layouts.partials.head')

<body class="hold-transition ssidebar-mini layout-fixed layout-navbar-fixed text-sm">
    <div class="wrapper">
        @include('layouts.partials.navbar')

        <!-- ./wrapper -->
        @yield('content')
        @include('layouts.partials.footer')
    </div>

    @include('layouts.partials.script')
</body>

</html>
