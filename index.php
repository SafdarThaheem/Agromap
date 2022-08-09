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

    <div class="around-div">
        <!-- left Sidebar -->
        <div id="mySidebar" class="sidebar">
            <a href="php/logout.php" style="margin-left: -15px;"><img src="images/logout.png" alt=""></i></a>
            <a href="#" style="margin-left: -15px;" onclick="openFilter()"><img src="images/Setting_add_Custom_route.svg" alt=""></a>
            <a href="#" style="margin-left: -15px;" onclick="openCharts()"><img src="images/Charts.svg" alt=""></a>
            <a href="#" style="margin-left: -15px;" onclick="openTable()"><img src="images/Icon metro-table.svg" alt=""></a>
            <a href="#" style="margin-left: -15px;"><img src="images/Upload_Button.svg" alt=""></a>
            <a href="#" style="margin-left: -15px;"><img src="images/Layer_On_Off.svg" alt=""></i></a>
            <a href="#" style="margin-left: -15px;"><img src="images/Base_map.svg" alt=""></i></a>
            <a href="#" style="margin-left: -15px;"><img src="images/ico_logo/Heat Map active inactive.svg" alt=""></i></a>
            <a href="#" style="margin-left: -15px;"><img src="images/ico_logo/Cluster Active inactive.svg" alt=""></i></a>
        </div>
        <!-- end left sidebar -->

        <!-- start Nav  -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white py-0 main-nav">
            <div class="container-fluid inner-nav-container">
                <button class="openbtn left-side-menu" onclick="openNav()"><img src="images/ico_logo/Menu_Icon feather.svg" class="sidebar-menu-bars" alt=""></button>
                <a class="navbar-brand px-0 py-0 agromap-logo" href="#">
                    <img src="images/AgroMap-top-logo.png" alt="" style="width: 260px;">
                </a>
                <button class="navbar-toggler right-menu-button" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                    <img src="images/ico_logo/Menu_Icon feather.svg" class="sidebar-menu-bars" alt="">
                </button>
                <div class="collapse navbar-collapse flex-grow-0 sm-icon" id="navbarTogglerDemo03">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
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

        <div id="main">

            <!-- start Nav form -->
            <nav class="navbar navbar-expand-lg navbar-light py-0" style="background-color: #2D2D2D;">
                <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                    <div id="filterPanel" style="display: none;" class="form-outer-div">
                        <form style="color: white;">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class=" col-md form-group">
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
                                        <label>ÁreaSembrada</label>
                                        <input name="Plant_area_from" type="number" class="form-control rounded-pill" min="0" placeholder="min" id="Plant_area_from">
                                        <label>To</label>
                                        <input name="Plant_area_to" type="number" class="form-control rounded-pill" min="0" placeholder="max" id="Plant_area_to">
                                    </div>

                                    <div class=" col-md form-group">
                                        <label>ÁreaCosechada</label>
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

                                    <div class="col-md form-group form-button-div">
                                        <input name="submit" type="submit" style="border-radius: 10px; margin:10px;" class="btn btn-primary" value="Aplicar">
                                        <input name="clear" id="clearFilter" type="submit" style="border-radius: 10px; margin:10px;" class="btn btn-primary" value="Limpiar">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </nav>
            <!-- end nav form -->

            <!-- Map and right sidebar -->
            <div class="container-fluid">
                <div class="row map-area">
                    <div class="col-md px-0">
                        <div class="row">
                            <div style="background-color: black;opacity: 0.7;" class="col-md-12">

                            </div>
                        </div>

                        <div class="row map-div mx-0">
                            <div id="map" style="width: 100%; height: calc(100vh - 94px); padding: 0 0 0 0 ;margin: 0 0 0 0;"></div>

                            <div id="chartsPanel" style="display: none; width: 0;">

                                <div class="row right-sidebar-row">
                                    <div class="col-sm right-sidebar-col">
                                        <p>Total de productores</p>
                                        <h1><b>2,580</b></h1>
                                    </div>
                                    <div class="col-sm right-sidebar-col">
                                        <p>Clientes</p>
                                        <h1><b>350</b></h1>
                                    </div>
                                </div>

                                <div class="row right-sidebar-row">
                                    <div class="col-sm right-sidebar-col">
                                        <p>Proximos a sembrar</p>
                                        <p>(3 messes)</p>
                                        <h1><b>250</b></h1>
                                    </div>
                                    <div class="col-sm right-sidebar-col">
                                        <p>Proximos a cosechar</p>
                                        <p>(3 messes)</p>
                                        <h1><b>120</b></h1>
                                    </div>
                                </div>

                                <div class="row">
                                    <div id="chartContainer1" class="col-md-10">
                                        <h5><b>Área sembrada por provincia</b></h5>
                                        <img src="images/column-chart.png" alt="">
                                    </div>

                                    <div class="w-100"></div>

                                    <div id="chartContainer2" class="col-md-10">
                                        <h5><b>Área sembrada por provincia</b></h5>
                                        <img src="images/column-chart.png" alt="">
                                    </div>

                                    <div class="w-100"></div>

                                    <div id="chartContainer3" class="col-md-10">
                                        <h5><b>Variedad de Semilla por provincia</b></h5>
                                        <img src="images/pai-chart.png" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end Map and right sidebar -->


            <!-- Table Area -->
            <div id="resultsTable" style="display:none;" class="table-responsive">
                <div class="row upper-table-from mx-0">
                    <div class="col-md-6 button-div">
                        <button type="button" class="btn btn-light btn-sm ">CSV</button>
                        <button type="button" class="btn btn-light btn-sm">EXCEL</button>
                    </div>
                    <div class="col-md-6 textbox">
                        <input type="text" id="inputtext" class="form-control form-control-sm" placeholder="Buscar" aria-describedby="passwordHelpBlock">
                    </div>
                </div>

                <table class="table table-secondary table-bordered table-sm table-hover">
                    <thead class="table-dark">
                        <tr class="">
                            <th scope="col"></th>
                            <th scope="col">Field 1</th>
                            <th scope="col">Field 2</th>
                            <th scope="col">Field 3</th>
                            <th scope="col">Field 4</th>
                            <th scope="col">Field 5</th>
                            <th scope="col">Field 6</th>
                            <th scope="col">Field 7</th>
                            <th scope="col">Field 8</th>
                            <th scope="col">Field 9</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Data 1</td>
                            <td>Data 2</td>
                            <td>Data 3</td>
                            <td>Data 4</td>
                            <td>Data 5</td>
                            <td>Data 6</td>
                            <td>Data 7</td>
                            <td>Data 8</td>
                            <td>Data 9</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>Data 1</td>
                            <td>Data 2</td>
                            <td>Data 3</td>
                            <td>Data 4</td>
                            <td>Data 5</td>
                            <td>Data 6</td>
                            <td>Data 7</td>
                            <td>Data 8</td>
                            <td>Data 9</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>Data 1</td>
                            <td>Data 2</td>
                            <td>Data 3</td>
                            <td>Data 4</td>
                            <td>Data 5</td>
                            <td>Data 6</td>
                            <td>Data 7</td>
                            <td>Data 8</td>
                            <td>Data 9</td>
                        </tr>
                        <tr>
                            <th scope="row">4</th>
                            <td>Data 1</td>
                            <td>Data 2</td>
                            <td>Data 3</td>
                            <td>Data 4</td>
                            <td>Data 5</td>
                            <td>Data 6</td>
                            <td>Data 7</td>
                            <td>Data 8</td>
                            <td>Data 9</td>
                        </tr>
                        <tr>
                            <th scope="row">5</th>
                            <td>Data 1</td>
                            <td>Data 2</td>
                            <td>Data 3</td>
                            <td>Data 4</td>
                            <td>Data 5</td>
                            <td>Data 6</td>
                            <td>Data 7</td>
                            <td>Data 8</td>
                            <td>Data 9</td>
                        </tr>
                        <tr>
                            <th scope="row">6</th>
                            <td>Data 1</td>
                            <td>Data 2</td>
                            <td>Data 3</td>
                            <td>Data 4</td>
                            <td>Data 5</td>
                            <td>Data 6</td>
                            <td>Data 7</td>
                            <td>Data 8</td>
                            <td>Data 9</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- end Table Area -->
        </div>
    </div>

</body>

</html>