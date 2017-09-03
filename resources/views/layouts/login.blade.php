<!doctype html>
<html lang="ru" class="no-js">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>@yield('title')</title>

    <!--  Social tags      -->
    <meta name="keywords" content="@yield('keywords')">

    <meta name="description" content="">

    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="ЕТКплюс">
    <meta itemprop="description" content="Система лояльности для пользователей электронных транспортных карт">

    <meta itemprop="image" content="http://s3.amazonaws.com/creativetim_bucket/products/60/original/opt_pk2p_thumbnail.jpg">


    <!--  end meta tags-->

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/assets/css/paper-kit.css" rel="stylesheet"/>
    <link href="/assets/css/demo.css" rel="stylesheet" />
    <link href="/assets/css/app.css" rel="stylesheet" />

    <!--     Fonts and icons     -->
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,300,700|Material+Icons' rel='stylesheet' type='text/css'>
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Exo+2:700,800,900" rel="stylesheet">
    <link href="/assets/css/nucleo-icons.css" rel="stylesheet">

</head>
<body class="full-screen login">
@include('includes.top-nav')
@yield('content')
@include('includes.footer')

</body>

    <!--  Plugins -->
    <!-- Core JS Files -->
    <script src="/assets/js/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="/assets/js/jquery-ui-1.12.1.custom.min.js" type="text/javascript"></script>
    <script src="/assets/js/tether.min.js" type="text/javascript"></script>
    <script src="/assets/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/assets/js/paper-kit.js"></script>
    <script src="/assets/js/demo.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY"></script>

    <!--  Plugins for presentation page -->
    <script src="/assets/js/presentation-page/main.js"></script>
    <script src="/assets/js/presentation-page/jquery.sharrre.js"></script>

    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <script type="text/javascript">
        (function() {
            function getRandomInt(min, max) {
                return Math.floor(Math.random() * (max - min + 1)) + min;
            }

            new IsoGrid(document.querySelector('.isolayer--deco1'), {
                transform : 'translateX(33vw) translateY(-340px) rotateX(45deg) rotateZ(45deg)',
                stackItemsAnimation : {
                    properties : function(pos) {
                        return {
                            translateZ: (pos+1) * 30,
                            rotateZ: getRandomInt(-4, 4)
                        };
                    },
                    options : function(pos, itemstotal) {
                        return {
                            type: dynamics.bezier,
                            duration: 500,
                            points: [{"x":0,"y":0,"cp":[{"x":0.2,"y":1}]},{"x":1,"y":1,"cp":[{"x":0.3,"y":1}]}],
                            delay: (itemstotal-pos-1)*40
                        };
                    }
                }
            });
        })();
    </script>
</html>
