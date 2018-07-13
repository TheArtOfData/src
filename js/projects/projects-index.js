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



$(function () {
  let n = 100;

  getLastNProjects(n, function(data){
    console.log(data);
    let totalContent = "";

    for(let i in data){
      let actualData = data[i];

      let title = actualData.title;
      let author = actualData.user;
      let url = actualData.url;
      let imgToken = actualData.img;

      totalContent += getPostTemplate(title, author, url, imgToken);
    }

    $('#projects-container').html(totalContent);

    window.sr = ScrollReveal();
    sr.reveal('.sr-img', {
      duration: 700,
      scale: 0.5
    });


    $('#preload').fadeOut();
  })

  let projectFrontImg = $('#project-front-img').height();


  $('#particles-js-project canvas').height(projectFrontImg);

  let particlesJsProject = $('#particles-js-project canvas').height();
});

function getPostTemplate(title, author, url, imgToken){
  let imgUrl = "/api/media/get_media.php?token=" + imgToken;
  let postUrl = "/projects/view.php?url=" + url;
  let authorUrl = "/home/" + author + "/";
  let template = `
  <div class="col sr-img">
    <div class="card" style="">
      <a href="` + postUrl + `"><img class="card-img-top" src="` + imgUrl + `" alt="Card image cap"></a>
      <div class="card-body">
        <a href="` + authorUrl + `"><h6 class="card-subtitle mb-2 text-muted">` + author + `</h6></a>
        <a href="` + postUrl + `"><h5 class="card-title">` + title + `</h5></a>
        <p class="card-text"></p>
      </div>
    </div>
  </div>`;
  return template;
}
