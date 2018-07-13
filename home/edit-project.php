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
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>TheArtofData</title>

  <?php require("template/import.html"); ?>

  <?php
  echo '<script type="text/javascript">',
       'var URL = "' . @$_GET['url'] . '";',
       '</script>';
  ?>

</head>

<body class="fixed-nav sticky-footer bg-light" id="page-top">
  <!-- Navigation-->

  <?php require("template/nav-bar.html"); ?>

  <!-- preview modal-->
  <div class="modal fade" id="previewmodal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h3>Anteprima</h3>
        </div>

        <!-- Modal body -->
        <div class="modal-body">

        </div>

        <!-- Modal Header -->
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Chiudi</button>
        </div>

      </div>
    </div>
  </div>

  <div class="modal fade" id="delete-project-modal">
    <div class="modal-dialog modal-dialog-centered ">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h3>Sei sicuro di voler cancellare il progetto?</h3>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <p>Cliccando Cancella eliminerai definitivamente in tuo progetto</p>
        </div>

        <!-- Modal Header -->
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <button class="btn btn-danger" type="button" id="delete-project">Cancella</button>
        </div>

      </div>
    </div>
  </div>

  <div class="content-wrapper">
    <div class="container-fluid" style="padding:10px;">
      <div class="row">

      <div class="col-lg-9">
        <h2 class="mb-3">
          <!--
            Project name
          -->
          <span id="project-title"></span>
          <button id="change-project-title" type="button" class="btn btn-light"><i class="fas fa-cog"></i></button>

          <form id="change-project-title-form" style="display: none">
            <div class="input-group mb-3">
              <input type="text" class="form-control" placeholder="Nuovo titolo" id="new-project-title">
              <div class="input-group-append">
                <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Salva</button>
                <button class="btn btn-danger" type="button" id="change-project-title-close"><i class="fas fa-times"></i></button>
              </div>
            </div>
          </form>
        </h2>

        <div class="card mb-4">
          <div class="card-header">
            <i class="fas fa-image"></i> Front image
          </div>
          <div class="card-body">
            <input type="file" name="pj-front-img" id="pj-front-img" class="">

            <div class="alert alert-danger mt-4" id="errorFrontImg" style="display: none">

            </div>
          </div>

        </div>

        <div class="card mb-4" id="pj-manager">

          <div class="card-header">
            <i class="fas fa-clipboard-list"></i>
            Step
          </div>

          <div class="card-body">
            <div class="row">
              <div class="col-lg-2 text-center">
                <button type="button" class="btn btn-outline-dark text-center" id="add-step">
                  <i class="fa fa-plus"></i>
                </button>
              </div>
              <div class="col-lg-10">
                <div id="steplist">
                  <!--
                    CONTENT HERE
                  -->
                </div>
              </div>
            </div>
          </div>
        </div>

        <div id="stepcontainer">
          <!--
            CONTENT HERE
          -->
        </div>

      </div>


      <div class="col-lg-3" id="pjactions">
        <div class="card mb-3">

          <div class="card-header">
            <i class="fa fa-cog"></i> <span class="parse_action"></span>
          </div>

          <div class="card-body mb-3">
            <div class="btn-group-vertical buttons w-100 pb-4" role="group" aria-label="Basic example">
              <!-- <button type="button" class="btn btn-outline-secondary" id="previewbtn" data-toggle="modal" data-target="#previewmodal">Anteprima</button> -->
              <button type="button" class="btn btn-light" id="save-all"><i class="fa fa-save"></i> Salva</button>
              <a class="btn btn-light" href="" id="project-link" target="_blank"><i class="fas fa-link"></i> Visualizza</a>
            </div>



            <div class="alert alert-success" id="pjstatealert" role="alert" style="display: none">
              Modifiche salvate correttamente.
            </div>
            <div class="form-group">
              <h5>Categorie</h5>
              <input type="text" class="form-control" name="categories" id="categories">
            </div>

          </div>
        </div>

        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-info"></i> Info
          </div>
          <div class="card-body">
            <button type="button" name="button" class="btn btn-primary w-100 mb-3" id="project-publish"><i class="fas fa-globe-americas"></i> Pubblica</button>
            <button type="button" name="button" class="btn btn-primary w-100 mb-3" id="project-unpublish"><i class="fas fa-lock"></i> Nascondi</button>

            <p><strong>Stato</strong>: <span id="project-visibility"></span></p>
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <button data-toggle="modal" data-target="#delete-project-modal" class="btn btn-link text-danger" name="button"><i class="fa fa-trash"></i> Elimina il progetto</button>
          </div>
        </div>

      </div>
    </div>
  </div>
    <?php require("template/footer.html"); ?>
</div>
  <script src="/js/dashboard/main.js" charset="utf-8"></script>
  <script src="/js/dashboard/edit-project.js"></script>

</body>

</html>
