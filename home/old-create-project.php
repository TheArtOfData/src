<!-- TheArtOfData
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
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <base href="/home/create-project.php">

        <title>Create project</title>

        <?php require('template/import.html'); ?>

        <link rel="stylesheet" href="../css/dashboard-style.css">
        <link rel="stylesheet" href="../css/master.css">

        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.9/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
        <style>
          .affix {
            top: 15px !important;
          }
        </style>
    </head>
    <body>

      <div id="preload">
        <img src="../img/energy-way.png" alt="">
      </div>



      <div class="wrapper" style="display: none">


          <?php require('template/side-bar.html'); ?>


          <div id="content">
              <?php require('template/nav-bar.html'); ?>

              <div class="" id="main-content">

              <div class="row">
                <div class="col-sm-9">
                  <div class="form-group newproj">
                    <h2>Titolo del progetto</h2>
                    <input class="form-control" onClick="this.select()" id="projtitle" name="projtitle" type="text">
                  </div>
                </div>
                <div class="col-sm-3">
                  <div id="buttonsdiv">
                    <button type="submit" form="form-create-project" class="btn btn-dafult" id="publish_button" value="publish">Publish</button>
                    <button type="submit" form="form-create-project" class="btn btn-success" id="save_button" value="save">Save</button>
                  </div>
                  <div class="form-group" style="margin-top:26px;">
                    <h3>Categorie</h3>
                    <input class="form-control" form="form-create-project" onClick="this.select()" id="categories" name="categories" type="text">
                  </div>
                </div>
              </div>
              <h3>Immagine di copertina</h3>
              <div class="file-loading">
                <input id="frontimg" name="frontimg" type="file" accept='image/*' class="file">
              </div>

              <hr>
                    <form method="POST" id="form-create-project" action="/api/projects/projects_in.php" enctype="multipart/form-data">
                      <div id="steps">
                        <div id="step1">
                          <!--<a id="removestep1" <i class="glyphicon glyphicon-remove" style="float:right; font-size:20px;"></i></a>-->
                          <h2>Step 1</h2>
                            <div class="form-group newproj">
                              <h4>Titolo</h4>
                              <input class="form-control" onClick="this.select()" id="titlestep1" name="step1" type="text">
                            </div>
                            <h3>Immagini step 1</h3>
                            <div class="file-loading">
                              <input id="imgstep1" name="imgstep1[]" type="file" accept='image/*' class="file" multiple>
                            </div>
                          <textarea id="editor1" style="height:80vh"></textarea>
                        </div>
                      </div>
                      <button type="button" id="addStep" class="btn btn-primary btn-lg">Aggiungi step</button>
                    </form>
              </div>

              <a href="https://goo.gl/forms/ejIJlac2LbHmAFsH3" target="_blank" class="btn btn-warning btn-circle btn-feedback"><span class="glyphicon glyphicon-alert"></span></a>
          </div>
      </div>


      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.9/js/plugins/sortable.min.js" type="text/javascript"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
      <!-- the main fileinput plugin file -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.9/js/fileinput.min.js"></script>
      <!--theme font awesome theme you can include it as mentioned below -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.9/themes/fa/theme.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.4/js/standalone/selectize.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.4/css/selectize.bootstrap3.css" />
      <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=0ztlv25sppaw8kkypesjbm6y6v7vhcdlvagkmly77c1mheum"></script>

        <script type="text/javascript" src="../js/home/create-project.js"></script>

    </body>
</html>
