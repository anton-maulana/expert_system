<html>
    <head>
        <title>
            ini adalah salah satu tugas expert system
        </title>

        <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/css/bootstrap-grid.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/css/bootstrap-reboot.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/css/select2.min.css" rel="stylesheet" />
        <link href="../assets/css/datatables.min.css" rel="stylesheet" />
        <link href="../assets/css/jquery.toast.min.css" rel="stylesheet" />
        <link href="../assets/css/custom.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

        <script src="../assets/js/jquery-3.3.1.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
        <script src="../assets/js/select2.min.js"></script>
        <script src="../assets/js/jquery.toast.min.js"></script>
        <script src="./scripts/utils.js"></script>        
    </head>
    <body>
        <?php
            //INITIALIZE GLOBAL VARIABLE
            $active_page = "";     

            $page = isset($_GET['page']) && $_GET['page']? $_GET['page'] : null;
            $active_page = isset($page) ? $page : "home";   
        ?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="../"> <img class="logo" src="http://bootstrap-ecommerce.com/main/images/logo-white.png" height="40"> Expert System</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar1" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar1">
                <ul class="navbar-nav ml-auto"> 
                    <li class="nav-item <?php echo $active_page == "home" ? 'active' : '' ?>">
                        <a class="nav-link" href="?">Dashboard <span class="sr-only">(current)</span></a>
                    </li>
                </ul>
            </div>
        </nav>
        <?php
            include("./utils/contentManager.php");
        ?>
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

        <script src="./scripts/api.js"></script>
        <script src="./scripts/utils.js"></script>
    </body>
</html>