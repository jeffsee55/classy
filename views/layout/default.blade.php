<!DOCTYPE html>
<html>
    <head>
        <meta charset="{{ bloginfo( 'charset' ) }}" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <link rel="pingback" href="{{ bloginfo('pingback_url') }}" />
        <link rel="alternate" type="application/rss+xml" title="{{ bloginfo('name') }} RSS Feed" href="{{ bloginfo('rss2_url') }}" />
        <link rel="shortcut icon" href="{{ CLASSY_THEME_DIR }}assets/favicon.ico" />
        <script src="https://use.typekit.net/xeo3irf.js"></script>
        <script>try{Typekit.load({ async: true });}catch(e){}</script>
        <title>{{ wp_title('|', true, 'right'); }}</title>
        {{ wp_head() }}
    </head>
    <body {{ body_class() }}>

        {{ get_header() }}

        @yield('content')

        {{ get_footer() }}

        {{ wp_footer() }}
    </body>
</html>
