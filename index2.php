<?php
    require_once './config/config.inc.php';
    $location = "reader.php";
    $folder = filter_input(INPUT_GET, "manga");
    if (!isset($folder)) {
        $folder = getFirstManga(__DIR__);
    }
    $location.="?manga=".$folder;
    $volume = filter_input(INPUT_GET, "vol");
    if (!isset($volume)) {
        $volume = 1;
    }
    $location.="&vol=".$volume;
    $page = filter_input(INPUT_GET, "page");
    if (isset($page)) {
        $location.="#page/".$page;
    }
?><!doctype html>
<html lang="<?=READER_LANGUAGE_CODE?>">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <link href="assets/css/3dflip.css" type="text/css" />
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
        <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.mixitup/latest/jquery.mixitup.min.js?v=2.1.2"></script>
        <script src="assets/js/sweet-alert/sweet-alert.js"></script>
        <link href="assets/css/sweet-alert/sweet-alert.css" rel="stylesheet" >
        <style type="text/css">
            *{
              -webkit-box-sizing: border-box;
              -moz-box-sizing: border-box;
              box-sizing: border-box;
            }

            body, button{
              font-family: 'Helvetica Neue', arial, sans-serif;
            }

            .controls{
              padding: 2%;
              background: #333;
              color: #eee;
            }

            label{
              font-weight: 300;
              margin: 0 .4em 0 0;
            }

            button{
              display: inline-block;
              padding: .4em .8em;
              background: #666;
              border: 0;
              color: #ddd;
              font-size: 16px;
              font-weight: 300;
              border-radius: 4px;
              cursor: pointer;
            }

            button.active{
              background: #68b8c4;
            }

            button:focus{
              outline: 0 none;
            }

            button + label{
              margin-left: 1em;
            }

            .container{
              padding: 2% 2% 0;
              text-align: justify;
              font-size: 0.1px;
              background: #68b8c4;

              -webkit-backface-visibility: hidden;
            }

            .container:after{
              content: '';
              display: inline-block;
              width: 100%;
            }

            .container .mix,
            .container .gap{
              display: inline-block;
              width: 49%;
            }

            .container .mix{
              text-align: left;
              background: #03899c;
              margin-bottom: 2%;
              display: none;
            }

            .container .mix.category-1{
              border-top: 2px solid limegreen;
            }

            .container .mix.category-2{
              border-top: 2px solid yellow;
            }

            .container .mix:after{
              content: attr(data-myorder);
              color: white;
              font-size: 16px;
              display: inline-block;
              vertical-align: top;
              padding: 4% 6%;
              font-weight: 700;
            }

            .container .mix:before{
              content: '';
              display: inline-block;
              padding-top: 60%;
            }

            @media all and (min-width: 420px){
              .container .mix,
              .container .gap{
                width: 32%;
              }
            }

            @media all and (min-width: 640px){
              .container .mix,
              .container .gap{
                width: 23.5%;
              }
            }            
        </style>
    </head>
    <body>
        <div class="controls">
            <label>Filtri:</label>
            <button class="filter active" data-filter="all">Tutto</button>
            <button class="filter" data-filter=".category-1">Sentimentali</button>
            <button class="filter" data-filter=".category-2">Scolastici</button>
            <label>Ordinamento:</label>
            <button class="sort" data-sort="myorder:asc">Asc</button>
            <button class="sort" data-sort="myorder:desc">Desc</button>
        </div>
        <div id="Container" class="container">
            
        </div>
        <script type="text/javascript">
            var bookShelf = {
                mangas: undefined
            };
            
            $(document).ready(function(){
                $.post('php/manga-list.php', {}, 
                    function(data) {
                        if (data.total && data.total>0) {
                            bookShelf.mangas = data.rows;
                        }
                        // create the bookshelf dom
                        if (bookShelf.mangas && bookShelf.mangas.length>0) {
                            var container = $('#Container');
                            for (var i=0; i<bookShelf.mangas.length; i++) {
                                var manga = bookShelf.mangas[i],
                                    folder = 'mangas/'+manga.folder,
                                    title = manga.title,
                                    div = $(document.createElement('div')),
                                    flipDiv = $(document.createElement('div')),
                                    flipper = $(document.createElement('div')),
                                    flipFront = $(document.createElement('div')),
                                    flipBack = $(document.createElement('div'));
                                div.addClass("mix");
                                flipDiv.addClass("flip-container");
                                flipper.addClass("flipper");
                                flipFront.addClass("front").html("<p>"+title+"</p>").appendTo(flipper);
                                flipBack.addClass("back").appendTo(flipper);
                                flipper.appendTo(flipDiv);
                                flipDiv.appendTo(div);
                                div.appendTo(container);
                            }
                            console.dir(bookShelf.mangas);
                        }
                    }
                );
            });
        </script>
    </body>
</html> 