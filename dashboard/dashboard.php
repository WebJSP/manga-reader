<?php
session_start();
require_once('../config/config.inc.php');

if (isset($_SESSION['admin_id']) && in_array($_SESSION['admin_id'], $ADMIN_IDs)) {
    $firstName = $_SESSION["first_name"];
    $screenName = $_SESSION["display_name"];
    $photoUrl = $_SESSION["photo_url"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="perin.massimo@gmail.com">

    <title><?=$phrases["dashboard/dashboard.php"]["title"]?></title>

    <!-- Bootstrap Core CSS -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="//cdnjs.cloudflare.com/ajax/libs/metisMenu/1.1.3/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../assets/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    
    <link href="//cdnjs.cloudflare.com/ajax/libs/jquery-bootgrid/1.1.4/jquery.bootgrid.min.css">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <script src="../assets/js/sweet-alert-bootstrap/sweet-alert.min.js"></script>
    <link href="../assets/css/sweet-alert-bootstrap/sweet-alert.css" rel="stylesheet" >
</head>
<body>
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <img src="../assets/pics/manga-reader.svgz" style="height: 40px;float: left;">
                <a class="navbar-brand" href="dashboard.php"><?=$phrases["dashboard/dashboard.php"]["navbar-brand"]?></a>
            </div>
            <!-- /.navbar-header -->
            
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-gear fa-fw"></i> <?=$phrases["dashboard/dashboard.php"]["account"]?>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <div class="navbar-content">
                                <div class="row">
                                    <div class="col-md-5">
                                        <img src="<?php echo $photoUrl;?>"
                                            alt="<?php echo $screenName;?>" class="img-circle img-responsive" />
                                    </div>
                                    <div class="col-md-7">
                                        <span><?php echo $firstName;?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="navbar-footer">
                                <div class="navbar-footer-content">
                                    <div class="row">
                                        <div class="col-md-6">
                                        </div>
                                        <div class="col-md-6">
                                            <a href="logout.php" class="btn btn-default btn-sm pull-right">
                                                <i class="fa fa-sign-out fa-fw"></i> <?=$phrases["dashboard/dashboard.php"]["sign-out"]?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="<?=$phrases["dashboard/dashboard.php"]["search"]?>">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="#create"><i class="fa fa-file-o fa-fw"></i> <?=$phrases["dashboard/dashboard.php"]["create"]?></a>
                        </li>
                        <li>
                            <a href="#remove"><i class="fa fa-trash-o fa-fw"></i> <?=$phrases["dashboard/dashboard.php"]["remove"]?></a>
                        </li>
                        <li>
                            <a href="#edit"><i class="fa fa-edit fa-fw"></i> <?=$phrases["dashboard/dashboard.php"]["edit"]?></a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?=$phrases["dashboard/dashboard.php"]["dashboard"]?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row" id="manga-list">
                <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-list fa-fw"></i> <?=$phrases["dashboard/dashboard.php"]["manga-list"]?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!--div class="table-responsive"-->
                                <table class="table table-condensed table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th data-column-id="id" data-sortable="false" data-type="numeric">#</th>
                                            <th data-column-id="title"><?=$phrases["dashboard/manga-list.php"]["title"]?></th>
                                            <th data-column-id="folder" data-identifier="true" data-order="asc"><?=$phrases["dashboard/manga-list.php"]["folder"]?></th>
                                            <th data-column-id="creation"><?=$phrases["dashboard/manga-list.php"]["creation"]?></th>
                                        </tr>
                                    </thead>
                                </table>
                            <!--/div-->
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-8 -->
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> <?=$phrases["dashboard/dashboard.php"]["notifications"]?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="list-group">
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-comment fa-fw"></i> New Comment
                                    <span class="pull-right text-muted small">
                                        <em>4 minutes ago</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">
                                        <em>12 minutes ago</em>
                                    </span>
                                </a>
                            </div>
                            <!-- /.list-group -->
                            <a href="#" class="btn btn-default btn-block"><?=$phrases["dashboard/dashboard.php"]["view-all-alerts"]?></a>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
            <div class="row hidden" id="create-manga">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-file-o fa-fw"></i> <?=$phrases["dashboard/dashboard.php"]["manga-creation"]?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <form role="form" id="create-manga-form">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label><?=$phrases["dashboard/dashboard.php"]["manga-name-label"]?></label>
                                            <input class="form-control" 
                                                placeholder="<?=$phrases["dashboard/dashboard.php"]["manga-name-placeholder"]?>" 
                                                name="manga-name">
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label><?=$phrases["dashboard/dashboard.php"]["manga-title-label"]?></label>
                                            <input class="form-control" name="manga-title">
                                        </div>
                                    </div>
                                </div>
                                <!-- /.row -->
                                <div class="row">
                                    <div class="col-lg-4">
                                        <button type="button" class="btn btn-default" id="create-manga-submit"><?=$phrases["dashboard/dashboard.php"]["submit-button"]?></button>
                                        <button type="reset" class="btn btn-default"><?=$phrases["dashboard/dashboard.php"]["reset-button"]?></button>
                                    </div>
                                </div>
                                <!-- /.row -->
                            </form>                                
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row hidden" id="edit-manga">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-edit fa-fw"></i> <?=$phrases["dashboard/dashboard.php"]["edit-manga"]?> - <span id="manga-title"></span>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/metisMenu/1.1.3/metisMenu.min.js"></script>
    
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-bootgrid/1.1.4/jquery.bootgrid.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/dashboard.js?lu=<?=filectime("js".DS."dashboard.js")?>"></script>
    <script type="text/javascript">
        var dashboard = {
          grid: undefined  
        };
        $(document).ready(function(){
            dashboard.grid = $('#manga-list table').bootgrid({
                ajax: true,
                selection: true,
                url: "manga-list.php",
                rowSelect: true,
                rowCount: 10,
                columnSelection: false
            }).on("selected.rs.jquery.bootgrid", function(e, rows)
            {
                //alert(rows[0].folder);
            }); 
        });
        
        function showNotLoggedAlert() {
            sweetAlert({
                title: "<?=$phrases["dashboard/php/create-manga.php"]["alert-title"]?>",
                text: "<?=$phrases["dashboard/php/create-manga.php"]["no-access"]?>",
                type: "error",
                confirmButtonClass: 'btn-danger',
                confirmButtonText: 'Ok'
            });
        };
        
        function showExistingFolderAlert() {
            sweetAlert({
                title: "<?=$phrases["dashboard/php/create-manga.php"]["alert-title"]?>",
                text: "<?=$phrases["dashboard/php/create-manga.php"]["folder-exists"]?>",
                type: "error",
                confirmButtonClass: 'btn-danger',
                confirmButtonText: 'Ok'
            });
        };
        
        function removeManga(event) {
            var selectedRadio = $('input[name=folder]:radio').filter(":checked");
            if (selectedRadio.length>0) {
                sweetAlert({
                    title: "<?=$phrases["dashboard/php/delete-manga.php"]["alert-title"]?>", 
                    text: "<?=$phrases["dashboard/php/delete-manga.php"]["warning-message"]?>", 
                    type: "warning", 
                    showCancelButton: true, 
                    cancelButtonText: "<?=$phrases["dashboard/php/delete-manga.php"]["cancel-button"]?>",
                    confirmButtonColor: "#DD6B55", 
                    confirmButtonText: "<?=$phrases["dashboard/php/delete-manga.php"]["yes-button"]?>"
                }, function () {
                    $.ajax("php/delete-manga.php", {
                        method: "post",
                        data: {
                            name: selectedRadio.val()
                        },
                        cache: false,
                        statusCode: {
                            "403": showNotLoggedAlert
                        }
                    }).done(function(data, textStatus, jqXHR){
                        if (!data.success) {
                            sweetAlert({
                                text: data.error, 
                                type: "error", 
                                confirmButtonColor: "#DD6B55", 
                                confirmButtonText: "<?=$phrases["dashboard/php/delete-manga.php"]["yes-button"]?>"
                            });
                        }
                    }).always(function(){
                        dashboard.grid.reload(); 
                    });
                });
            }
            event.preventDefault();
        }
    </script>
</body>

</html>
<?php 
} else {
    // Redirection to login page twitter, facebook or google
    header("location: index.php?noauth=1");
}
?>