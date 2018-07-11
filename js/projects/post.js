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
$(function(){
  if(!USERNAME || !TITLE){
    window.location = "/404/";
    return;
  }


  getProjectData(USERNAME, TITLE, function(data){
    if(!data) {
      window.location = "/404/";
      return;
    }

    let title = data.title;
    let content = data.content;

    $('#project-title').text(title);
    $('#project-user').text(USERNAME).attr("href", "/home/" + USERNAME + "/").attr("target", "_blank");

    let date = new Date(data.publish_time * 1000);
    $('#project-date').text(date.toLocaleDateString());
    $('#project-img').css("backgroundImage", "url('" + data.img + "')");


    $('#project-content').html(content + '<script src="../js/prism.js" charset="utf-8"></script>');

    loadComments();

    $('#send-comment').click(function(){
      let content = $('#comment-content').val().trim();

      insertComments(USERNAME, TITLE, content, function(data){
        if(data.code == 200){
          loadComments();
          $('#comment-content').val("");
        }


      });

    });


    isLogged(function(result){
      if(result){
        getUserData("username", function(username){
          $('#send-comment small').text("come " + username);
        })
      } else {
        $('#send-comment').text("Loggati!").attr("onclick", "location.href='/login/?red=" + window.location.href + "'");
      }
    });



    $('#preload').hide();
  });


});


function loadComments(){
  getComments(USERNAME, TITLE, function(comments){
    $('#project-comments').html("");



    for (var i in comments) {
      let username = comments[i].username;
      let content = comments[i].content;

      let date = new Date(comments[i].date * 1000);

      let commentTemplate = `<div>
        <p>
          <h5><a target="_blank" href="/home/` + comments[i].username + `/">`+ comments[i].username +`</a><small> - ` + date.toLocaleString() + `</small></h5>
          ` + content + `

        </p>

        <hr>
      </div>`;
      $('#project-comments').append(commentTemplate);
    }
  });
}

// $('#fbButton').click(function(){
//   window.fbAsyncInit = function() {
//   FB.init({
//     appId            : '1861801120790645',
//     autoLogAppEvents : true,
//     xfbml            : true,
//     version          : 'v2.10'
//   });
//   FB.AppEvents.logPageView();
//
//   function shareOverrideOGMeta(overrideLink, overrideTitle, overrideDescription, overrideImage)
//   {
//     FB.ui({
//       method: 'share_open_graph',
//       action_type: 'og.likes',
//       action_properties: JSON.stringify({
//         object: {
//           'og:url': overrideLink,
//           'og:title': overrideTitle,
//           'og:description': overrideDescription,
//           'og:image': overrideImage
//         }
//       })
//     },
//     function (response) {
//     // Action after response
//     });
//   }
//   shareOverrideOGMeta("https://theartofdata.tech/projects/"+USERNAME+"/"+TITLE+"/",USERNAME+"/"+TITLE, "Canale di "+USERNAME, "https://theartofdata.tech/img/grafo4k-min.png");
//
//   };
//
//   (function(d, s, id){
//    var js, fjs = d.getElementsByTagName(s)[0];
//    if (d.getElementById(id)) {return;}
//    js = d.createElement(s); js.id = id;
//    js.src = "//connect.facebook.net/en_US/sdk.js";
//    fjs.parentNode.insertBefore(js, fjs);
//    }(document, 'script', 'facebook-jssdk'));
// });

// ---------------
// POST CALL
// ---------------
