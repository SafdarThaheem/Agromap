var map;

$( document ).ready(function() {
    var pointsLyr;
    map = L.map("map", {
        zoom: 6,

      //center: [31.615965, 72.38554],
      center:  [9.154, -78.047],
      zoomControl: true,
      attributionControl: false,
      condensedAttributionControl: false
  });

// First basemap
var satellite =L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
    maxZoom: 20,
    subdomains:['mt0','mt1','mt2','mt3']
}).addTo(map);

// Second basemap
var hybrid = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
      maxZoom: 20,
      subdomains:['mt0','mt1','mt2','mt3']
  });

// Third basemap
var streets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
      maxZoom: 20,
      subdomains:['mt0','mt1','mt2','mt3']
  });
// Add basemaps
var baseMaps = {
    "Satellite": satellite,
    "Hybrid": hybrid,
    "Street": streets
};

var layerControl = L.control.layers(baseMaps, null).addTo(map);

//Get polygons on load
$.ajax("php/getPolygons.php", {
  success: function (response){
    lyr = JSON.parse(response);
    var polygonLyr = L.geoJSON(lyr, {
      onEachFeature: function (feature, layer) {
        layer.bindPopup('<h5><b>Nombre:</b> ' + feature.properties.nombre + '</h5>' +
                        '<h5><b>Comentario:</b> ' + feature.properties.comentario + '</h5>');
        }
      }).addTo(map);
    layerControl.addOverlay(polygonLyr, 'Polygon');
  }
})

//Get points on load
var mydata = $.ajax("php/getPoints.php", {
    async: false,
    success: function (response){
      return response;
    }
})    

// Plot the points on the map
lyr = JSON.parse(mydata.responseText)
pointsLyr = L.geoJSON(lyr , {
          onEachFeature: function(feature, layer){
             layer.bindPopup('<h5><b>Tipo:</b> '+feature.properties.tpo+'</h5>' + 
                    '<h5><b>Empresa:</b> '+feature.properties.empresa+'</h5>' + 
                    '<h5><b>Productor`:</b> '+feature.properties.productor+'</h5>' +
                    '<h5><b>Área sem.:</b> '+feature.properties.area_sem+'</h5>' +
                    '<h5><b>Área cosechada:</b> '+feature.properties.area_cos+'</h5>' +
                    '<h5><b>Fecha siembra:</b> '+feature.properties.fe_siem+'</h5>' +
                    '<h5><b>Fecha cosecha:</b> '+feature.properties.fe_cos+'</h5>' +
                    '<h5><b>Actualizada:</b> '+feature.properties.fe_ac+'</h5>' +
                    '<h5><b>Responsable:</b> '+feature.properties.responsabl+'</h5>' +
                    '<h5><b>Variedad:</b> '+feature.properties.variedad+'</h5>');
          },

          pointToLayer: function(feature, latlng){
            return L.marker(latlng);
          }
        }).addTo(map);
layerControl.addOverlay(pointsLyr, 'Point');


// Add data to charts
if (pointsLyr){
    var chartData = $.ajax('php/fillChart.php', {
      async: false,
      type: 'POST',
      success: function(response){
        return response;
      }
    });
    
    //Plot charts using the data
    barChart(JSON.parse(chartData.responseText), 'chart1');
    barChart(JSON.parse(chartData.responseText), 'chart2');
    donutChart(JSON.parse(chartData.responseText), 'chart3');
  }

loadFormData();
loadFormData('variety');
loadFormData('responsible');
loadFormData('type');


// Change form options based on the input selected by user
$('#Provincia_select').change(function(){
    
  var province = $(this).val();
  
  if (province == "--Provincia--"){
    $('#District_select').html('<option value=""></option>');
    $('#Crg_select').html('<option value=""></option>');
  }
  else{
    loadFormData('distData', province);
  }
})

$('#District_select').change(function(){
    
  var district = $(this).val();

  loadFormData('crgData', district);  
})


// Call filter functions when the filters are applied
$('form').on('submit', function(e){
  e.preventDefault();

  if(pointsLyr){
    map.removeLayer(pointsLyr);
    layerControl.removeLayer(pointsLyr);
  }
      
  var data = $.ajax('php/getFilteredData.php', {
    async: false,
    type: 'POST',
    data: $('form').serialize(),
    success: function(response){
      return response;
    }
  })

  console.log(data.responseText);
  lyr = JSON.parse(data.responseText).featureCollection;
  pointsLyr = L.geoJSON(lyr, {
      onEachFeature: function (feature, layer) {
        layer.bindPopup('<h5><b>Tipo:</b> '+feature.properties.tpo+'</h5>' +
                        '<h5><b>Empresa:</b> '+feature.properties.empresa+'</h5>' + 
                        '<h5><b>Productor`:</b> '+feature.properties.productor+'</h5>' +
                        '<h5><b>Área sem.</b> '+feature.properties.area_sem+'</h5>' +
                        '<h5><b>Área cosechada:</b> '+feature.properties.area_cos+'</h5>' +
                        '<h5><b>Fecha siembra:</b> '+feature.properties.fe_siem+'</h5>' +
                        '<h5><b>Fecha cosecha:</b> '+feature.properties.fe_cos+'</h5>' +
                        '<h5><b>Actualizada:</b> '+feature.properties.fe_ac+'</h5>' +
                        '<h5><b>Responsable:</b> '+feature.properties.responsabl+'</h5>' +
                        '<h5><b>Variedad:</b> '+feature.properties.variedad+'</h5>');
        }
    }).addTo(map);
      
  layerControl.addOverlay(pointsLyr, 'Point');
  createTable(JSON.parse(data.responseText));

  $.ajax('php/getChartData.php', {
      type: 'POST',
      data: $('form').serialize(),
      success: function(response){
        if (response){
          chartData = JSON.parse(response)
              
          barChart(chartData, 'chart1');
          barChart(chartData, 'chart2');
          
          if (chartData.type == 'pNotNull'){
             donutChart(chartData, 'chart4');
          }else{
            // This means that there is no province selected
            donutChart(chartData, 'chart3');
          }

        }
        else{
          alert('No data matches the filter');
        }      
      }
  });
})

// Remove filter values when clicked on clear filters button
$('#clearFilter').click(function(e){
  e.preventDefault();

  //$('#Provincia_select option:selected').val($("#Provincia_select option:first").val());
  $('#Provincia_select option').removeAttr('selected')
    .find('[value = "--Provincia--"]')
        .attr('selected','selected');
  
  $('#District_select').html('<option value=""></option>');
  $('#Crg_select').html('<option value=""></option>');
  
  $('#Plant_date_from').val('');
  $('#Plant_date_to').val('');
  $('#Harvest_date_from').val('');
  $('#Harvest_date_to').val('');
  $('#Update_date_from').val('');
  $('#Update_date_to').val('');
  
  $('#Plant_area_from').val('');
  $('#Plant_area_to').val('');
  $('#Harvest_area_from').val('');
  $('#Harvest_area_to').val('');
  
  $("#Tipo_select option")
    .removeAttr('selected')
    .find(':first')
    .attr('selected','selected');

  $("#Responsible_select option")
    .removeAttr('selected')
    .find(':first')
    .attr('selected','selected');

  $("#Variety_select option")
    .removeAttr('selected')
    .find(':first')
    .attr('selected','selected');

})

// Login form details
$('#login-form-link').click(function(e) {
    $("#login-form").delay(100).fadeIn(100);
    $("#register-form").fadeOut(100);
    $('#register-form-link').removeClass('active');
    $(this).addClass('active');
    e.preventDefault();
});
$('#register-form-link').click(function(e) {
    $("#register-form").delay(100).fadeIn(100);
    $("#login-form").fadeOut(100);
    $('#login-form-link').removeClass('active');
    $(this).addClass('active');
    e.preventDefault();
});

// Four jquery calls below are used to limit to and from dates based on user selection
$('#Plant_date_from').change(function(){
  var start_date = $(this).val();
  $('#Plant_date_to').prop({
    min: start_date
  });
});

$('#Plant_date_to').change(function(){
  var start_date = $(this).val();
  $('#Plant_date_from').prop({
    max: start_date
  });
});

$('#Harvest_date_from').change(function(){
  var start_date = $(this).val();
  $('#Harvest_date_to').prop({
    min: start_date
  });
});

$('#Harvest_date_to').change(function(){
  var start_date = $(this).val();
  $('#Harvest_date_from').prop({
    max: start_date
  });
});

$('#Update_date_from').change(function(){
  var start_date = $(this).val();
  $('#Update_date_to').prop({
    min: start_date
  });
});

$('#Update_date_to').change(function(){
  var start_date = $(this).val();
  $('#Update_date_from').prop({
    max: start_date
  });
});


  openNav()
});

function loadFormData(type, name){
  $.ajax('php/getFormData.php', {
    type: 'POST',
    data: {type: type, name: name},
    success: function(data){
      if (type == "distData"){
        $("#District_select").html(data);
      }
      else if(type == "crgData"){
        $('#Crg_select').html(data);
      }
      else if(type == 'variety'){
        $('#Variety_select').html(data);
      }
      else if(type == 'responsible'){
        $('#Responsible_select').html(data);

      }else if(type == 'type'){
        $('#Tipo_select').html(data);
      
      }
      else{
        $("#Provincia_select").append(data);
      }
    }
  })
}

function createTable(data){


  var tableDiv = document.getElementById("resultsTable");
  if (tableDiv.innerHTML != ''){
    
      tableDiv.innerHTML = "";
  }

  var tableResult = document.createElement('table');
  tableResult.setAttribute("id", "results");
        
  tableDiv.appendChild(tableResult);
    

  if (data.displayTable == 'False'){
    return
  }

  t_head = '<th>Tipo</th><th>Provincia</th><th>Distrito</th><th>Correg.</th><th>Empresa</th><th>Productor</th><th>Área sem.</th>' + 
        '<th>Área cosechada</th><th>Fecha siembra</th><th>Fecha cosecha</th><th>Actualizada</th><th>Responsable</th><th>Variedad</th>';
  var table = document.getElementById('results');
  var header = table.createTHead();
  var row = header.insertRow(0);
  row.innerHTML = t_head

  var table_body = table.createTBody();

  for (let i=0; i<data.featureCollection.features.length; i++){
    cur_data = data.featureCollection.features[i].properties;

    t_body = '';

    t_body = t_body + '<td>' + cur_data['tpo'] + '</td>';
    t_body = t_body + '<td>' + cur_data['prov'] + '</td>';
    t_body = t_body + '<td>' + cur_data['dis'] + '</td>';
    t_body = t_body + '<td>' + cur_data['crg'] + '</td>';
    t_body = t_body + '<td>' + cur_data['empresa'] + '</td>';
    t_body = t_body + '<td>' + cur_data['productor'] + '</td>';
    t_body = t_body + '<td>' + cur_data['area_sem'] + '</td>';
    t_body = t_body + '<td>' + cur_data['area_cos'] + '</td>';
    t_body = t_body + '<td>' + cur_data['fe_siem'] + '</td>';
    t_body = t_body + '<td>' + cur_data['fe_cos'] + '</td>';
    t_body = t_body + '<td>' + cur_data['fe_ac'] + '</td>';
    t_body = t_body + '<td>' + cur_data['responsabl'] + '</td>'; 
    t_body = t_body + '<td>' + cur_data['variedad'] + '</td>';

    let ce = document.createElement('tr');
    ce.innerHTML = t_body;

    if (ce.innerText != ''){
      var row = table_body.insertRow(0);
      row.innerHTML = t_body;
    }
  }

  $('#results').DataTable({
    dom: 'Bfrtip',
    buttons: [
        'csv', 'excel'
      ],
    "language": {
        "search": "Buscar:"
      }
  });

}

function barChart(data, data_chart){
    data_points = [];

    if (data_chart == 'chart1'){
        for (let x in data.features){
          data_pt = data.features[x];
          data_points.push( {y: parseInt(data_pt['sem']), label: data_pt['prov']});
        }  

        title = 'Área sembrada por provincia';
        container = 'chartContainer1';
    }else if(data_chart == 'chart2'){
        for (let x in data.features){
          data_pt = data.features[x];
          data_points.push( {y: parseInt(data_pt['cos']), label: data_pt['prov']});
        }
        title = 'Área cosechada por provincia';
        container = 'chartContainer2';
    }
    
    CanvasJS.addColorSet("greenShades",
                [//colorSet Array

                "#818181",               
                ]);
  CanvasJS.addColorSet("Shades",
                  [//colorSet Array
                  "#818181",
                  "#2F4F4F",
                  "#008080",
                  "#2E8B57",
                  "#3CB371",
                  "#90EE90"                
                  ]);

  var chart = new CanvasJS.Chart(container, {
        animationEnabled: true,
        theme: "light2", // "light1", "light2", "dark1", "dark2"
        colorSet: "Shades",
        zoomEnabled: false,
        title:{
            text: title
        },
        axisY: {
            title: 'Área (Has)'
        },
        data: [{        
            type: "column",  
            showInLegend: true, 
            legendMarkerColor: "grey",
            legendText: "Province",
            dataPoints: data_points
                
        }]
    });
    chart.render();
}

function donutChart(data, data_chart){
    data_points = [];

    if (data_chart == 'chart3'){
      for (let x in data.features){
        data_pt = data.features[x];
        data_points.push( {y: parseInt(data_pt['var']), label: data_pt['prov']});
      }  

      title = 'Variedad de semilla por provincia'; 
    }else if(data_chart == 'chart4'){
      for (let x in data.features2){
        data_pt = data.features2[x];
        data_points.push( {y: parseInt(data_pt['count_var']), label: data_pt['var']});
      }  
      title = 'Variedad de semilla por provincia';
    }
     

    var chart = new CanvasJS.Chart("chartContainer3",
    {
      zoomEnabled: false,
      title:{
        text: title
      },
      data: [
      {
       type: "doughnut",
       dataPoints: data_points
     }
     ]
   });

    chart.render();
  
}

var tog=true;
function openNav() {
    if(tog==true){
        document.getElementById("mySidebar").style.width = "0";
        document.getElementById("main").style.marginLeft= "0";
        jQuery('body').removeClass("left-sidebar-exp");
        tog=false;
    }else{
        document.getElementById("mySidebar").style.width = "100px";
        document.getElementById("main").style.marginLeft = "100px";
        jQuery('body').addClass("left-sidebar-exp");
        tog=true;
    } 
  }
  
function closeNav() {
  document.getElementById("mySidebar").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
}

function openFilter(){
  filterBar = document.getElementById('filterPanel');

  if (filterBar.style.display == 'none'){
    filterBar.style.display = 'block';
  }
  else if(filterBar.style.display == 'block'){
    filterBar.style.display = 'none'; 
  }
}

function openTable(){
  var table = document.getElementById('resultsTable');

  if (table.style.display == 'none'){
    table.style.display = 'block';
  }
  else if(table.style.display == 'block'){
    table.style.display = 'none';
  }
}

function openCharts(){
  var charts = document.getElementById('chartsPanel');

  if (charts.style.display == 'none'){
    jQuery("body").addClass("right-sidebar-exp");
    document.getElementById("map").style.width = "70%";
    charts.style.width = '30%';
    charts.style.display = 'block';
    window.dispatchEvent(new Event('resize'));
  }
  else if(charts.style.display == 'block'){
    jQuery("body").removeClass("right-sidebar-exp");
    document.getElementById("map").style.width = "100%";
    charts.style.width = '0';
    charts.style.display = 'none';
    window.dispatchEvent(new Event('resize'));  
  }
}