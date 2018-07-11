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
  <meta property="fb:app_id" content="1861801120790645" />
  <meta property="og:url" content="https://theartofdata.tech/" >
  <meta property="og:type" content="article" >
  <meta property="og:image" content="https://theartofdata.tech/img/grafo4k-min.png" >

  <title>TheArtOfData</title>

  <base href="/home/channel.php">

  <?php require("template/import.html"); ?>

  <?php
  echo '<script type="text/javascript">',
       'var USERNAME = "' . @$_GET['username'] . '";',
       'var CHANNEL_NAME = "' . @$_GET['channel_name'] . '";',
       '</script>';
  ?>

  <style type="text/css">
  .affix {
      top: 20px;
      z-index: 9999 !important;
  }
    #chart-container {
      width: 640px;
      height: auto;
    }

    .setting-button button {
      margin: 5px 0;
    }

    .loader {
      margin: 0 auto;
      margin-top: 100px;
      border: 4px solid #f3f3f3; /* Light grey */
      border-top: 4px solid #888; /* Blue */
      border-radius: 50%;
      width: 30px;
      height: 30px;
      animation: spin 2s linear infinite;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

  </style>




</head>

<body class="fixed-nav sticky-footer bg-light" id="page-top">
  <!-- Navigation-->

  <?php require("template/nav-bar.html"); ?>

  <!-- MODAL -->

  <div id="modal-token" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" id="download-script">Scarica Script</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
        </div>
      </div>

    </div>
  </div>

  <div id="modal-delete-channel" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Sei sicuro di cancellare il canale?</h4>

          <button type="button" class="close" data-dismiss="modal">&times;</button>

        </div>
        <div class="modal-body">
          <p>Tutti i dati del canale verranno <span class="text-danger">cancellati</span>. Continuare?</p>
        </div>
        <div class="modal-footer">
          <button id="delete-channel" type="button" class="btn btn-danger ">Si, continua!</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
        </div>
      </div>

    </div>
  </div>

  <div id="modal-add-graph" class="modal  fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Aggiunta grafico</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>

        </div>
        <div class="modal-body">
          <form id="form-graph" >
            <div class="form-group">
              <label for="text">Nome grafico:</label>
              <input type="text" class="form-control" id="form-graph-name">
            </div>
            <div class="form-group">
              <label for="text">Dato da visualizzare:</label>
              <div id="form-graph-type-data"></div>
            </div>

            <p id="form-graph-error"></p>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success" name="button"><i class="fas fa-plus"></i> Crea grafico</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
            </div>
          </form>
        </div>

      </div>

    </div>
  </div>

  <div id="modal-add-form-data" class="modal fade" role="dialog" >
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Caricamento manuale dati</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form id="form-add-data">
            <div class="form-group">
              <label for="text">Valore</label>
              <input type="text" onClick="this.select()" class="form-control" id="form-value">
            </div>

              <!-- <input type='text' onClick="this.select()" class="form-control" placeholder="Tempo -- Facoltativo"/>
              <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
              </span> -->
            <div class="input-group date" id="datetimepicker" data-target-input="nearest">
                <input type="text" onClick="this.select()" class="form-control datetimepicker-input" data-target="#datetimepicker"/>
                <div class="input-group-append" data-target="#datetimepicker" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>

            <br>
            <div class="form-group">
              <label for="text">Tipo dato</label>
              <div id="form-add-type-data"></div>
            </div>


            <p id="form-data-add-error"></p>
            <div class="modal-footer">
              <input type="submit" class="btn btn-success" value="Aggiungi valore">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
            </div>
          </form>
        </div>

      </div>

    </div>
  </div>

<!-- ./MODAL -->
  <div class="content-wrapper">
    <div class="container-fluid">



      <div class="row">
        <div class="col-lg-9">
          <!-- Example Bar Chart Card-->
          <h2 id="channel-name">nome</h2>
          <h4  style="padding-left: 20px" ><span class="parse_place"></span>: <span id="channel-location" class="light"></span></h4>
          <p id="channel-description"></p>

          <hr class="mt-2">
          <!-- Card Columns Example Social Feed-->

          <div class="" id="channel-no-graph" style="display: none">
            <div class="alert alert-info">
              <strong><i class="fa fa-exclamation-circle"></i></strong> <span class="parse_no_graph"></span>
            </div>
          </div>

          <div id="graphs-container">


          </div>





          <!-- /Card Columns-->
        </div>
        <div class="col-lg-3">
          <!-- Example Pie Chart Card-->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-wrench"></i> <span class="parse_action"></span></div>
            <div class="card-body setting-button">
              <span data-toggle="tooltip" title="Salva il canale!" id="follow-channel"><button  type="button" class="btn btn-light ">Segui <i class="far fa-star"></i></button></span>
              <span data-toggle="tooltip" title="Aggiungi un grafico!" class="mod"><button  type="button" class="btn btn-light " data-toggle="modal" data-target="#modal-add-graph"><i class="fa fa-plus"></i></button></span>
              <span data-toggle="tooltip" title="Caricamento manuale dati" class="mod"><button  type="button" class="btn btn-light " data-toggle="modal" data-target="#modal-add-form-data" id="manualDataAdd"><span class="fas fa-hand-paper"></span></button></span>
              <span data-toggle="tooltip" title="Visualizza il token!" class="mod"><button  type="button" class="btn btn-light " data-toggle="modal" data-target="#modal-token"><i class="fas fa-upload"></i></button></span>
              <span style="display: none"><button type="button" class="btn btn-default " data-toggle="modal" data-target="#"><i class="fa fa-cog"></i></button></span>
              <span data-toggle="tooltip" title="Refresh automatico del grafico!"><button  type="button" class="btn btn-light" id="refreshGraph"><i class="fas fa-sync-alt"></i></button></span>
              <!-- <div class="fb-share-button" data-layout="button" data-size="large" data-mobile-iframe="false"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Condividi</a></div> -->

            </div>

          </div>

          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-database"></i> <span class="parse_data"></span></div>
            <div class="card-body ">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Tipo dato</th>
                  </tr>
                </thead>
                <tbody id="channel-tbody-type"></tbody>
              </table>
            </div>
          </div>

          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-share-alt"></i> <span class="parse_share"></span></div>
            <div class="card-body ">
              <div class="control-group" id="share-channel" style="display: none">
                <h5>Condividi il canale:</h5>
                <select id="select-to" class="contacts" placeholder="Cerca un utente"></select>

                <div class="row">
                  <div class="col-sm-8">
                    <select style="width: 100%" class="form-control" id="writable-share-channel">
                      <option value="0">Solo lettura</option>
                      <option value="1">Lettura/Scrittura</option>
                    </select><br>
                  </div>
                  <div class="col-sm-4">
                    <button id="button-share-channel" type="button" class="btn btn-info"> <i class="fa fa-share"></i></button>
                  </div>
                </div>

                <hr>

                <!-- <div class="fb-share-button" data-layout="button" data-size="large" data-mobile-iframe="false"></div> -->
              </div>

              <button id="fbButton" class="btn btn-primary"><i class="fab fa-facebook-f"></i></button>
              <a id="twitterbtn" href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-text="Ciao! Dai un occhiata al mio canale..." data-hashtags="theartofdata" data-show-count="false">Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
            </div>
          </div>

          <div class="card mod">
            <div class="card-body">
              <button data-toggle="modal" data-target="#modal-delete-channel" class="btn btn-link text-danger" name="button"><i class="fa fa-trash"></i> Elimina il canale</button>
            </div>
          </div>

        </div>


          <!-- Example Pie Chart Card-->


      </div>

    </div>
    <?php require("template/footer.html"); ?>
  </div>
  <script src="/js/dashboard/main.js" charset="utf-8"></script>

  <script src="/js/dashboard/channel.js" charset="utf-8"></script>
</body>

</html>
