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
  getChannels(function(channels){
    if(channels.length == 0)
      $("#channelMenu").append('<li><a href="#">Nessun canale!</a></li>');
    else {
      getUserData('username', function(username){
        for (let i in channels) {
          let actualChannel = channels[i];
          let oldpath = 'channel.php?' + 'username=' + username + '&channel_name=' + actualChannel.name;
          let newPath = username + '/' + actualChannel.name;
          let icon = (actualChannel.private == 1) ? '<i class="fa fa-fw fa-lock"></i> ' : '<i class="fa fa-fw fa-globe-americas"></i> ';
          $("#channelMenu").append('<li ><a href="'+ newPath +'">' + icon + actualChannel.name + '</a></li>');
        }
      })
    }
  });

  getSharedChannels(function(channels){
    if(channels.length == 0)
      $("#sharedSubmenu").append('<li><a href="#">Nessun canale!</a></li>');
    else {
      getUserData('username', function(username){
        for (let i in channels) {
          let actualChannel = channels[i];
          let oldpath = 'channel.php?' + 'username=' + actualChannel.username + '&channel_name=' + actualChannel.name;
          let newPath = actualChannel.username + '/' + actualChannel.name;
          let icon = (actualChannel.private == 1) ? '<i class="fa fa-fw fa-lock"></i> ' : '<i class="fa fa-fw fa-globe-americas"></i>';
          $("#sharedSubmenu").append('<li ><a href="'+ newPath +'">' + icon + actualChannel.username + '/' + actualChannel.name + '</a></li>');
        }
      })
    }
  });

  getUserProjects(function(pj){ // list-projects
    if(pj.length == 0)
      $("#list-projects").append('<li><a href="#">Nessun progetto!</a></li>');
    else {
      for (let i in pj) {
        let icon = "";
        let url = "edit-project.php?url=" + pj[i].url;
        $("#list-projects").append('<li><a href="' + url + '">' + icon + " " + pj[i].title + '</a></li>');

      }
    }
  });


});
