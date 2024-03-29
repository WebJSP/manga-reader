<?php
    require_once './config/config.inc.php';
    $flipCss = filectime("assets".DS."css".DS."3dflip.css");
    $mixCss = filectime("assets".DS."css".DS."mix.css");
    $categories = $phrases["tags"];
    asort($categories);
    $catKeys = array_keys($categories);
?><!doctype html>
<html lang="<?=READER_LANGUAGE_CODE?>">
    <head>
        <title><?=$phrases["index.php"]["title"]?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
        <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.mixitup/latest/jquery.mixitup.min.js?v=2.1.2"></script>
        <script type="text/javascript" src="assets/js/sweet-alert/sweet-alert.js"></script>
        <script type="text/javascript" src="assets/js/jquery.nanoscroller.min.js"></script>
        <script type="text/javascript" src="assets/js/Tocca.min.js"></script>
        <script type="text/javascript" src="assets/js/jquery.mmenu.min.all.js"></script>
        <link href="assets/css/normalize.css" rel="stylesheet" >
        <link href="assets/css/jquery.mmenu.all.css" rel="stylesheet" >
        <link href="assets/css/sweet-alert/sweet-alert.css" rel="stylesheet" >
        <link href="assets/css/nanoscroller.css" rel="stylesheet" >
        <link href="assets/css/mix.css?<?=$mixCss?>" rel="stylesheet" />
        <link href="assets/css/3dflip.css?<?=$flipCss?>" rel="stylesheet" />
        <link href="assets/css/chosen.min.css" rel="stylesheet" >
        <style type="text/css">
            .mm-menu li.img:after
            {
                margin-left: 80px !important;
            }
            .mm-menu li.img a
            {
                font-size: 16px;
            }
            .mm-menu li.img a img
            {
                float: left;
                margin: -5px 10px -5px 0;
            }
            .mm-menu li.img a small
            {
                font-size: 12px;
            }
            
            a.mmenu {
                color: #fff;
                cursor: pointer;
            }

            a.mmenu:hover {
                color: #ccc;
            }

            a.mmenu:link {
                color: #fff;
            }

            a.mmenu:link:hover {
                color: #ccc;
            }
            
            html {
                background-image: url(assets/pics/background.jpg);
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
            }
        </style>
    </head>
    <body>
        <div class="controls">
            <a class="mmenu" href="#menu"><i class="fa fa-bars fa-2x"></i></a>
        </div>
        <div id="Container" class="container"></div>
        <nav id="menu">
            <ul>
                <li>
                    <a href="#"><?=$phrases["index.php"]["filters"]?></a>
                    <ul>
                        <li><a href="#all">Tutto</a></li>
                        <?php foreach ($categories as $key=>$value){?><li><a href="#<?=$key?>"><?=$value?></a></li> <?php }?>
                    </ul>
                </li>
                <li>
                    <a href="#"><?=$phrases["index.php"]["sort"]?></a>
                    <ul>
                        <li><button class="sort" data-sort="myorder:asc">Asc</button></li>
                        <li><button class="sort" data-sort="myorder:desc">Desc</button></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <script type="text/javascript">
            var bookShelf = {
                mangas: undefined,
                
                createFlip: function() {
                    var container = $('#Container');
                    for (var i=0; i<bookShelf.mangas.length; i++) {
                        var manga = bookShelf.mangas[i],
                            folder = manga.folder,
                            title = manga.info.title,
                            div = $(document.createElement('div')),
                            flipDiv = $(document.createElement('div')),
                            flipper = $(document.createElement('div')),
                            flipFront = $(document.createElement('div')),
                            flipBack = $(document.createElement('div'));
                        div
                            .addClass("mix "+manga.info.tags)
                            .attr("data-myorder", title);
                        flipDiv.addClass("flip-container");
                        flipper.addClass("flipper");
                        flipFront
                            .addClass("front")
                            .html("<img src=\"mangas/"+folder+"/info/cover.jpg\">")
                            .appendTo(flipper);
                        flipBack
                            .addClass("back")
                            .append(this.createVolumeList(folder, manga.folders))
                            .appendTo(flipper);
                        flipper.appendTo(flipDiv);
                        flipDiv.appendTo(div);
                        div.appendTo(container);
                    }
                },
                
                createVolumeList: function(manga, volumes) {
                    var divNano = $(document.createElement('div')).addClass('nano'),
                        ul = $(document.createElement('ul')).addClass('nano-content');
                    for (var i=0; i<volumes.length; i++) {
                        var li = $(document.createElement('li')),
                            h3 = $(document.createElement('h3'));
                        h3.text(volumes[i].info.name).appendTo(li);
                        li.appendTo(ul);
                        
                        for (var j=0; j<volumes[i].info.chapters.length; j++) {
                            var li = $(document.createElement('li')),
                                a = $(document.createElement('a')),
                                chapter = volumes[i].info.chapters[j],
                                baseUrl = 'reader.php?manga='+manga+'&vol='+volumes[i].info.volume;
                            if (chapter.page>1) {
                                baseUrl += '#page/'+chapter.page;
                            }
                            a.attr('href', baseUrl);
                            a.text(chapter.title);
                            a.appendTo(li);
                            li.appendTo(ul);
                        }
                    }
                    ul.appendTo(divNano);
                    return divNano;
                }
            };
            
            $(document).ready(function(){
                $("#menu").mmenu({
                   "offCanvas": {
                      "zposition": "front"
                   },
                   "counters": true
                })
                .find('a')
                .on("click", function(e) {
                    if (this.className!=='mm-subopen') {
                        var selected = this.hash.substr(1);
                        if (selected!=='all') {
                            selected = "."+selected;
                        }
                        $("#Container").mixItUp("filter", selected);
                        $("#menu").trigger("close.mm");
                    }
                    e.preventDefault();
                });
                $(document.body)
                    .css("height", $( window ).height()+"px");
                $(window)
                    .on("resize", function(){
                        $(document.body)
                            .css("height", $( window ).height()+"px");
                    });
                $.post('php/manga-list.php', {}, 
                    function(data) {
                        if (data.total && data.total>0) {
                            bookShelf.mangas = data.rows;
                        }
                        // create the bookshelf dom
                        if (bookShelf.mangas && bookShelf.mangas.length>0) {
                            bookShelf.createFlip();
                            $(".nano").nanoScroller({ 
                                preventPageScrolling: true,
                                alwaysVisible: true
                            });
                            $("#Container").mixItUp();
                            $(".back").on( "mouseenter", function(){
                                $(".nano").nanoScroller();
                            });
                            $(".flip-container").on("tap", function(e, data){
                                $(".flip-container").removeClass("hover");
                                $(this).addClass("hover");
                                e.preventDefault();
                            });
                            $(document).on("tap", function(e, data){
                                $(".flip-container").removeClass("hover");
                                e.preventDefault();
                            });
                        }
                    }
                );
            });
        </script>
    </body>
</html> 