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
  <title>TheArtOfData | Crea canale</title>


  <?php require("template/import.html"); ?>


</head>

<body class="fixed-nav sticky-footer bg-light" id="page-top">
  <!-- Navigation-->

  <?php require("template/nav-bar.html"); ?>


  <div class="content-wrapper">
    <div class="container-fluid">


      <div class="row">
        <div class="col-lg-6">
          <!-- Example Bar Chart Card-->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-plus"></i>

              <span class="parse_nav_new_channel"></span>
            </div>
            <div class="card-body">

              <form id="form-create-channel">
                <div class="form-group">
                  <label for="text">

                    <span class="parse_channel_name"></span>

                  </label>
                  <input type="text" class="form-control" id="form-name">
                </div>


                <div class="form-group">
                  <label for="text">

                    <span class="parse_place"></span>

                  </label>
                  <input type="text" class="form-control" id="form-location">
                </div>

                <div class="form-group">
                  <label for="comment">

                    <span class="parse_description"></span>

                  </label>
                  <textarea class="form-control" rows="5" id="form-description"></textarea>
                </div>

                <div class="form-group">
                  <label for="text">

                    <span class="parse_visibility"></span>:

                  </label><br>
                  <label class="radio-inline"><input type="radio" name="visibility" value="0" checked> <i class="fa fa-globe-americas"></i> <span class="parse_public"></span></label><br>
                  <label class="radio-inline"><input id="form-private" type="radio" name="visibility" value="1"> <i class="fa fa-lock"></i> <span class="parse_private"></span></label>
                </div>

                <label for="form-create-channel-data">
                  <span class="parse_data"></span>
                </label>


                <div id="form-create-channel-data">

                </div>

                <br>

                <button type="button" class="btn btn-primary btn-sm" id="add-data">
                  <i class="fa fa-plus"></i>
                </button>

                <br><br>
                <button type="submit" class="btn btn-primary"><span class="parse_create_channel"></span>!</button><br>
              </form>
              <p class="" id="form-create-channel-p-error"></p>
              <div id="form-alert-danger" class="alert alert-danger" style="display: none">
                <strong>Errore: </strong>
                <span></span>
              </div>
            </div>

          </div>
          <!-- Card Columns Example Social Feed-->

          <hr class="mt-2">

          <!-- /Card Columns-->
        </div>
        <div class="col-lg-6">
          <!-- Example Pie Chart Card-->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-info"></i> Info</div>
            <div class="card-body">
              <p>I canali del portale #alloraspengo sono gli spazi in cui gli utenti possono caricare i propri dati e visualizzarli al meglio tramite diversi tipi di grafici.</p>
              <h4 class="light">Ogni canale è identificato da:</h4>
              <ul>
                <li><p>Un nome</p></li>
                <li><p>Un luogo di corrispondenza</p></li>
                <li><p>Una descrizione</p></li>
                <li><p>Un numero variabile di dati collegati al canale</p></li>
              </ul>
              <h3 class="light">Come fare:</h3>
              <p>Su ciascun canale l'utente può caricare i suoi dati da diversi dispositivi (PC, Arduino, Raspberry, ecc). I caricamento viene effetuato tramite un programma che viene generato su misura per ogni canale di ogni utente.  </p>

            </div>

          </div>
        </div>
      </div>

    </div>
    <?php require("template/footer.html"); ?>
  </div>
  <script src="/js/dashboard/main.js" charset="utf-8"></script>

  <script src="/js/dashboard/create-channel.js" charset="utf-8"></script>
</body>

</html>
