// TheArtOfData
//   Copyright (C) 2018  by Anceschi Giovanni, Belmonte Luca, Boschini Matteo, Mechetti Luca, Monari Pietro, Scarfone Salvatore, Tardini Giovanni
//
//   Mail : theartofdat@gmail.com
//
//   This program is free software: you can redistribute it and/or modify
//   it under the terms of the GNU Affero General Public License as published
//   by the Free Software Foundation, either version 3 of the License, or
//   (at your option) any later version.
//
//   This program is distributed in the hope that it will be useful,
//   but WITHOUT ANY WARRANTY; without even the implied warranty of
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//   GNU Affero General Public License for more details.
//
//   You should have received a copy of the GNU Affero General Public License
//   along with this program.  If not, see <http://www.gnu.org/licenses/>.
$('#preload').show();

$(function () {
  getRandomImg("project", function(img){

    let url = img.urls.regular;
    let user = img.user;
    console.log(img);
    $('#header-bg').css("backgroundImage", "url(" + url + ")");
    $('#bg-credit-author').attr("href", user.links.html + "?utm_source=theartofdata&utm_medium=referral").html(img.user.username);
    $('#bg-credit-referral').attr("href", img.links.html + "?utm_source=theartofdata&utm_medium=referral");

    $('<img/>').attr('src', url).on('load', function() {
       $(this).remove(); // prevent memory leaks as @benweet suggested
       //$('body').css('background-image', 'url(http://picture.de/image.png)');
       $('#header-bg').css("backgroundImage", "url(" + url + ")");
    });

    setTimeout(function(){
      $('#preload').hide();
    }, 300);

  });


  $('.ml11 .letters').each(function(){
    $(this).html($(this).text().replace(/([^\x00-\x80]|\w)/g, "<span class='letter'>$&</span>"));
  });

anime.timeline({loop: false})

  .add({
    targets: '.ml11 .line',
    translateX: [0,$(".ml11 .letters").width()],
    easing: "easeOutExpo",
    duration: 700,
    delay: 100
  }).add({
    targets: '.ml11 .letter',
    opacity: [0,1],
    easing: "easeOutExpo",
    duration: 900,
    offset: '-=775',
    delay: function(el, i) {
      return 50 * (i+1)
    }
  });
  $.post('../api/projects/get_last_n_projects.php',
    {
      n: 8
    },
    function(data, status){

      for (var i = 0; i < data.length; i++) {
          $('#content').append(` <div class="col-lg-3 col-md-4 col-sm-6 portfolio-item">
              <div class="card h-100" style="padding : 5px ;min-height:100% !important;">
              <div style="height:40%" >
                <a href="`+  data[i].username   + "/" + data[i].title +`"><img style="height:100%"  class="card-img-top" src="`+   data[i].img +`" alt=""></a>
              </div>
                <div class="card-body">
                  <h1 class="card-title">
                    <a href="`+  data[i].username   + "/" + data[i].title +`">`+data[i].title+`</a>
                  </h1>
                  <a href="../home/`+ data[i].username+`/">  <p>postato da "`+data[i].username+`"</p></a>
                </div>
              </div>
            </div>
          `);

      }
    }
  );
})
