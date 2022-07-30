<?php 
    session_start();

    if(!isset($_SESSION['username'])){
        header("Location: login.php");
    }
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

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css"/>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>

    <link rel="stylesheet" href="js/bootstrap/dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css"/>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css"/>
    <script src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js"></script>
    
    <script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script src="js/map.js"></script>

    <script src="https://unpkg.com/geojson-vt@3.2.0/geojson-vt.js"></script>
    <script src="js/leaflet-geojson-vt.js"></script>

</head> 
<body>
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

    <div id="main"  class="container-fluid">
        <div class="row">
                   
        <div style="background-color: black;opacity: 0.7;" class="col-md-12">
            <div class=" col-md-3" style="width: 80px;">
                <label>Panel</label>
                <button class="openbtn" onclick="openNav()">☰</button>
            </div>

            <div id="filterPanel" style="display: none; padding: 10px 5px;">
                <form>
                    <div class="row">
                        <div class=" col-md-1 form-group" style="width: 120px;">
                            <label for="Tipo" id="Tipo_label">Tipo</label>
                            <select name="Tipo" class="form-control" id="Tipo_select">
                                <option value=""></option>
                            </select>        

                            <label for="Provincia" id="Provincia_label">Provincia</label>
                            <select name="Provincia" class="form-control" id="Provincia_select">
                                <option>--Provincia--</option>
                            </select>          
                        </div>
                        
                        <div class=" col-md-1 form-group" style="width: 160px;">
                            <label for="District" id="District">Distrito</label>
                            <select name="District" class="form-control" id="District_select">
                                <option value=""></option>  
                            </select>

                            <label for="Corregimiento" id="Corregimiento">Corregimiento</label>
                            <select name="Correg" class="form-control" id="Crg_select">
                                <option value=""></option>  
                            </select>
                        </div>
                        
                        <div class=" col-md-2 form-group" style="width: 160px;">
                            <label >Fecha de siembra</label>
                            <input name="Plant_date_from" type="date" class="form-control" id="Plant_date_from" placeholder="">
                            <label>To</label>
                            <input name="Plant_date_to" type="date" class="form-control" id="Plant_date_to" placeholder="">
                        </div>
                        
                        <div class=" col-md-2 form-group" style="width: 160px;">
                            <label >Fecha de cosecha</label>
                            <input name="Harvest_date_from" type="date" class="form-control" id="Harvest_date_from">
                            <label>To</label>
                            <input name="Harvest_date_to" type="date" class="form-control" id="Harvest_date_to">
                        </div>

                        <div class=" col-md-2 form-group" style="width: 190px;">
                            <label >Fecha de actualización</label>
                            <input name="Update_date_from" type="date" class="form-control" id="Update_date_from">
                            <label>To</label>
                            <input name="Update_date_to" type="date" class="form-control" id="Update_date_to">
                        </div>

                        <div class=" col-md-1 form-group" style="width: 140px;">
                            <label>Área sembrada</label>
                            <input name="Plant_area_from" type="number" class="form-control"  min="0" placeholder="min" id="Plant_area_from">
                            <label>To</label>
                            <input name="Plant_area_to" type="number" class="form-control"  min="0" placeholder="max" id="Plant_area_to">
                        </div>

                        <div class=" col-md-1 form-group" style="width: 140px;">
                            <label>Área cosechada</label>
                            <input name="Harvest_area_from" type="number" class="form-control"  min="0" placeholder="min" id="Harvest_area_from">
                            <label>To</label>
                            <input name="Harvest_area_to" type="number" class="form-control"  min="0" placeholder="max" id="Harvest_area_to">
                        </div>

                        <div class=" col-md-1 form-group" style="width: 120px;">
                            <label>Responsable</label>
                            <select name="Responsabl" class="form-control" id="Responsible_select">
                            </select>

                            <label>Variedad</label>
                            <select name="Variedad" class="form-control" id="Variety_select">
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class=" col-md-4 form-group" style="float: right; right: 3.5%">
                            <input name="submit" type="submit"  style="float: right; border-radius: 10px; margin: 10px" class="btn btn-primary" value="Aplicar">
                            <input name="clear" id="clearFilter" type="submit" style="float: right; border-radius: 10px; margin: 10px" class="btn btn-primary" value="Limpiar">
                        </div>
                    </div>

                </form>
            </div>
        </div> 
        </div>

        <div class="row">
            <div id="map" style="width: 100%; height: 120vh; padding: 0 0 0 0 ;margin: 0 0 0 0;" class="col-md-8" ></div>
        
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
        
        <div id="resultsTable" style="display: none; max-width: 95vw;">
        </div>
    </div>
        
</body>
</html>       