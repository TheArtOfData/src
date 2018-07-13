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
    <meta name="description" content="">
    <meta name="author" content="">

    <base href="/projects/post.php">



    <title id="titolo">TheArtOfProjects</title>

    <?php
    echo '<script type="text/javascript">',
         'var USERNAME = "' . @$_GET['username'] . '";',
         'var TITLE = "' . @$_GET['title'] . '";',
         'document.title=""+TITLE',
         '</script>';
    ?>


    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <?php require('template/import.html'); ?>

    <!-- Custom styles for this template -->
    <link href="css/clean-blog.css" rel="stylesheet">

    <style>
      .form-group {
        max-width: 100% !important;
      }
    </style>

  </head>

  <body>

    <?php require('template/navbar.html'); ?>

    <!-- Page Header -->
    <header class="masthead" id="project-img" >
      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <div class="post-heading">
              <h1 id="project-title">
                <!--------------------->
                <!--- PROJECT TITLE --->
                <!--------------------->
              </h1>
              <!-- <h2 class="subheading"></h2> -->
              <span class="meta">Postato da
                <a href id="project-user">

                </a>
                il
                <span id="project-date">

                </span>
              </span>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Post Content -->
    <article>
      <div class="container">
        <div class="row">

          <div class="col-lg-8 col-md-10 mx-auto" id="project-content">

            <!--------------------->
            <!-- PROJECT CONTENT -->
            <!--------------------->

          </div>

        </div>

        <div class="row">

          <div class="col-lg-10 col-md-10 mx-auto" id="">



            <hr>

            <h2> <small>Commenti:</small></h2>

            <div class="form-group">
              <textarea class="form-control" id="comment-content" placeholder="Inserisci commento qui"></textarea>
              <button id="send-comment" type="button" class="btn btn-primary" style="margin-top: 10px;">Invia <small></small></button>
            </div>

            <hr>

            <div id="project-comments">
              <!--------------------->
              <!-- PROJECT COMMENT -->
              <!--------------------->
            </div>





        </div>
      </div>
    </article>


    <?php require('template/footer.html'); ?>



    <script src="../js/projects/post.js" charset="utf-8"></script>


  </body>

</html>
