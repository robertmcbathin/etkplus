<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>@yield('title')</title>

     <!-- Bootstrap core CSS     -->
    <link href="/assets/dashboard/css/bootstrap.min.css" rel="stylesheet" />

    <!--  Paper Dashboard core CSS    -->
        <link href="/assets/css/paper-kit.css" rel="stylesheet"/>
    <link href="/assets/dashboard/css/paper-dashboard.css" rel="stylesheet"/>



    <!--  Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="/assets/dashboard/css/themify-icons.css" rel="stylesheet">
</head>

<body>
   @yield('content')
</body>

    <!--   Core JS Files. Extra: TouchPunch for touch library inside jquery-ui.min.js   -->
    <script src="/assets/dashboard/js/jquery-3.1.1.min.js" type="text/javascript"></script>
    <script src="/assets/dashboard/js/jquery-ui.min.js" type="text/javascript"></script>
    <script src="/assets/dashboard/js/perfect-scrollbar.min.js" type="text/javascript"></script>
    <script src="/assets/dashboard/js/bootstrap.min.js" type="text/javascript"></script>

    <!--  Forms Validations Plugin -->
    <script src="/assets/dashboard/js/jquery.validate.min.js"></script>

    <!-- Promise Library for SweetAlert2 working on IE -->
    <script src="/assets/dashboard/js/es6-promise-auto.min.js"></script>

    <!--  Plugin for Date Time Picker and Full Calendar Plugin-->
    <script src="/assets/dashboard/js/moment.min.js"></script>

    <!--  Date Time Picker Plugin is included in this js file -->
    <script src="/assets/dashboard/js/bootstrap-datetimepicker.js"></script>

    <!--  Select Picker Plugin -->
    <script src="/assets/dashboard/js/bootstrap-selectpicker.js"></script>

    <!--  Switch and Tags Input Plugins -->
    <script src="/assets/dashboard/js/bootstrap-switch-tags.js"></script>

    <!-- Circle Percentage-chart -->
    <script src="/assets/dashboard/js/jquery.easypiechart.min.js"></script>

    <!--  Charts Plugin -->
    <script src="/assets/dashboard/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="/assets/dashboard/js/bootstrap-notify.js"></script>

    <!-- Sweet Alert 2 plugin -->
    <script src="/assets/dashboard/js/sweetalert2.js"></script>

    <!-- Vector Map plugin -->
    <script src="/assets/dashboard/js/jquery-jvectormap.js"></script>

    <!--  Google Maps Plugin    -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAFPQibxeDaLIUHsC6_KqDdFaUdhrbhZ3M"></script>

    <!-- Wizard Plugin    -->
    <script src="/assets/dashboard/js/jquery.bootstrap.wizard.min.js"></script>

    <!--  Bootstrap Table Plugin    -->
    <script src="/assets/dashboard/js/bootstrap-table.js"></script>

    <!--  Plugin for DataTables.net  -->
    <script src="/assets/dashboard/js/jquery.datatables.js"></script>

    <!--  Full Calendar Plugin    -->
    <script src="/assets/dashboard/js/fullcalendar.min.js"></script>

    <!-- Paper Dashboard PRO Core javascript and methods for Demo purpose -->
    <script src="/assets/dashboard/js/paper-dashboard.js"></script>

    <!--   Sharrre Library    -->
    <script src="/assets/dashboard/js/jquery.sharrre.js"></script>

    <!-- Paper Dashboard PRO DEMO methods, don't include it in your project! -->
    <script src="/assets/dashboard/js/demo.js"></script>

    <script src="/assets/js/jasny-bootstrap.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            demo.initOverviewDashboard();
            demo.initCirclePercentage();
            $(document).ready(function(){
                demo.initWizard();
            });

        });
    </script>
    <script>
        $('.toggle-activate-partner').on('click',function(){
            var partnerId = $(this).data('id');
            console.log(partnerId);
            console.log(1);
            });
    </script>

</html>
