<html>
    <head>
        <title>
            Sistem Pakar Perbaikan Handphone
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
    </head>
    <body>
        <?php
            require_once './config/config.php';
            //INITIALIZE GLOBAL VARIABLE
            $active_page = "";  
            if(count($_POST) == 0)
                return header ( "location:/");
                
            include "./admin/core/core.php";
            $string_selected = implode(",", $symptoms_selected);

            $query = "SELECT * FROM symptoms WHERE id in ({$string_selected})";
            $rows_symptoms = select($query);
        ?>

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="?"> <img class="logo" src="./assets/img/logo.png" height="40"> Expert System</a>
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
        
        <div class="container" style="margin-top:10px; margin-bottom:10px">
            <div class="row">
                <div class="form-group">
                    <h4>Hasil diagnosa dari Gejala Kerusakan</h4>
                    <h5>
                    <?php foreach($rows_symptoms as $i => $row){
                        echo "<b>";
                        echo ucfirst($row["name"]);
                        echo isset($rows_symptoms[$i + 1]) ? ", " : "";
                        echo "</b> ";                        
                    }?>
                    </h5>
                </div>
            </div>
            <table id="results-diagnosis" class="table" style="width:100%">
            </table>
        </div>

        <div class="modal fade" id="view-solutions" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

           
        <script src="./assets/js/datatables.min.js"></script>
        <script>
            var schema = [
                { "data": "diagnosa_name", "name": "diagnosa_name", "title": "Nama Kerusakan"},
                { "data": "percentage", "name": "percentage", "title": "Persentase", render: function(data, type, full){
                        return ""+data+" %";
                    }
                },
                { "data": "diagnosis_id", render: function(data, type, full){
                        return  "<button type='button' title='lihat solusi' style='background: transparent' class='btn btn-default btn-sm' onclick='viewSolutions("+data+")'>Lihat Solusi</button>";
                    }
                },
            ];

            var customDom = "<'row'<'col-sm-4 col-md-2 insert-diagnosa'><'col-sm-4 col-md-2 calculate'>"+
                            "<'col-sm-4 col-md-2'l><'col-sm-12 col-md-6'f>>" +
                            "<'row'<'col-sm-12'tr>>" +
                            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>";

            var data = <?php echo json_encode($bayes); ?>;
            $('#results-diagnosis').DataTable( {
                "data": data,
                "columns": schema,
                "order": [[ 1, "desc" ]],
                "bPaginate": false,
                "bLengthChange": false,
                "bFilter": true,
                "bInfo": false,
                "searching": false,
            } );
            
            function viewSolutions(id){
                $("#view-solutions")["modal"]("show");
                $.get("/api/dataApi.php?type=get_solutions&id="+id,function(responses, status){
                    var data = JSON.parse(responses);
                    $("#view-solutions .modal-body").html("");
                    $("#view-solutions .modal-body").html(data["description"]);
                });
            }

        </script>

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