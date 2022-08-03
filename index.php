<?php
// session_start();

// if(!isset($_SESSION['username'])){
// header("Location: login.php");
// }
?>

<!DOCTYPE html>
<html lang="en" ng-app="geoportal">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agromap</title>

    <link rel="icon" type="image/x-icon" href="images/favicon.svg">


    <script src="js/jquery.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" />

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js"></script>

    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script src="js/map.js"></script>

    <script src="https://unpkg.com/geojson-vt@3.2.0/geojson-vt.js"></script>
    <script src="js/leaflet-geojson-vt.js"></script>

</head>

<body>
    <!-- statr Nav  -->
    <nav class="navbar navbar-expand-lg py-0 main-nav">
        <div class="container-fluid inner-div">
            <a href="#">
                <img src="images/ico_logo/Menu_Icon feather.svg" class="sidebar-menu-icon" alt="">
            </a>
            <a class="navbar-brand m-auto py-0" href="#">
                <img src="images/AgroMap-top-logo.png" alt="" style="width: 260px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                <img src="images/ico_logo/Menu_Icon feather.svg" class="sidebar-menu-icon" alt="">
                <!-- <span class="navbar-toggler-icon"></span> -->
            </button>
            <div class="collapse navbar-collapse flex-grow-0 tog-div" id="navbarTogglerDemo03">
                <ul class="navbar-nav mx-auto sm-icon">
                    <li class="nav-item">
                        <a class="nav-link active" href="#"><img src="images/ico_logo/Search.svg" alt=""></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><img src="images/ico_logo/Share map.svg" alt=""></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#"><img src="images/ico_logo/Tool Map.svg" alt=""></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#"><img src="images/ico_logo/Logout.svg" alt=""></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#"><img src="images/ico_logo/Avatar.svg" alt=""></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- end nav -->

    <!-- statr Nav form -->
    <nav class="navbar navbar-expand-lg navbar-light py-0" style="background-color: #2D2D2D;">
        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <div id="filterPanel" class="form-outer-div">
                <form style="color: white;">
                    <div class="row">
                        <div class=" col-md form-group" >
                            <label for="Tipo" id="Tipo_label">Tipo</label>
                            <select name="Tipo" class="form-control form-select rounded-pill" id="Tipo_select">
                                <option value="">Tipo</option>
                            </select>

                            <label for="Provincia" id="Provincia_label">Provincia</label>
                            <select name="Provincia" class="form-control form-select rounded-pill" id="Provincia_select">
                                <option>Provincia</option>
                            </select>
                        </div>

                        <div class=" col-md form-group">
                            <label for="District" id="District">Distrito</label>
                            <select name="District" class="form-control form-select rounded-pill" id="District_select">
                                <option value="">Distrito</option>
                            </select>

                            <label for="Corregimiento" id="Corregimiento">Corregimiento</label>
                            <select name="Correg" class="form-control form-select rounded-pill" id="Crg_select">
                                <option value="">Corregimiento</option>
                            </select>
                        </div>

                        <div class=" col-md form-group">
                            <label>Fecha de siembra</label>
                            <input name="Plant_date_from" type="date" class="form-control rounded-pill" id="Plant_date_from" placeholder="">
                            <label>To</label>
                            <input name="Plant_date_to" type="date" class="form-control rounded-pill" id="Plant_date_to" placeholder="">
                        </div>

                        <div class=" col-md form-group">
                            <label>Fecha de cosecha</label>
                            <input name="Harvest_date_from" type="date" class="form-control rounded-pill" id="Harvest_date_from">
                            <label>To</label>
                            <input name="Harvest_date_to" type="date" class="form-control rounded-pill" id="Harvest_date_to">
                        </div>

                        <div class=" col-md form-group">
                            <label>Fecha de actualización</label>
                            <input name="Update_date_from" type="date" class="form-control rounded-pill" id="Update_date_from">
                            <label>To</label>
                            <input name="Update_date_to" type="date" class="form-control rounded-pill" id="Update_date_to">
                        </div>

                        <div class=" col-md form-group">
                            <label>Área sembrada</label>
                            <input name="Plant_area_from" type="number" class="form-control rounded-pill" min="0" placeholder="min" id="Plant_area_from">
                            <label>To</label>
                            <input name="Plant_area_to" type="number" class="form-control rounded-pill" min="0" placeholder="max" id="Plant_area_to">
                        </div>

                        <div class=" col-md form-group">
                            <label>Área cosechada</label>
                            <input name="Harvest_area_from" type="number" class="form-control rounded-pill" min="0" placeholder="min" id="Harvest_area_from">
                            <label>To</label>
                            <input name="Harvest_area_to" type="number" class="form-control rounded-pill" min="0" placeholder="max" id="Harvest_area_to">
                        </div>

                        <div class=" col-md form-group">
                            <label>Responsable</label>
                            <select name="Responsabl" class="form-control form-select rounded-pill" id="Responsible_select">
                                <option value="">Responsable</option>
                            </select>

                            <label>Variedad</label>
                            <select name="Variedad" class="form-control form-select rounded-pill" id="Variety_select">
                                <option value="">Variedad</option>
                            </select>
                        </div>

                        <div class="col-md form-group">
                            <input name="submit" type="submit" style="border-radius: 10px;" class="btn btn-primary" value="Aplicar">
                            <input name="clear" id="clearFilter" type="submit" style="border-radius: 10px;" class="btn btn-primary" value="Limpiar">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </nav>
    <!-- end nav form -->

    <div id="mySidebar" class="sidebar">
        <!-- <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a> -->
        <a href="php/logout.php" style="margin-left: -15px;"><img src="images/logout.png" alt=""></i></a>
        <a href="#" style="margin-left: -15px;" onclick="openFilter()"><img src="images/Setting_add_Custom_route.svg" alt=""></a>
        <a href="#" style="margin-left: -15px;" onclick="openCharts()"><img src="images/Charts.svg" alt=""></a>
        <a href="#" style="margin-left: -15px;" onclick="openTable()"><img src="images/Icon metro-table.svg" alt=""></a>
        <a href="#" style="margin-left: -15px;"><img src="images/Upload_Button.svg" alt=""></a>
        <a href="#" style="margin-left: -15px;"><img src="images/Layer_On_Off.svg" alt=""></i></a>
        <a href="#" style="margin-left: -15px;"><img src="images/Base_map.svg" alt=""></i></a>
    </div>

    <!-- <div id="main" class="container-fluid">

        <div class="row">
            <div style="background-color: black;opacity: 0.7;" class="col-md-12">


            </div>
        </div>

        <div class="row">
            <div id="map" style="width: 100%; height: 120vh; padding: 0 0 0 0 ;margin: 0 0 0 0;" class="col-md-8"></div>

            <div id="chartsPanel" class="col-md-4" style="display: none; width: 0;">
                <div class="row">
                    <div id="chartContainer1" style="height: 40vh; width: 100%;" class="col-md-10">
                    </div>

                    <div class="w-100"></div>

                    <div id="chartContainer2" style="height: 40vh; width: 100%;" class="col-md-10">
                    </div>

                    <div class="w-100"></div>

                    <div id="chartContainer3" style="height: 40vh; width: 100%; " class="col-md-10">
                    </div>
                </div>
            </div>

        </div>

        <br><br>
    </div> -->

</body>

</html>