<html>
    <head>
        <title>
            ini adalah salah satu tugas expert system
        </title>

        <link href="./assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="./assets/css/bootstrap-grid.min.css" rel="stylesheet" type="text/css">
        <link href="./assets/css/bootstrap-reboot.min.css" rel="stylesheet" type="text/css">
        <link href="./assets/css/select2.min.css" rel="stylesheet" />
        <link href="./assets/css/open-iconic.css" rel="stylesheet" />
        <link href="./assets/css/open-iconic-bootstrap.css" rel="stylesheet" />
        
        
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

        <script src="./assets/js/jquery-3.3.1.min.js"></script>
        <script src="./assets/js/bootstrap.min.js"></script>
        <script src="./assets/js/select2.min.js"></script>
        <script src="./assets/js/jquery.toast.min.js"></script>
        <style>
            .searchable-container {margin:20px 0 0 0}
            .searchable-container label.btn-default.active{background-color:#007ba7;color:#FFF}
            .searchable-container label.btn-default{width:100%;border:1px solid #efefef;margin:5px; box-shadow:5px 8px 8px 0 #ccc;}
            .searchable-container label .bizcontent{width:100%;}
            .searchable-container .btn-group{width:100%}
            .searchable-container .btn span.oi{
                opacity: 0;
            }
            .searchable-container .btn.active span.oi {
                opacity: 1;
            }

        </style>
    </head>
    <body>
        <?php
            require_once './config/config.php';
            //INITIALIZE GLOBAL VARIABLE
            $active_page = "";   

            $page = isset($_GET['page']) && $_GET['page']? $_GET['page'] : null;
            $active_page = isset($page) ? $page : "home"; 

            $query = "SELECT * FROM symptoms";
            $rows = select($query);

        ?>

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="?"> <img class="logo" src="./assets/img/logo.png" height="40"> Sistem Pakar</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar1" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar1">
                <ul class="navbar-nav ml-auto"> 
                    <li class="nav-item <?php echo $active_page == "home" ? 'active' : '' ?>">
                        <a class="nav-link" href="?">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item <?php echo $active_page == "list_symptoms" ? 'active' : '' ?>">
                        <a class="nav-link" href="admin"> admin </a>
                    </li>
                </ul>
            </div>
        </nav>
        
        <div class="container" style="margin-bottom:30px">
            <form id="form-diagnosis" method="post" action="/resultDiagnosis.php">
                <div class="row searchable-container">
                    <?php foreach ($rows as $row) {?>
                        <div class="form-group col-md-3">
                            <div class="info-block block-info clearfix">
                                <div data-toggle="buttons" class="btn-group bizmoduleselect">
                                    <label class="btn btn-default">
                                        <div class="bizcontent">
                                            <input type="checkbox" name="symptoms[]" autocomplete="off" value="<?php echo $row["id"];?>" style="display:none">
                                            <span class="oi" data-glyph="check"></span>
                                            <h5><?php echo $row["name"];?></h5>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    <?php }?>
                </div>
                <hr />
                <button type="submit" class="btn btn-success btn-lg ">Diagnosa</button>
            </form>
        </div>

        <article class="bg-secondary mb-3">  
            <div class="card-body text-center">
                <h4 class="text-white">HTML UI KIT <br> Ready to use Bootstrap 4 components and templates </h4>
            <p class="h5 text-white"> for Ecommerce, marketplace, booking websites 
            and product landing pages</p>   <br>
            <p><a class="btn btn-warning" target="_blank" href="http://bootstrap-ecommerce.com/"> Bootstrap-ecommerce.com  
            <i class="fa fa-window-restore "></i></a></p>
            </div>
            <br><br>
        </article>
    </body>
</html>