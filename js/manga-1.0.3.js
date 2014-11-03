function addPage(page, book) {

	var id, pages = book.turn('pages');

	// Create a new element for this page
	var element = $('<div />', {});

	// Add the page to the flipbook
	if (book.turn('addPage', element, page)) {

		// Add the initial HTML
		// It will contain a loader indicator and a gradient
		element.html('<div class="gradient"></div><div class="loader"></div>');

		// Load the page
        loadPage(page, element);
	}

}

function loadPage(page, pageElement) {
    if (mangaReader.activeVolume.files[page-1].indexOf("svg")===-1)
        loadPageAsImage(page, pageElement);
    else
        loadPageAsSvg(page, pageElement);
}

function loadPageAsImage(page, pageElement) {
    // Create an image element
    var img = $('<img />');

    img.mousedown(function(e) {
        e.preventDefault();
    });

    img.load(function() {
        // Set the size
        $(this).css({width: '100%', height: '100%'});
        // Add the image to the page after loaded
        $(this).appendTo(pageElement);
        // Remove the loader indicator
        pageElement.find('.loader').remove();
    });

    // Load the page
    img.attr('src', mangaReader.activeVolume.files[page-1]);
}

function loadPageAsSvg(page, pageElement) {
    var url = mangaReader.activeVolume.files[page-1],
        start = url.lastIndexOf("/")+1,
        len = url.lastIndexOf(".")-start,
        id = url.substr(start, len);
    pageElement.load(url+' #'+id,
        function(){
            var svg = $(this).children();
            svg.mousedown(function(e) {
                e.preventDefault();
            });
            svg.css({width: '100%', height: '100%'});
            if (svg.children('image').length>0) {
                var imageHRef = svg.children('image').get(0).href.baseVal;
                if (imageHRef.indexOf('data:')===-1) {
                    svg.children('image').get(0).href.baseVal =
                        mangaReader.activeVolume.path+'/'+imageHRef
                }
            }
        }
    );
}

// Zoom in / Zoom out
function zoomTo(event) {
    setTimeout(function() {
        if ($('.manga-viewport').data().regionClicked) {
            $('.manga-viewport').data().regionClicked = false;
        } else {
            if ($('.manga-viewport').zoom('value')==1) {
                $('.manga-viewport').zoom('zoomIn', event);
            } else {
                $('.manga-viewport').zoom('zoomOut');
            }
        }
    }, 1);
}

// http://code.google.com/p/chromium/issues/detail?id=128488

function isChrome() {

	return navigator.userAgent.indexOf('Chrome')!=-1;

}

function disableControls(page) {
    if ($('.manga').turn('direction')=='ltr') {
        disableControlsLTR(page);
    } else {
        disableControlsRTL(page);
    }
}

function disableControlsLTR(page) {
    if (page==1)
        $('.previous-button').hide();
    else
        $('.previous-button').show();

    if (page==$('.manga').turn('pages'))
        $('.next-button').hide();
    else
        $('.next-button').show();
}

function disableControlsRTL(page) {
    if (page==1)
        $('.next-button').hide();
    else
        $('.next-button').show();

    if (page==$('.manga').turn('pages'))
        $('.previous-button').hide();
    else
        $('.previous-button').show();
}

// Set the width and height for the viewport

function resizeViewport() {

	var width = $(window).width(),
		height = $(window).height(),
		options = $('.manga').turn('options');

	$('.manga').removeClass('animated');

	$('.manga-viewport').css({
		width: width,
		height: height
	}).
	zoom('resize');


	if ($('.manga').turn('zoom')==1) {
		var bound = calculateBound({
			width: options.width,
			height: options.height,
			boundWidth: Math.min(options.width, width),
			boundHeight: Math.min(options.height, height)
		});

		if (bound.width%2!==0)
			bound.width-=1;

			
		if (bound.width!=$('.manga').width() || bound.height!=$('.manga').height()) {

			$('.manga').turn('size', bound.width, bound.height);

			if ($('.manga').turn('page')==1)
				$('.manga').turn('peel', 'br');

			$('.next-button').css({height: bound.height, backgroundPosition: '-38px '+(bound.height/2-32/2)+'px'});
			$('.previous-button').css({height: bound.height, backgroundPosition: '-4px '+(bound.height/2-32/2)+'px'});
		}

		$('.manga').css({top: -bound.height/2, left: -bound.width/2});
	}

	var mangaOffset = $('.manga').offset(),
		boundH = height - mangaOffset.top - $('.manga').height(),
		marginTop = (boundH - $('.thumbnails > div').height()) / 2;

	if (mangaOffset.top<$('.made').height())
		$('.made').hide();
	else
		$('.made').show();

	$('.manga').addClass('animated');
	
}

// Number of views in a flipbook

function numberOfViews(book) {
	return book.turn('pages') / 2 + 1;
}

// Current view in a flipbook

function getViewNumber(book, page) {
	return parseInt((page || book.turn('page'))/2 + 1, 10);
}

// Width of the flipbook when zoomed in

function largeMagazineWidth() {
	
	return 1376;

}

// decode URL Parameters

function decodeParams(data) {

	var parts = data.split('&'), d, obj = {};

	for (var i =0; i<parts.length; i++) {
		d = parts[i].split('=');
		obj[decodeURIComponent(d[0])] = decodeURIComponent(d[1]);
	}

	return obj;
}

// Calculate the width and height of a square within another square

function calculateBound(d) {
	
	var bound = {width: d.width, height: d.height};

	if (bound.width>d.boundWidth || bound.height>d.boundHeight) {
		
		var rel = bound.width/bound.height;

		if (d.boundWidth/rel>d.boundHeight && d.boundHeight*rel<=d.boundWidth) {
			
			bound.width = Math.round(d.boundHeight*rel);
			bound.height = d.boundHeight;

		} else {
			
			bound.width = d.boundWidth;
			bound.height = Math.round(d.boundWidth/rel);
		
		}
	}
		
	return bound;
}

// Find the right method, call on correct element
function launchIntoFullscreen(element) {
    if(element.requestFullscreen) {
        element.requestFullscreen();
    } else if(element.mozRequestFullScreen) {
        element.mozRequestFullScreen();
    } else if(element.webkitRequestFullscreen) {
        element.webkitRequestFullscreen();
    } else if(element.msRequestFullscreen) {
        element.msRequestFullscreen();
    }
    fullscreenEnabled = true;
}

// Whack fullscreen
function exitFullscreen() {
    if(document.exitFullscreen) {
        document.exitFullscreen();
    } else if(document.mozCancelFullScreen) {
        document.mozCancelFullScreen();
    } else if(document.webkitExitFullscreen) {
        document.webkitExitFullscreen();
    } else if(document.msExitFullscreen) {
        document.msExitFullscreen();
    }
    fullscreenEnabled = false;
}

function getVolume(volume) {
    for(var index=0; index<mangaReader.data.length; index++) {
        if (mangaReader.data[index].info.volume == volume) {
            return mangaReader.data[index];
        }
    }
    return undefined;
}