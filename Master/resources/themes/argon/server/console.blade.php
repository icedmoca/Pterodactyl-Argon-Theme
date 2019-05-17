{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
<!DOCTYPE html>
<html>
    <head>
        <title>{{ config('app.name', 'Pterodactyl') }} - Console &rarr; {{ $server->name }}</title>
        @include('layouts.scripts')
        {!! Theme::css('vendor/fontawesome/v5/css/all.min.css?t={cache-version}') !!}
        {!! Theme::css('vendor/argon/css/argon.min.css?t={cache-version}') !!}
        {!! Theme::css('css/terminal.css') !!}
        {!! Theme::css('css/style.css?t={cache-version}') !!}
    </head>
    <body id="terminal-body">
        <div id="terminal" style="width:100%;max-height: none !important;"></div>
        <div id="terminal_input" class="form-group no-margin">
            <div class="input-group pb-1">
                <div class="input-group-addon terminal_input--prompt">{{ $server->name }}:~/$</div>
                <input type="text" class="form-control terminal_input--input h-100">
            </div>
        </div>
        <div id="terminalNotify" class="terminal-notify hidden" data-toggle="tooltip" data-placement="left" title="Auto-scroll Console">
           <i class="fas fa-arrow-down"></i>
        </div>
    </body>
    <script>window.SkipConsoleCharts = true</script>
    {!! Theme::js('js/laroute.js') !!}
    {!! Theme::js('vendor/ansi/ansi_up.js') !!}
    {!! Theme::js('vendor/jquery/jquery.min.js') !!}
    {!! Theme::js('vendor/bootstrap/v4/dist/js/bootstrap.bundle.min.js?t={cache-version}') !!}
    {!! Theme::js('vendor/socketio/socket.io.v203.min.js') !!}
    {!! Theme::js('vendor/bootstrap-notify/bootstrap-notify.min.js') !!}
    {!! Theme::js('js/frontend/server.socket.js') !!}
    {!! Theme::js('vendor/mousewheel/jquery.mousewheel-min.js') !!}
    {!! Theme::js('js/frontend/console.js') !!}
    <script>
        $terminal.height($(window).innerHeight() - 40);
        $terminal.width($(window).innerWidth());
        $(window).on('resize', function () {
            window.scrollToBottom();
            $terminal.height($(window).innerHeight() - 40);
            $terminal.width($(window).innerWidth());
        });
    </script>
    <script>
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
    </script>
</html>
