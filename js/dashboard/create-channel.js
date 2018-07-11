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
  let dataNum = 0;

  // per disabilitare il pulsante per creare un canale privato se non è un utente pro!!
  getUserData('account_type', function(result){
    if(result == 0) $('#form-private').attr('disabled', 'disabled');
  });




  // handler aggiunta tipo dato, va modificato con chiamata ajax
  $('#add-data').click(function(){
    dataNum++;

    getDataTypes(function(data){
      let temp = '<br><select class="form-control" style="width:200px !important;"  id="editable-select'+dataNum+'">';
      data.forEach(x => {
        let str = x['data_type'];
        temp += '<option value="'+str+'">'+(str.charAt(0).toUpperCase()+str.slice(1))+'</option>'
      });


      $('#form-create-channel-data').append(temp);
      $('#editable-select'+dataNum).editableSelect();
    });


  });

  //aggiunta primo box di selezione dato
  $("#add-data").trigger("click");


  //handler invio form per la creazione di un canale
  $("#form-create-channel").submit(function(event){
    let pError = $('#form-create-channel-p-error');
    let alertDanger = $('#form-alert-danger');
    let alertDangerString = $('#form-alert-danger > span');

    alertDanger.hide();
    alertDangerString.text('');

    pError.text('').removeClass('red-color').removeClass('green-color');

    event.preventDefault();

    let name = $('#form-name').val().trim();
    let desc = $('#form-description').val().trim();
    let location = $('#form-location').val().trim();

    if(name == ""){
      alertDanger.show();
      alertDangerString.text('Inserire il nome del canale!');
      return;
    }

    let data = [];

    for(let i = 1; i <= dataNum; i++){
      let value = $('#editable-select'+i).val();

      if(value.indexOf(',') > -1 || value.indexOf(' ') > -1){
        alertDanger.show();
        alertDangerString.text('Non puoi inserire le virgole e spazi nei tipo dati!');

        return;
      }


      value = sanitizeString(value);

      if(value != "")
        data.push(value);
    }

    let priv = parseInt($("#form-create-channel input[name='visibility']:checked").val());

    //remove all duplicates
    data = $.unique(data);

    let dataCSV = data.toString();

    if(dataCSV == ""){
      alertDanger.show();
      alertDangerString.text('Inserire almeno un tipo dato!');
      return;
    }

    let token = Cookies.get('JWT_token');

    name = sanitizeString(name);


    $.post('../api/channel/create_channel.php',
    {
      JWT_token: token,
      name: name,
      description: desc,
      location: location,
      type_data: dataCSV,
      channel_type: priv
    },
    function(data, status){
      if(data.code == 200) {
        pError.text('Canale Creato!').addClass('text-dafult');
        getUserData('username', function(username){
          setInterval(function(){
            window.location = "../home/" + username + "/" + name;
          }, 200);
        });

      } else {
        alertDanger.show();
        alertDangerString.text(data.Type);
      }
    }
    );
  });

});
