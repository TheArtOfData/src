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
$(function(){
  if(!URL){
    window.location = "/404/";
    return;
  }

  let projTitle;
  let projCreatorUsername;
  let frontImage;

  let url = URL;
  getProjectData(url, function(projectData){
    if(!projectData){
      window.location = "/projects";
    }

    let title = projectData.title;
    let username = projectData.username;

    projTitle = title;
    projCreatorUsername = username;

    $('#project-title').text(title);
    $('#project-sub-title').html('Creato da <a target="_blank" href="/home/' + username + '/">' + username + '</a>');


    let frontImg = projectData.img;
    frontImage = frontImg;

    //$('#project-front-img').css("background", "url(/api/media/get_media.php?token=" + frontImg + ")");

    getStepsData(url, function(stepsData){
      let totalContent = "";

      for(let i in stepsData){
        let actualStep = stepsData[i];

        let nStep = actualStep.step_num;
        let title = actualStep.title;
        let content = actualStep.content;
        let imgs = actualStep.img;

        totalContent += getStepTemplate(nStep, title, content, imgs);
      }

      $('#project-container').html(totalContent);

      $('.popup-gallery-projects').magnificPopup({
        delegate: 'a',
        type: 'image',
        tLoading: 'Loading image #%curr%...',
        mainClass: 'mfp-img-mobile',
        gallery: {
          enabled: true,
          navigateByImgClick: true,
          preload: [0, 1]
        },
        image: {
          tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
        }
      });

      window.sr = ScrollReveal();
      sr.reveal('.sr-img', {
        duration: 700,
        scale: 0.5
      });



      // let projectFrontImg = $('#project-front-img').innerHeight();
      //
      //
      // $('#particles-js-project canvas').css("height", projectFrontImg + "px");
      //
      // let particlesJsProject = $('#particles-js-project canvas').height();

      $('#preload').fadeOut();
    });
  });


  function getStepTemplate(nStep, title, content, imgs){
    let urlImg = "/api/media/get_media.php?token=";

    let imageContainer = '<div class="row popup-gallery-projects">';

    for(let iImg in imgs){
      let finalUrl = urlImg + imgs[iImg];
      imageContainer += `
      <div class="col" style="min-width: 300px; max-width: 500px; margin-bottom: 2rem;">
        <div class="card sr-img">
          <a href="` + finalUrl + `">
            <img class="card-img"  src="` + finalUrl + `" alt="Card image cap">
          </a>
        </div>
      </div>`;

    }

    imageContainer += '</div>';

    let template = `
    <div class="row">
      <div class="col-lg-10 mx-auto pb-5">
        <h1 class="mb-4">Step ` + nStep + `: ` + title + `</h1>

        `+
        imageContainer
        +`
      </div>

      <div class="col-lg-8 mx-auto">

        `
        +
          content
        +
        `

      </div>
    </div>

    <hr class="my-5">
    `;

    return template;
  }

  // function createStep(url, nStep, stepsData){
  //   getStepMedia(url, nStep, function(imgData){
  //     if(nStep > 0){
  //       createStep(url, nStep - 1, stepsData);
  //
  //       if(stepsData[nStep - 1].title != "") {
  //         $('#project-container').prepend(getStepTemplate(nStep, stepsData[nStep - 1].title, stepsData[nStep - 1].content, imgData));
  //

  //       }
  //
  //
  //     } else {
  //       let script = '<script src="../js/prism.js" ></script>';
  //       $('#project-container').append(script);
  //     }
  //
  //   });
  // }
  //
  //
//facebook shere
$('#fbButton').click(function(){
  window.fbAsyncInit = function() {
  FB.init({
    appId            : '1861801120790645',
    autoLogAppEvents : true,
    xfbml            : true,
    version          : 'v2.10'
  });
  FB.AppEvents.logPageView();

  function shareOverrideOGMeta(overrideLink, overrideTitle, overrideDescription, overrideImage)
  {
    FB.ui({
      method: 'share_open_graph',
      action_type: 'og.likes',
      action_properties: JSON.stringify({
        object: {
          'og:url': overrideLink,
          'og:title': overrideTitle,
          'og:description': overrideDescription,
          'og:image': overrideImage
        }
      })
    },
    function (response) {
    // Action after response
    });
  }

  shareOverrideOGMeta(window.location.href,projTitle, "Creato da "+projCreatorUsername, "https://theartofdata.tech/api/media/get_media.php?token=" + frontImage);

  };

  (function(d, s, id){
   var js, fjs = d.getElementsByTagName(s)[0];
   if (d.getElementById(id)) {return;}
   js = d.createElement(s); js.id = id;
   js.src = "//connect.facebook.net/en_US/sdk.js";
   fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
});
});
