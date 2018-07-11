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


  let $select = $('#search-select-to').selectize({
    valueField: 'url',
    labelField: 'name',
    searchField: ['name', 'type_data', 'location', 'description'],
    options: [],
    //plugins: ['no_results'],
    persist: false,
    loadThrottle: 100,
    create: false,
    load: function(query, callback) {
        if (query.length < 2) return callback();

        searchAll(query, function(result){
          callback(result);
        })
    },render: {
						item: function(item, escape) {
							let name = item.name;
              let icon = (item.type == 'channel') ? 'fa-chart-area' : 'fa-user';
							return '<div><i class="fa ' + icon + '"></i> <span>' + name + '</span></div>' ;
						},
						option: function(item, escape) {
              let name = item.name;
              let icon = (item.type == 'channel') ? 'fa-chart-area' : 'fa-user';

              let listType = '';

              let channelDiv = '';

              if(item.type == 'channel'){
                let dataType = item.type_data.split(',');
                listType = "<h4>Dati:</h4><ul>";
                for (let i in dataType)
                  listType += "<li>" + dataType[i];

                listType += "</ul>";

                channelDiv = '<div style="margin-top: 7px; padding-left: 5px">' +
                  '<p>' + 'Luogo: ' +
                    '<span style="font-weight: lighter">' +
                      item.location +
                    '</span>' +
                  '</p>' +
                  '<p>' + 'Descrizione: ' +
                    '<span style="font-weight: lighter">' +
                      item.description +
                    '</span>' +
                  '</p>' +
                  '<span style="font-weight: lighter">' + listType + '</span>' +
                '</div>';
              }


              return '<div>' +
                '<span class="selectize-title">' +
                  '<i class="fa ' + icon + '"></i> ' +
                  '<span style="font-size: 13pt">' + name + '</span>' +
                '</span>' +
                '<div style="margin-top: 7px; padding-left: 5px">' +
                  '<span style="font-weight: lighter">' + '/' + item.url + '</span>' +
                '</div>' +
                channelDiv +

							'</div>';
						}
					}
  });



  let selectizeControl = $select[0].selectize;

  selectizeControl.on('change', function() {
    let url = selectizeControl.items[0];
    if(url) window.location = url + "/";
  });
})
