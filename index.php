<!--  TheArtOfData
   Copyright (C) 2018  by Anceschi Giovanni, Belmonte Luca, Boschini Matteo, Mechetti Luca, Monari Pietro, Scarfone Salvatore, Tardini Giovanni

   Mail : theartofdat@gmail.com

   This program is free software: you can redistribute it and/or modify
   it under the terms of the GNU Affero General Public License as published
   by the Free Software Foundation, either version 3 of the License, or
   (at your option) any later version.

   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU Affero General Public License for more details.

   You should have received a copy of the GNU Affero General Public License
   along with this program.  If not, see <http://www.gnu.org/licenses/>. -->
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Scopri la piattaforma Open Source di analisi e visualizzazione dati. Carica dati di ogni genere e visualizzali su grafici interattivi. Condividi i tuoi progetti in modo facile e veloce. Entra a far parte della nostra community!" >
    <meta name="author" content="">

    <link rel="shortcut icon" href="/img/favicon.ico">

    <title>TheArtOfData - Scopri la potenza dei dati</title>

    <?php require("template/import.html"); ?>

    <style>
    #chartdiv {
      width: 100%;
      height: 450px;
    }
    </style>
  </head>

  <body id="page-top">

    <?php require("template/nav-bar.html"); ?>


    <header class="masthead text-center text-light d-flex" data-parallax="scroll" data-image-src="/img/grafo4k-min.jpg" data-speed="0.2"><!--  data-parallax="scroll" data-image-src="/img/bg-04.png" data-speed="0.2" -->
      <div class="bg-opc" id="particles-js"></div>

      <div class="container my-auto" >
        <div class="row">
          <div class="col-lg-11 mx-auto" >
            <h1 class="" id="messenger">

            </h1>
            <hr>

          </div>

          <div class="col-lg-8 mx-auto">
            <a class="btn btn-dark btn-xl sr-button" href="/signup">

              <span class="header_button"></span>

            </a>
          </div>
        </div>

      </div>


    </header>

     <section class="py-5">
      <div class="container ">
        <div class="row d-flex align-items-center">
          <div class="col-lg-5 section-start">
            <h5 class="font-weight-light text-uppercase">

              <span class="section_1_sup"></span>

            </h5>
            <h1 class="mb-4">

              <span class="section_1_title"></span>

            </h1>
            <hr>
            <p>

              <span class="section_1_text"></span>

            </p>
          </div>
          <div class="col-lg-7">
            <img class="img-fluid sr-img" src="img/homepage/img-01.jpg" alt="">
          </div>
        </div>
      </div>
    </section>

    <section class="py-5">
     <div class="container ">
       <div class="row d-flex align-items-center">
         <div class="col-lg-5 order-lg-2 section-start ">
           <h5 class="font-weight-light text-uppercase">

             <span class="section_2_sup"></span>

           </h5>
           <h1 class="mb-4">

             <span class="section_2_title"></span>

           </h1>
           <hr>
          <p>

            <span class="section_2_text"></span>

          </p>
         </div>
         <div class="col-lg-7 order-lg-1">
           <!-- <img class="img-fluid sr-img" src="img/homepage/img-02.jpg" alt=""> -->
           <div id="chartdiv" class="sr-img"></div>
         </div>
       </div>
     </div>
   </section>

   <section class="py-5">
    <div class="container ">
      <div class="row d-flex align-items-center">
        <div class="col-lg-5 section-start">
          <h5 class="font-weight-light text-uppercase">

            <span class="section_3_sup"></span>

          </h5>
          <h1 class="mb-4">

            <span class="section_3_title"></span>

          </h1>
          <hr>
          <p>

            <span class="section_3_text"></span>

          </p>
        </div>
        <div class="col-lg-7 ">
          <img class="img-fluid sr-img" src="img/homepage/gif-01.gif" alt="">
        </div>
      </div>
    </div>
  </section>


    <section class="">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-6 mt-2 text-center">
            <div class="service-box mx-auto">
              <i class="fa fa-4x fa-folder-o text-primary mb-3 sr-icons"></i>
              <h3 class="mb-3">

                <span class="section_4_title"></span>

              </h3>
              <hr>
              <p class=" mb-0 ">

                <span class="section_4_text"></span>

              </p>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 mt-2 text-center">
            <div class="service-box mx-auto">
              <i class="fa fa-4x fa-github text-primary mb-3 sr-icons"></i>
              <h3 class="mb-3">

                <span class="section_5_title"></span>

              </h3>
              <hr>
              <p class=" mb-0 ">

                <span class="section_5_text"></span>

              </p>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 mt-2 text-center">

            <div class="service-box mx-auto">
              <i class="fa fa-4x fa-share-alt text-primary  mb-3 sr-icons"></i>
              <h3 class="mb-3">

                <span class="section_6_title"></span>

              </h3>
              <hr>
              <p class=" mb-0 ">

                <span class="section_6_text"></span>

              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- "landing-page": {
      "header-title": "Scopri la potenza dei dati",
      "header-button": "Inizia subito",

      "section-1-sup": "ESTRAI LE INFORMAZIONI",
      "section-1-title": "Carica i tuoi dati",
      "section-1-text": "Carica qualsiasi dato con semplicità, in automatico con Raspberry e Arduino o manualmente",

      "section-2-sup": "SFRUTTA LO STRUMENTO",
      "section-2-title": "Visualizza i tuoi grafici",
      "section-2-text": "Accedi ai tuoi canali e visualizza con un click i dati su grafici interattivi",

      "section-3-sup": "LANCIA IN RETE",
      "section-3-title": "Condividi i tuoi canali",
      "section-3-text": "Condividi i tuoi canali, grafici e progetti sui social network e dovunque desideri"
    } -->


    <?php require("template/footer.html"); ?>
    <!-- Custom scripts for this template -->
    <script src="js/homepage.js"></script>

    <!-- AMCHARTS -->
    <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="https://www.amcharts.com/lib/3/serial.js"></script>
    <script src="https://www.amcharts.com/lib/3/amstock.js"></script>
    <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>

    <!-- Chart code -->
    <script>
    var chartData = generateChartData();

    var chart = AmCharts.makeChart("chartdiv", {
        "type": "serial",
        "theme": "light",
        "legend": {
            "useGraphSettings": true
        },
        "dataProvider": chartData,
        "synchronizeGrid": true,
        "valueAxes": [{
            "id":"v1",
            "axisColor": "#FF6600",
            "axisThickness": 2,
            "axisAlpha": 1,
            "position": "left"
        }, {
            "id":"v2",
            "axisColor": "#FCD202",
            "axisThickness": 2,
            "axisAlpha": 1,
            "position": "right"
        }, {
            "id":"v3",
            "axisColor": "#B0DE09",
            "axisThickness": 2,
            "gridAlpha": 0,
            "offset": 50,
            "axisAlpha": 1,
            "position": "left"
        }],
        "graphs": [{
            "valueAxis": "v1",
            "lineColor": "#FF6600",
            "bullet": "round",
            "bulletBorderThickness": 1,
            "hideBulletsCount": 30,
            "title": "Utenti attivi",
            "valueField": "visits",
    		"fillAlphas": 0
        }, {
            "valueAxis": "v2",
            "lineColor": "#FCD202",
            "bullet": "square",
            "bulletBorderThickness": 1,
            "hideBulletsCount": 30,
            "title": "Visualizzazioni",
            "valueField": "hits",
    		"fillAlphas": 0
        }],
        "chartScrollbar": {},
        "chartCursor": {
            "cursorPosition": "mouse"
        },
        "categoryField": "date",
        "categoryAxis": {
            "parseDates": true,
            "axisColor": "#DADADA",
            "minorGridEnabled": true
        },
        "export": {
        	"enabled": false
         }
    });

    chart.addListener("dataUpdated", zoomChart);
    zoomChart();


    // generate some random data, quite different range
    function generateChartData() {
        var chartData = [];
        var firstDate = new Date();
        firstDate.setDate(firstDate.getDate() - 100);

            var visits = 1600;
            var hits = 2900;
            var views = 8700;


        for (var i = 0; i < 100; i++) {
            // we create date objects here. In your data, you can have date strings
            // and then set format of your dates using chart.dataDateFormat property,
            // however when possible, use date objects, as this will speed up chart rendering.
            var newDate = new Date(firstDate);
            newDate.setDate(newDate.getDate() + i);

            visits += Math.round((Math.random()<0.5?1:-1)*Math.random()*10);
            hits += Math.round((Math.random()<0.5?1:-1)*Math.random()*10);
            views += Math.round((Math.random()<0.5?1:-1)*Math.random()*10);

            chartData.push({
                date: newDate,
                visits: visits,
                hits: hits,
                views: views
            });
        }
        return chartData;
    }

    function zoomChart(){
        chart.zoomToIndexes(chart.dataProvider.length - 20, chart.dataProvider.length - 1);
    }

    </script>

    <script type="text/javascript">
      particlesJS('particles-js',

      {
        "particles": {
          "number": {
            "value": 100,
            "density": {
              "enable": true,
              "value_area": 1000
            }
          },
          "color": {
            "value": "#000000"
          },
          "shape": {
            "type": "circle",
            "stroke": {
              "width": 0,
              "color": "#000000"
            },
            "polygon": {
              "nb_sides": 5
            },
            "image": {
              "src": "img/github.svg",
              "width": 100,
              "height": 100
            }
          },
          "opacity": {
            "value": 0.5,
            "random": false,
            "anim": {
              "enable": false,
              "speed": 1,
              "opacity_min": 0.1,
              "sync": false
            }
          },
          "size": {
            "value": 3,
            "random": true,
            "anim": {
              "enable": false,
              "speed": 40,
              "size_min": 0.1,
              "sync": false
            }
          },
          "line_linked": {
            "enable": true,
            "distance": 150,
            "color": "#000000",
            "opacity": 0.4,
            "width": 1
          },
          "move": {
            "enable": true,
            "speed": 2,
            "direction": "none",
            "random": false,
            "straight": false,
            "out_mode": "out",
            "attract": {
              "enable": false,
              "rotateX": 600,
              "rotateY": 1200
            }
          }
        },
        "interactivity": {
          "detect_on": "canvas",
          "events": {
            "onhover": {
              "enable": true,
              "mode": "grab"
            },
            "onclick": {
              "enable": false,
              "mode": "grab"
            },
            "resize": true
          },
          "modes": {
            "grab": {
              "distance": 150,
              "line_linked": {
                "opacity": 1
              }
            },
            "bubble": {
              "distance": 400,
              "size": 40,
              "duration": 2,
              "opacity": 8,
              "speed": 3
            },
            "repulse": {
              "distance": 200
            },
            "push": {
              "particles_nb": 4
            },
            "remove": {
              "particles_nb": 2
            }
          }
        },
        "retina_detect": true,
        "config_demo": {
          "hide_card": false,
          "background_color": "#b61924",
          "background_image": "",
          "background_position": "50% 50%",
          "background_repeat": "no-repeat",
          "background_size": "cover"
        }
      }

    );
    </script>

  </body>

</html>
