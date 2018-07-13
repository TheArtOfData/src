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
    <meta name="description" content="Scopri la piattaforma Open Source di analisi e visualizzazione dati">
    <meta name="author" content="">
    <meta property="fb:app_id" content="1861801120790645" />
    <meta property="og:url" content="https://theartofdata.tech/" >
    <meta property="og:type" content="article" >
    <meta property="og:image" content="https://theartofdata.tech/img/grafo4k-min.png" >

    <link rel="shortcut icon" href="/img/favicon.ico">

    <title>TheArtOfData - Scopri la potenza dei dati</title>

    <?php require("../template/import.html"); ?>
    <?php require("template/import.html"); ?>

    <?php
    echo '<script type="text/javascript">',
         'var URL = "' . @$_GET['url'] . '";',
         '</script>';
    ?>

  </head>

  <body id="page-top">

    <?php require("../template/nav-bar.html"); ?>


    <section id="project-front-img" class="project-view-header d-flex">

        <div class="" id="particles-js-project">

        </div>
        <div class="container my-auto" style="padding: 60px 0">
          <div class="row">
            <div class="col-10 mx-auto">
              <h1 id="project-title"></h1>
              <h5 class="" id="project-sub-title">Creato da Luca Belmonte</h5>
            </div>
          </div>
        </div>


    </section>


    <section class="project-content">
      <div class="container " id="project-container">


      </div>
    </section>


    <?php require("../template/footer.html"); ?>
    <!-- Custom scripts for this template -->
    <script src="../js/homepage.js"></script>
    <script src="../js/projects/view.js"></script>



    <!--
      particle.js
    -->
    <script type="text/javascript">
      particlesJS('particles-js-project',

      {
        "particles": {
          "number": {
            "value": 100,
            "density": {
              "enable": true,
              "value_area": 1500
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
