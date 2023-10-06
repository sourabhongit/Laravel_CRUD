@include('layouts.partials.head')
    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
@include('layouts.partials.preloader')
@include('layouts.partials.navbar')
@include('layouts.partials.aside')
<div class="content-wrapper">
@yield('main-section')
</div>
</div>
@include('layouts.partials.footer')