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
LANG = "it";

function isLogged(result){
  let cookies = document.cookie;
  let token = Cookies.get('JWT_token');
  if(!token)
    result(false);

  $.post('../api/user/is_logged.php',
    {
      JWT_token: token
    },
    function(data, status){
      result(data);
    }
  );
}

function logOut(){
  Cookies.remove('JWT_token');
  window.location = "../login/";
}

function now(){
  return parseInt(Date.now() / 1000); // come il time() in php
}

function sanitizeString(str){
  str = str.trim().replace(/[^a-z0-9áéíóúñü\._-]/gim,"-");
  return str;
}





// POST AND GET REQUEST

// ---------------------------------------------
// ---- user
// ---------------------------------------------

/*
* RECUPERI LE INFORMAZIONE DELL'UTENTE LOGGATO
*/


function getUserData(col, result){
	let token = Cookies.get('JWT_token');

	$.post('../api/user/get_user_data.php',
		{
			JWT_token: token,
			data: col
		},
		function(data, status){
			result(data);
		}
	);
}

/*
* CANALI PUBBLICI DI UN UTENTE
*/
function getGuestUserData(username, result){
	let token = Cookies.get('JWT_token');

	$.post('../api/user/get_guest_user_data.php',
		{
			JWT_token: token,
			username: username
		},
		function(data, status){
			result(data);
		}
	);
}



// ---------------------------------------------
// ---- channel
// ---------------------------------------------

/*
* RECUPERI (IF ANY) IL TOKEN DELL'UTENTE DEL CANALE
*/
function getChannelToken(username, channelName, result){
	let token = Cookies.get('JWT_token');

	$.post('../api/channel/get_channel_token.php',
		{
			JWT_token: token,
			channel_name: channelName,
			username: username
		},
		function(data, status){
			result(data);
		}
	);
}

/*
* RECUPERI LE INFORMAZIONE DEL CANALE
*/
function getChannelData(username, channelName, result){
	let jwt = Cookies.get('JWT_token');
	$.post('../api/channel/get_channel_data.php',
		{
			JWT_token: jwt,
			username: username,
			channel_name: channelName
		},
		function(data, status){
			result(data);
		}
	);
}

/*
* RECUPERI TUTTI I CANALI DELL'UTENTE LOGGATO
*/
function getChannels(result){
	let token = Cookies.get('JWT_token');

	$("#homeSubmenu").text('');

	$.post("../api/channel/get_channels.php",
		{
			JWT_token: token
		},
		function(data, status){
			result(data);
		}
	);
}

/*
* RECUPERI TUTTI I CANALI CONDIVISI CON L'ACCOUNT LOGGATO
*/
function getSharedChannels(result){
	let token = Cookies.get('JWT_token');



	$.post("../api/channel/get_shared_channels.php",
		{
			JWT_token: token
		},
		function(data, status){
			result(data);
		}
	);
}

/*
* ELIMINA IL CANALE SELEZIONATO
*/
function deleteChannel(username, channelName, result){
	let jwt = Cookies.get('JWT_token');

	$.post('../api/channel/delete_channel.php',
		{
			channel_name: channelName,
			username: username,
			JWT_token: jwt
		},
		function(data, status){
			result(data);
		}
	);
}

/*
* FOLLOW CANALE
*/
function followChannel(username, channelName, result){
	let jwt = Cookies.get('JWT_token');
	$.post('../api/channel/follow_channel.php',
		{
			JWT_token: jwt,
			username: username,
			channel_name: channelName
		},
		function(data, status){
			result(data);
		}
	);
}

/*
* SHARE CANALE
*/
function shareChannel(channelUsername, channelName, username, writable, result){
	let jwt = Cookies.get('JWT_token');
	$.post('../api/channel/share_channel.php',
		{
			JWT_token: jwt,
			channel_username: channelUsername,
			channel_name: channelName,
			writable: writable,
			username: username
		},
		function(data, status){
			result(data);
		}
	);
}

/*
* UNFOLLOW CANALE
*/
function unfollowChannel(username, channelName, result){
	let jwt = Cookies.get('JWT_token');
	$.post('../api/channel/unfollow_channel.php',
		{
			JWT_token: jwt,
			username: username,
			channel_name: channelName
		},
		function(data, status){
			result(data);
		}
	);
}

/*
* CANALI PUBBLICI DI UN UTENTE
*/
function getUserChannels(username, result){
	$.post('../api/channel/get_user_channels.php',
		{
			JWT_token: Cookies.get('JWT_token'),
			username: username
		},
		function(data, status){
			result(data);
		}
	);
}


// ---------------------------------------------
// ---- GRAPHS AND DATA
// ---------------------------------------------

/*
* RECUPERI TUTTI I DATA DEL CANALE DAL TIPO DATO
*/
function getData(username, channelName, type, result){
	let jwt = Cookies.get('JWT_token');
	$.post(
		'../api/data/get_data.php',
		{
			JWT_token: jwt,
			type: type,
			username: username,
			channel_name: channelName

		},
		function(data, status){
			result(data);
		}
	);
}

/*
* RECUPERI TUTTI I GRAFICI DEL CANALE
*/
function getGraphs(username, channelName, result){
	let jwt = Cookies.get('JWT_token');

	$.post('../api/graph/get_graphs.php',
		{
			channel_name: channelName,
			username: username,
			JWT_token: jwt
		},
		function(data, status){

			result(data);
		}
	);
}

/*
* RECUPERIAMO I TIPI DATO
*/
function getDataTypes(result){
	$.post('../api/data-types/get_data_types.php',
	function(data,status){
		result(data);
	});
}

/*
*	RICERCHE
*/

function searchAll(data_query, result){
	$.post('../api/search/search_all.php',
		{
			data_query: data_query
		},
		function(data, status){
			result(data);
		}
	);
}

function searchUser(data_query, result){
	$.post('../api/search/search_user.php',
		{
			data_query: data_query
		},
		function(data, status){
			result(data);
		}
	);
}


// PROJECT

// function getProjectData(username, title, result){
//   $.post("/api/projects/get_project.php",
//     {
//
//       username: username,
//       title: title
//     }, function(data, status){
//       result(data);
//     }
//   );
//
// }

function getComments(username, title, result){
  $.post("/api/projects/comments/get_project_comments.php",
    {
      project_username: username,
      project_name: title
    }, function(data, status){
      result(data);
    }
  );
}

function insertComments(username, title, content, result){
  let token = Cookies.get("JWT_token");
  if(token){
    $.post("/api/projects/comments/insert_comment.php",
      {
        JWT_token: token,
        project_username: username,
        project_name: title,
        content: content
      }, function(data, status){
        result(data);
      }
    );
  }
}


// PROJECT


function getProjectData(url, result){
	$.post(
		'../api/projects/get_project_data.php',
		{
      JWT_token: Cookies.get("JWT_token"),
      url: url
		},
		function(data, status){
			result(data);
		}
	);
}

function getLastNProjects(n, result){
	$.post(
		'../api/projects/get_last_n_projects.php',
		{
      n: n
		},
		function(data, status){
			result(data);
		}
	);
}

function deleteProject(url, result){
  let jwt = Cookies.get('JWT_token');
  $.post(
    '../api/projects/delete_project.php',
    {
      JWT_token: jwt,
      url: url
    },
    function(data, status){
      result(data);
    }
  )
}

function updateTitle(url, title, result){
  let jwt = Cookies.get('JWT_token');
  $.post(
    '../api/projects/update_title.php',
    {
      JWT_token: jwt,
      url: url,
      title: title
    },
    function(data, status){
      result(data);
    }
  )
}

function updateVisibility(url, vis, result){
  let jwt = Cookies.get('JWT_token');
  $.post(
    '../api/projects/update_visibility.php',
    {
      JWT_token: jwt,
      url: url,
      visibility: vis
    },
    function(data, status){
      result(data);
    }
  )
}

function getStepsData(url, result){
	$.post(
		'../api/projects/get_steps_data.php',
		{
      url: url
		},
		function(data, status){
			result(data);
		}
	);
}

function createStep(url, stepNum){
	let jwt = Cookies.get('JWT_token');
	$.post(
		'../api/projects/create_step.php',
		{
			JWT_token: jwt,
      url: url,
      step_num: stepNum
		}
	);
}

function updateStep(url, stepNum, title, content){
	let jwt = Cookies.get('JWT_token');
	$.post(
		'../api/projects/update_step.php',
		{
			JWT_token: jwt,
      url: url,
      step_num: stepNum,
      title: title,
      content: content
		}
	);
}

function getStepMedia(url, stepNum, result){
	$.post(
		'../api/projects/get_step_media.php',
		{
      url: url,
      step_num: stepNum
		},
    function(data, status){
      result(data);
    }
	);
}

function getUserProjects(result){
	let jwt = Cookies.get('JWT_token');
	$.post(
		'../api/projects/get_user_projects.php',
		{
			JWT_token: jwt

		},
		function(data, status){
			result(data);
		}
	);
}


function getComments(username, title, result){
  $.post("/api/projects/comments/get_project_comments.php",
    {
      project_username: username,
      project_name: title
    }, function(data, status){
      result(data);
    }
  );
}

function insertComments(username, title, content, result){
  let token = Cookies.get("JWT_token");
  if(token){
    $.post("/api/projects/comments/insert_comment.php",
      {
        JWT_token: token,
        project_username: username,
        project_name: title,
        content: content
      }, function(data, status){
        result(data);
      }
    );
  }

}
