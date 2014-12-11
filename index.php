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
        <script type="text/javascript" src="assets/js/chosen.jquery.min.js"></script>
        <script type="text/javascript" src="assets/js/Tocca.min.js"></script>
        <link href="assets/css/sweet-alert/sweet-alert.css" rel="stylesheet" >
        <link href="assets/css/nanoscroller.css" rel="stylesheet" >
        <link href="assets/css/mix.css?<?=$mixCss?>" rel="stylesheet" />
        <link href="assets/css/3dflip.css?<?=$flipCss?>" rel="stylesheet" />
        <link href="assets/css/chosen.min.css" rel="stylesheet" >
    </head>
    <body>
        <div class="controls">
            <label for="filter"><?=$phrases["index.php"]["filters"]?>:</label>
            <select id="filter" name="filter" style="width:25%">
                <option value="all" selected="selected">Tutto</option>
                <?php foreach ($categories as $key=>$value){?><option value=".<?=$key?>"><?=$value?></option> <?php }?>

            </select>
            <label><?=$phrases["index.php"]["sort"]?>:</label>
            <button class="sort" data-sort="myorder:asc">Asc</button>
            <button class="sort" data-sort="myorder:desc">Desc</button>
        </div>
        <div id="Container" class="container"></div>
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
                $('#filter')
                    .chosen()
                    .on('change', function(event, params){
                        $("#Container").mixItUp("filter", params.selected);
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