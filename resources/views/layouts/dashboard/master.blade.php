<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>@yield('title')</title>

     <!-- Bootstrap core CSS     -->
    <link href="/assets/dashboard/css/bootstrap.min.css" rel="stylesheet" />

    <!--  Paper Dashboard core CSS    -->
    <link href="/assets/css/paper-kit.css" rel="stylesheet"/>
    <link href="/assets/dashboard/css/paper-dashboard.css" rel="stylesheet"/>
    <link rel="stylesheet" href="/assets/dashboard/css/app.css">
    <link href="/assets/css/photoswipe.css" rel="stylesheet" />
    <link href="/assets/css/default-skin.css" rel="stylesheet" />


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
    <!--  Photoswipe files -->
<script src="/assets/js/photoswipe.min.js"></script>
<script src="/assets/js/photoswipe-ui-default.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            demo.initOverviewDashboard();
            demo.initCirclePercentage();
            demo.initFormExtendedDatetimepickers();
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
    <script>
        $(document).ready(function(){
           var initPhotoSwipeFromDOM = function(gallerySelector) {

    // parse slide data (url, title, size ...) from DOM elements 
    // (children of gallerySelector)
    var parseThumbnailElements = function(el) {
        var thumbElements = el.childNodes,
            numNodes = thumbElements.length,
            items = [],
            figureEl,
            linkEl,
            size,
            item;

        for(var i = 0; i < numNodes; i++) {

            figureEl = thumbElements[i]; // <figure> element

            // include only element nodes 
            if(figureEl.nodeType !== 1) {
                continue;
            }

            linkEl = figureEl.children[0]; // <a> element

            size = linkEl.getAttribute('data-size').split('x');

            // create slide object
            item = {
                src: linkEl.getAttribute('href'),
                w: parseInt(size[0], 10),
                h: parseInt(size[1], 10)
            };



            if(figureEl.children.length > 1) {
                // <figcaption> content
                item.title = figureEl.children[1].innerHTML; 
            }

            if(linkEl.children.length > 0) {
                // <img> thumbnail element, retrieving thumbnail url
                item.msrc = linkEl.children[0].getAttribute('src');
            } 

            item.el = figureEl; // save link to element for getThumbBoundsFn
            items.push(item);
        }

        return items;
    };

    // find nearest parent element
    var closest = function closest(el, fn) {
        return el && ( fn(el) ? el : closest(el.parentNode, fn) );
    };

    // triggers when user clicks on thumbnail
    var onThumbnailsClick = function(e) {
        e = e || window.event;
        e.preventDefault ? e.preventDefault() : e.returnValue = false;

        var eTarget = e.target || e.srcElement;

        // find root element of slide
        var clickedListItem = closest(eTarget, function(el) {
            return (el.tagName && el.tagName.toUpperCase() === 'FIGURE');
        });

        if(!clickedListItem) {
            return;
        }

        // find index of clicked item by looping through all child nodes
        // alternatively, you may define index via data- attribute
        var clickedGallery = clickedListItem.parentNode,
            childNodes = clickedListItem.parentNode.childNodes,
            numChildNodes = childNodes.length,
            nodeIndex = 0,
            index;

        for (var i = 0; i < numChildNodes; i++) {
            if(childNodes[i].nodeType !== 1) { 
                continue; 
            }

            if(childNodes[i] === clickedListItem) {
                index = nodeIndex;
                break;
            }
            nodeIndex++;
        }



        if(index >= 0) {
            // open PhotoSwipe if valid index found
            openPhotoSwipe( index, clickedGallery );
        }
        return false;
    };

    // parse picture index and gallery index from URL (#&pid=1&gid=2)
    var photoswipeParseHash = function() {
        var hash = window.location.hash.substring(1),
        params = {};

        if(hash.length < 5) {
            return params;
        }

        var vars = hash.split('&');
        for (var i = 0; i < vars.length; i++) {
            if(!vars[i]) {
                continue;
            }
            var pair = vars[i].split('=');  
            if(pair.length < 2) {
                continue;
            }           
            params[pair[0]] = pair[1];
        }

        if(params.gid) {
            params.gid = parseInt(params.gid, 10);
        }

        return params;
    };

    var openPhotoSwipe = function(index, galleryElement, disableAnimation, fromURL) {
        var pswpElement = document.querySelectorAll('.pswp')[0],
            gallery,
            options,
            items;

        items = parseThumbnailElements(galleryElement);

        // define options (if needed)
        options = {

            // define gallery index (for URL)
            galleryUID: galleryElement.getAttribute('data-pswp-uid'),

            getThumbBoundsFn: function(index) {
                // See Options -> getThumbBoundsFn section of documentation for more info
                var thumbnail = items[index].el.getElementsByTagName('img')[0], // find thumbnail
                    pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                    rect = thumbnail.getBoundingClientRect(); 

                return {x:rect.left, y:rect.top + pageYScroll, w:rect.width};
            }

        };

        // PhotoSwipe opened from URL
        if(fromURL) {
            if(options.galleryPIDs) {
                // parse real index when custom PIDs are used 
                // http://photoswipe.com/documentation/faq.html#custom-pid-in-url
                for(var j = 0; j < items.length; j++) {
                    if(items[j].pid == index) {
                        options.index = j;
                        break;
                    }
                }
            } else {
                // in URL indexes start from 1
                options.index = parseInt(index, 10) - 1;
            }
        } else {
            options.index = parseInt(index, 10);
        }

        // exit if index not found
        if( isNaN(options.index) ) {
            return;
        }

        if(disableAnimation) {
            options.showAnimationDuration = 0;
        }

        // Pass data to PhotoSwipe and initialize it
        gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
        gallery.init();
    };

    // loop through all gallery elements and bind events
    var galleryElements = document.querySelectorAll( gallerySelector );

    for(var i = 0, l = galleryElements.length; i < l; i++) {
        galleryElements[i].setAttribute('data-pswp-uid', i+1);
        galleryElements[i].onclick = onThumbnailsClick;
    }

    // Parse URL and open gallery if it contains #&pid=3&gid=1
    var hashData = photoswipeParseHash();
    if(hashData.pid && hashData.gid) {
        openPhotoSwipe( hashData.pid ,  galleryElements[ hashData.gid - 1 ], true, true );
    }
};

// execute above function
initPhotoSwipeFromDOM('.my-gallery');
        });
    </script>
    <script>
        $('#co-find-card').on('click',function(){
            if ($('#co-card-input-number').val().length > 8){
                $('#co-card-info-loader').replaceWith('<i class="fa fa-circle-o-notch fa-spin fa-1x fa-fw" id="co-card-info-loader"></i>');

                $.ajax({
                    method: 'POST',
                    url: checkCardUrl,
                    data: {
                        card_number: $('#co-card-input-number').val(),
                        partner_id: partnerId,
                        _token: token
                    }
                })
                .done(function(msg){
                    console.log(JSON.stringify(msg));
                    if (msg['message'] == 'success'){
                        $('#co-search-status').addClass('has-success');
                        $('#co-search-status').removeClass('has-error');

                        $('#co-card-number').replaceWith("<p class=\"form-control-static pull-right \" id=\"co-card-number\">" + msg['card'].num + "</p>");
                        $('#co-bonuses').replaceWith("<p class=\"form-control-static pull-right \" id=\"co-bonuses\">" + msg['bonuses'] + "</p>");
                        $('#co-operations-count').replaceWith("<p class=\"form-control-static pull-right \" id=\"co-operations-count\">" + msg['visit_count'] + "</p>");
                        $('#co-operations-summary').replaceWith("<p class=\"form-control-static pull-right \" id=\"co-operations-summary\">" + msg['visit_summary'] + "</p>");

                    } else if (msg['message'] == 'error'){
                        $('#co-search-status').removeClass('has-success');
                        $('#co-search-status').addClass('has-error');
                    }
                    $('#co-card-info-loader').replaceWith('<i id="co-card-info-loader"></i>');
                });

            } else {

            }
        });
    </script>
</html>
