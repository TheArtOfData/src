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
  let username = USERNAME;


  if(!username){
    window.location = "/404";
    return;
  }


  document.title = "TheArtofData | " + username;

  getGuestUserData(username, function(userData){

    if(!userData){
      window.location = "/404";
      return;
    } else {
      let account_type = userData.account_type;

      let badge = '&nbsp;<span style="font-size: 13pt;" class="badge badge-primary">Free</span>';
      if(account_type == 1) badge = '&nbsp;<span style="font-size: 13pt;" class="badge badge-danger">Pro</span>';

      $('#profile-username').html(username + badge);

      let regRime = new Date(userData.registration_time * 1000);
      let lastLoginTime = new Date(userData.last_login_time * 1000);

      $('#profile-registration-time').text(regRime.toLocaleString());
      $('#profile-last-login-time').text(lastLoginTime.toLocaleString());

      getUserChannels(username, function(channels){


        for(let i in channels){
          let html = '';

          let icon = (channels[i].private == 1) ? '<i class="fa fa-lock" ></i> ' : '<i class="fa fa-globe-americas"></i> ';
          let channelName = '<h3 class="light">' + icon + '<a href="' + username + '/' + channels[i].name + '">' + username + '/' + channels[i].name + '</a></h3>';

          let location = '';
          if(channels[i].location)
            location = '<h5>Luogo: <span class="light">' + channels[i].location + '</span></h5>';

          let desc = '';
          if(channels[i].description)
            desc = '<h5>Descrizione: <span class="light">' + channels[i].description + '</span></h5>';

          let dataType = channels[i].type_data.split(',');

          let dataHTML = 'Dati:<ul>';
          for(let j in dataType){
            dataHTML += '<li>' + dataType[j] + '</li>';
          }

          dataHTML += '</ul>';
          html += channelName + location + desc + dataHTML;

          let template = `
            <div class="card mb-3">
              <div class="card-header">
                <i class="fa fa-area-chart"></i> `+ "Canale" +`</div>
              <div class="card-body ">
                `+
                  html
                 +`
              </div>
            </div>`;

          $('#profile-channels').append(template);
        }

        $("#preload").hide();
        $('#follow-channel').show();
      });
    }





  });


});
