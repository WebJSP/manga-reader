<?php
    require 'phplib/userAgent.php';
    $userAgent = new \UserAgent();
    $browser = $userAgent->getName();
    $version = $userAgent->getSimpleVersion();
	$folder = filter_input(INPUT_GET, "manga");
	$volume = filter_input(INPUT_GET, "vol");
	$page = filter_input(INPUT_GET, "page");
	if (!isset($page)) {
		$page = 1;
	}
?>
<!doctype html>
<!--[if lt IE 7 ]> <html lang="en" class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <title>Manga Reader</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <link rel="stylesheet" href="css/jquery.sidr.light.css">
    <script type="text/javascript" src="extras/jquery.min.1.7.js"></script>
    <script type="text/javascript" src="extras/jquery.sidr.min.js"></script>
    <script type="text/javascript" src="extras/modernizr.2.5.3.min.js"></script>
    <script type="text/javascript" src="lib/hash.js"></script>
</head>
<body>
    <div id="canvas">
        <div id="manga-menu" href="#sidr"></div>
        <div id="sidr"><ul></ul></div>
        <div class="zoom-icon zoom-icon-in"></div>
        <div class="fullscreen-icon"></div>
        <div class="manga-viewport">
	        <div class="container">
		        <div class="manga">
                    <!-- Next button -->
                    <div ignore="1" class="next-button"></div>
                    <!-- Previous button -->
                    <div ignore="1" class="previous-button"></div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    	var mangaReader = {
    		data: [],
    		page: <?php echo $page; ?>,
            volume: <?php echo $volume; ?>,
            activeVolume: undefined
    	};

        var fullscreenEnabled = false;
            //document.fullscreenEnabled ||
            //document.mozFullScreenEnabled ||
            //document.webkitFullscreenEnabled;

        function loadApp() {
            $('#canvas').fadeIn(1000);
            var flipbook = $('.manga');

            // Check if the CSS was already loaded
            if (flipbook.width()==0 || flipbook.height()==0) {
                setTimeout(loadApp, 10);
                return;
            }

            $.post('php/folders.php', {
            	folder: '<?php echo $folder; ?>'
            }, function(data) {
            	mangaReader.data = data;
                // build the menu
                for(var index=0; index<mangaReader.data.length; index++) {
                    $('<li><a href="#">'+mangaReader.data[index].info.name+'</a></li>').appendTo('#sidr>ul');
                }
                $('#manga-menu').sidr({displace: false});

                mangaReader.activeVolume = getVolume(mangaReader.volume);
	            // Create the flipbook
	            flipbook.turn({
	                // manga width
	                width: largeMagazineWidth(),
	                // manga height
	                height: 1057,
	                // Duration in millisecond
	                duration: 800,
	                // Hardware acceleration
	                acceleration: !isChrome(),
	                // Enables gradients
	                gradients: true,
	                // Auto center this flipbook
	                autoCenter: true,
	                // Elevation from the edge of the flipbook when turning a page
	                elevation: 50,
	                // The number of pages
	                pages: mangaReader.activeVolume.files.length,
	                // The pages direction
	                direction: 'rtl',
	                // Events
	                when: {
	                    turning: function(event, page, view) {
	                        var book = $(this),
	                        currentPage = book.turn('page'),
	                        pages = book.turn('pages');
	                        // Update the current URI
	                        Hash.go('page/' + page).update();
	                        // Show and hide navigation buttons
	                        disableControls(page);
	                    },

	                    turned: function(event, page, view) {
	                        disableControls(page);
	                        $(this).turn('center');
	                        if (page==1) {
	                            $(this).turn('peel', 'br');
	                        }
	                    },

	                    missing: function (event, pages) {
	                        // Add pages that aren't in the manga
	                        for (var i = 0; i < pages.length; i++)
	                            addPage(pages[i], $(this));
	                    }
	                }
	            });

	            // Zoom.js
	            $('.manga-viewport').zoom({
	                flipbook: $('.manga'),
	                max: function() {
	                    return largeMagazineWidth()/$('.manga').width();
	                },
	                when: {
	                    swipeLeft: function() {
	                        $(this).zoom('flipbook').turn('previous');
	                    },

	                    swipeRight: function() {
	                        $(this).zoom('flipbook').turn('next');
	                    },

	                    resize: function(event, scale, page, pageElement) {
	                        //loadPage(page, pageElement);
	                    },

	                    zoomIn: function () {
	                        $('.made').hide();
	                        $('.manga').removeClass('animated').addClass('zoom-in');
	                        $('.zoom-icon').removeClass('zoom-icon-in').addClass('zoom-icon-out');

	                        if (!window.escTip && !$.isTouch) {
	                            escTip = true;
	                            $('<div />', {'class': 'exit-message'}).
	                                html('<div>Press ESC to exit</div>').
	                                    appendTo($('body')).
	                                    delay(2000).
	                                    animate({opacity:0}, 500, function() {
	                                        $(this).remove();
	                                    });
	                        }
	                    },

	                    zoomOut: function () {
	                        $('.exit-message').hide();
	                        $('.made').fadeIn();
	                        $('.zoom-icon').removeClass('zoom-icon-out').addClass('zoom-icon-in');

	                        setTimeout(function(){
	                            $('.manga').addClass('animated').removeClass('zoom-in');
	                            resizeViewport();
	                        }, 0);
	                    }
	                }
	            });

	            // Zoom event
	            if ($.isTouch)
	                $('.manga-viewport').bind('zoom.doubleTap', zoomTo);
	            else
	                $('.manga-viewport').bind('zoom.tap', zoomTo);

	            // Using arrow keys to turn the page
	            $(document).keydown(function(e){
	                var previous = 39, next = 37, esc = 27;

	                switch (e.keyCode) {
	                    case previous:
	                        // left arrow
	                        $('.manga').turn('previous');
	                        e.preventDefault();
	                    break;
	                    case next:
	                        //right arrow
	                        $('.manga').turn('next');
	                        e.preventDefault();
	                    break;
	                    case esc:
	                        $('.manga-viewport').zoom('zoomOut');
	                        e.preventDefault();
	                    break;
	                }
	            });

	            // URIs - Format #/page/1

	            Hash.on('^page\/([0-9]*)$', {
	                yep: function(path, parts) {
	                    var page = parts[1];
	                    if (page!==undefined) {
	                        if ($('.manga').turn('is'))
	                            $('.manga').turn('page', page);
	                    }
	                },
	                nop: function(path) {
	                    if ($('.manga').turn('is'))
	                        $('.manga').turn('page', mangaReader.page /*1*/);
	                }
	            });

	            $(window).resize(function() {
	                resizeViewport();
	            }).bind('orientationchange', function() {
	                resizeViewport();
	            });

	            // Events for the next button

	            $('.next-button').bind($.mouseEvents.over, function() {
	                $(this).addClass('next-button-hover');
	            }).bind($.mouseEvents.out, function() {
	                $(this).removeClass('next-button-hover');
	            }).bind($.mouseEvents.down, function() {
	                $(this).addClass('next-button-down');
	            }).bind($.mouseEvents.up, function() {
	                $(this).removeClass('next-button-down');
	            }).click(function() {
	                $('.manga').turn('previous');
	            });

	            // Events for the next button
	            $('.previous-button').bind($.mouseEvents.over, function() {
	                $(this).addClass('previous-button-hover');
	            }).bind($.mouseEvents.out, function() {
	                $(this).removeClass('previous-button-hover');
	            }).bind($.mouseEvents.down, function() {
	                $(this).addClass('previous-button-down');
	            }).bind($.mouseEvents.up, function() {
	                $(this).removeClass('previous-button-down');
	            }).click(function() {
	                $('.manga').turn('next');
	            });

	            resizeViewport();
	            $('.manga').addClass('animated');
            }, "json");

        }

         // Zoom icon
         $('.zoom-icon').bind('mouseover', function() {
            if ($(this).hasClass('zoom-icon-in'))
                $(this).addClass('zoom-icon-in-hover');
            if ($(this).hasClass('zoom-icon-out'))
                $(this).addClass('zoom-icon-out-hover');
         }).bind('mouseout', function() {
             if ($(this).hasClass('zoom-icon-in'))
                $(this).removeClass('zoom-icon-in-hover');
            if ($(this).hasClass('zoom-icon-out'))
                $(this).removeClass('zoom-icon-out-hover');
         }).bind('click', function() {
            if ($(this).hasClass('zoom-icon-in'))
                $('.manga-viewport').zoom('zoomIn');
            else if ($(this).hasClass('zoom-icon-out'))
                $('.manga-viewport').zoom('zoomOut');
         });

        // FullScreen icon
        $('.fullscreen-icon').bind('click', function() {
            if (fullscreenEnabled)
                exitFullscreen();
            else
                launchIntoFullscreen(document.documentElement);
        });

         $('#canvas').hide();

        // Load the HTML4 version if there's not CSS transform
        yepnope({
            test : Modernizr.csstransforms,
            yep: ['lib/turn.js'],
            nope: ['lib/turn.html4.min.js'],
            both: ['lib/zoom.min.js', /*'extras/fabric.min.js',*/ 'js/manga.js', 'css/manga.css'],
            complete: loadApp
        });

    </script>
</body>
</html>