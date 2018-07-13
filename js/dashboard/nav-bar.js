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
  getUserData('username', function(name){
    $('#username-db').attr("href", name + "/");

    getUserData('account_type', function(account_type){
        let badge = '&nbsp;<span class="badge badge-primary">Free</span>';
        if(account_type == 1) badge = '&nbsp;<span class="badge badge-danger">Pro</span>';
		    $("#username-db").html(name + badge);
    });
	});

  $('#button-log-out').click(function(){
		logOut();
	});

});
