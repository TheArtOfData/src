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
$.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null){
       return null;
    }
    else{
       return decodeURI(results[1]) || 0;
    }
}

$("#preload").show();
$('#follow-channel').hide();

$("head").append('<meta property="og:title" content="'+CHANNEL_NAME+'" >');
$("head").append('<meta property="og:description" content="'+USERNAME+'" >');


$(function(){


  let channelName = CHANNEL_NAME;
  let username = USERNAME;


  if(!channelName || !username){
    window.location = '/404';
    return;
  }

  getChannelData(username, channelName, function(channelData){
    if(channelData == false || channelData.code > 200) {
      window.location = '/404';
      return;
    }

    let icon = (channelData.private == 1) ? '<i class="fa fa-lock" ></i> ' : '<i class="fa fa-globe-americas"></i> ';

    document.title = "TheArtofData | " + channelData.name;

    $('#channel-name').html(icon + '<a href="' + username + '/">' + username + '</a>' + '/' + channelData.name);
    $('#channel-location').text(channelData.location);
    $('#channel-description').text(channelData.description);

    let dataType = channelData.type_data.split(',');

    $('#channel-tbody-type').text('');
    for(let i in dataType)
      $('#channel-tbody-type').append('<tr><td>'+ (parseInt(i) + 1) +'</td><td>'+ dataType[i] +'</td></tr>');

    let radioButton = $('#form-graph-type-data');
    radioButton.html('');

    for(let i in dataType){
      let temp = $('<div class="radio"></div>').append('<label><input type="radio" name="optradio" value="'+ dataType[i] +'">'+ dataType[i] +'</label>');
      radioButton.append(temp);
    }

    getChannelToken(username, channelName, function(channelToken){

      if(channelToken.writable){
        $("#modal-token .modal-title").text('Token canale: ' + channelData.name);
        $("#modal-token .modal-body").html('Token: <code selected>' + channelToken.channel_token + '</code><br>');
        $("#modal-token .modal-body").append('API: <code>https://theartofdata.tech/api/data/data_in.php?channel_token=' + channelToken.channel_token + '</code>');

        $('#download-script').click(function(){
          window.location.href= '../api/export_script.php?channel_token=' + channelToken.channel_token + '&type_data=' + dataType;
        });


        $(document).on ("submit", "#form-graph", function(event){

          let error = $('#form-graph-error');
          event.preventDefault();

          let data = $("#form-graph input[name='optradio']:checked").val();
          let name = $('#form-graph-name').val().trim();

          let type = 'line';

          error.removeClass('red-color');
          error.text('');

          if(!name) {
            error.addClass('red-color');
            error.text('Inserire un nome!');
            return;
          }

          if(!data) {
            error.addClass('red-color');
            error.text('Selezionare un dato!');
            return;
          }


          $.post(
            '../api/graph/create_graph.php',
            {
              JWT_token: Cookies.get('JWT_token'),
              channel_name: channelName,
              username: username,
              type_data: data,
              name_graph: name,
              type_graph: type,
              from_time: "time",
              to_time: "time"
            },
            function(data, status){
              if(data.code == 200){
                error.addClass('green-color');
                error.text('Grafico creato!');
                location.reload();
                return;
              } else {
                error.addClass('red-color');
                error.text(data.Type);
                return;
              }
            }
          );

        });

        getUserData('account_type', function(account_type){
            if(account_type == 1) {
              $('#share-channel').show();
              let $select = $('#select-to').selectize({
                valueField: 'name',
                labelField: 'name',
                searchField: ['name'],
                options: [],
                persist: false,
                loadThrottle: 100,
                create: false,
                load: function(query, callback) {
                    if (query.length < 2) return callback();

                    searchUser(query, function(result){
                      callback(result);
                    })
                },render: {
            						item: function(item, escape) {
            							let name = item.name;
                          let icon = (item.type == 'channel') ? 'fa-inbox' : 'fa-user';
            							return '<div><span class="fa ' + icon + '"></span> <span>' + name + '</span></div>' ;
            						},
            						option: function(item, escape) {
                          let name = item.name;
                          let icon = "fa-user";

                          return '<div><span class="selectize-title">' +
                            '<i class="fa ' + icon + '"></i> ' +
                            '<span style="font-size: 13pt">' + name + '</span>' +
                          '</span></div>' ;
            						}
            					}
              });


              let selectizeControl = $select[0].selectize;

              $('#button-share-channel').click(function(){
                $('#share-channel p').text("").removeClass("red-color").removeClass("green-color");
                let name = selectizeControl.items[0];
                if(name){
                  let writable = $("#writable-share-channel").val();

                  shareChannel(username, channelName, name, writable, function(result){
                    console.log(result);
                    if(result && result.code == 200) $('#share-channel p').text("Canale condiviso").addClass("green-color");
                    else $('#share-channel p').text(result.Type).addClass("red-color");
                  });
                }

              });


            }
        });

      } else {
        $('.mod').hide();

        if(!channelToken){
          $('#follow-channel').show();

          $('#follow-channel button').click(function(){
            followChannel(username, channelName, function(result){
              if(result.code == 200) location.reload();
            });
          });
        } else {
          $('#follow-channel').show();
          $('#follow-channel button').html('Segui già <i class="fas fa-star"></i>');

          $('#follow-channel button').click(function(){
            unfollowChannel(username, channelName, function(result){
              if(result.code == 200) location.reload();
            });
          });
        }
      }
    });

    getGraphs(username, channelName, function(graphs){
      if(graphs.length == 0){
        $('#channel-no-graph').show();
      } else {
        let container = $('#graphs-container');

        for(let i in graphs){
          let dataType = graphs[i].type_data;
          let name = graphs[i].graph_name;

          let chartId = 'chart' + i;

          let template = `
            <div class="card mb-3">
              <div class="card-header">
                <i class="fa fa-area-chart"></i> `+ name +`</div>
              <div class="card-body ">
                <div class="chartdiv" id="` + chartId + `"><div class="loader"></div></div>
              </div>
              <div class="card-footer small text-muted">
                Tipo Dato: <span class="light">`+ dataType +`</span>
                <br>
                Dati totali: <span class="light" id="graph-number-data` + chartId + `"> 0 </span>
              </div>
            </div>`;
          container.append(template);
          container.append('<hr>');
        }
      }
    });

    refreshData(username, channelName, true);


    reloadGraph = false;

    $('#refreshGraph').click(function(){
      $(this).toggleClass('btn-danger').toggleClass('btn-success');
      reloadGraph = !reloadGraph;

      if(reloadGraph) refreshData(username, channelName, false);
    });

    setInterval(function(){
      if(reloadGraph)
        refreshData(username, channelName, false);
    }, 7000);







    $('#main-content').show();
    $("#preload").hide();

  });


  $('#delete-channel').click(function(){
    deleteChannel(username, channelName, function(result){
      if(result.code == 200)
        window.location = '../home/';
    });
  });

  $('#datetimepicker').datetimepicker(
    {
      maxDate: moment(),
      useCurrent: false
    }
  );



  getChannelData(username, channelName, function(channelData){
    let dataType = channelData.type_data.split(',');

    let radioButton = $("#form-add-type-data");
    radioButton.html('');

    for(let i in dataType){
      let temp = $('<div id="radiodata" class="radio"></div>').append('<label><input type="radio" name="optradio" value="'+ dataType[i] +'">'+ dataType[i] +'</label>');
      radioButton.append(temp);
    }

    $("#radiodata:first-child input").attr("checked","checked");

  });

  $('#form-add-data').submit(function(event){

    event.preventDefault();

    let value = parseFloat($("#form-value").val().trim());
    let data_type = $('#form-add-data input[type=radio]:checked').val();

    let time;

    if(isNaN(value)){
      $("#form-value").addClass("has-error");
      $("#form-value").attr("placeholder","Inserire un valore");
    }
    else{
      $("#form-value").removeClass("has-error");

      time = $('#datetimepicker').data("datetimepicker").date();
      if(time != null) time = time.format("X");//x for milliseconds, X for seconds


      getChannelToken(username, channelName, function(channelToken){
        $('#form-data-add-error').html('').removeClass('red-color').removeClass('green-color');

        $.get(
          '../api/data/data_in.php',
          {
            channel_token: channelToken.channel_token,
            values: value,
            types: data_type,
            time: time
          }
          ,function(data,status){
            if(data.code == 200){
              refreshData(USERNAME, CHANNEL_NAME);
              $('#form-data-add-error').text("Dato caricato correttamente").addClass('green-color');
            }
            else
            $('#form-data-add-error').text(data.type).addClass('red-color');
          }
        );

      });

    }


  });

  

  $("#twitterbtn").click(function(){
    $("#twitterbtn").attr("data-url","https://theartofdata.tech/home/"+USERNAME+"/"+CHANNEL_NAME);
    alert($("#twitterbtn").attr("data-url"));
  });

});

function refreshData(username, channelName, showContent){

  getGraphs(username, channelName, function(graphs){
    if(graphs.length == 0){
      $('#channel-no-graph').show();
    } else {
      let container = $('#graphs-container');

      for(let i in graphs){
        let dataType = graphs[i].type_data;
        let name = graphs[i].graph_name;

        let chartId = 'chart' + i;




        getData(username, channelName, dataType, function(data){
          if(data.length == 0) {
            $("#"+chartId).html(`
              <div class="alert alert-info">
                <strong><i class="fa fa-exclamation-circle"></i></strong> Nessun dato presente.
              </div>`);
            return;
          }


          $('#graph-number-data' + chartId).text(data.length);

          for(let j in data){
            let tempDate = new Date(data[j].time*1000);
            data[j].time = tempDate.toISOString();
          }

          var chart = AmCharts.makeChart( chartId, {
            "type": "stock",
            "listeners": [{
              "event": "rendered",
              "method": handleRender
            } , {
              "event": "zoomed",
              "method": handleZoom
            }],
            "theme": "light",
            "categoryAxesSettings": {
              "minPeriod": "ss"
            },

            "dataSets": [ {
              "title": "data1",
              "color": "#3dc4ff",
              "fieldMappings": [ {
                "fromField": "value",
                "toField": "value"
              }],

              "dataProvider": data,
              "categoryField": "time"

            } ],

            "panels": [ {


              "showCategoryAxis": true,
              "title": dataType,
              "percentHeight": 90,

              "stockGraphs": [ {
                "periodValue": "Average",
                "id": "g1",
                "valueField": "value",
                "lineThickness": 2,
                "bullet": "round",
                "comparable": true
              } ],


              "stockLegend": {
                "valueTextRegular": " ",
                "markerType": "none"
              }
            }],

            "chartScrollbarSettings": {
              "graph": "g1",


               "backgroundAlpha": 0,
               "selectedBackgroundAlpha": 0.1,
               "selectedBackgroundColor": "#888888",
               "graphFillAlpha": 0,
               "graphLineAlpha": 0.5,
               "selectedGraphFillAlpha": 0,
               "selectedGraphLineAlpha": 1,
               "autoGridCount":true,
               "color":"#AAAAAA",
               "position":"top"

            },

            "mouseWheelZoomEnabled":true,

            "chartCursorSettings": {
              "valueBalloonsEnabled": true
            },



            "periodSelector": {
              "position": "top",
              "dateFormat": "YYYY-MM-DD JJ:NN:SS",
              "inputFieldWidth": 170,
              "periods": [ {
                "period": "hh",
                "count": 1,
                "label": "1 hour"
              }, {
                "period": "hh",
                "count": 2,
                "label": "2 hours"
              }, {
                "period": "hh",
                "count": 5,

                "label": "5 hour"
              }, {
                "period": "hh",
                "count": 12,
                "label": "12 hours"
              }, {
                "selected": true,
                "period": "MAX",
                "label": "MAX"
              } ]
            },

            "panelsSettings": {
              "usePrefixes": true
            },



            "export": {
              "enabled": true,
              "position": "bottom-left"
            }
          } );


          function handleRender(){
            //
            //console.log("yeee");

          }

          function handleClick( event ){
            //console.log(event);
          }

          function handleZoom(event) {
            //console.log(event)
          }

        });
      }
    }
  });
}

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

  shareOverrideOGMeta("https://theartofdata.tech/home/"+USERNAME+"/"+CHANNEL_NAME+"/",USERNAME+"/"+CHANNEL_NAME, "Canale di "+USERNAME, "https://theartofdata.tech/img/grafo4k-min.png");

  };

  (function(d, s, id){
   var js, fjs = d.getElementsByTagName(s)[0];
   if (d.getElementById(id)) {return;}
   js = d.createElement(s); js.id = id;
   js.src = "//connect.facebook.net/en_US/sdk.js";
   fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
});
