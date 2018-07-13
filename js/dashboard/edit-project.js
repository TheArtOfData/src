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
function valid(input){
  if(input.val() == ""){
    input.addClass("has-error");
    input.focusout(function(){
      if(input.val() != "")
        input.removeClass("has-error");
    });
    return false;
  }
  else
    return true;
}

function getAllContent(){
  let content = "";
  for(let i=1;i<=nStep;i++){
    let steptitle = $("#titlestep"+i);
    if(!valid(steptitle)){
      steptitle.attr("placeholder","inserire un titolo per lo step");
      return;
    }
    content += "<h3>"+steptitle.val()+"</h3>";

    let editor = tinymce.get("editor"+i);
    let text = editor.getContent();

    if(text === ""){
      editor.setContent("<h2 style='color:red'>Scrivi qualcosa all'interno del tuo step</h2>",{format:"raw"});
      return;
    }
    content += text;
  }
  return content;
}

/**
* @function addStep()
* @description Append a step template (html) on stepcontainer and append button on steplist
*/
function addStep(stepNumber){
  let templateStep =
  `<div class=" mb-3 " style="display:none" id="step` + stepNumber + `">
    <div class="">
      <i class="fas fa-align-left"></i> Step `+stepNumber+`
      <hr>
    </div>

    <div class="">

      <div class="form-group steptitle">
        <h4>Titolo</h4>
        <input class="form-control" onClick="this.select()" id="titlestep` + stepNumber + `" name="step` + stepNumber + `" type="text">
      </div>

      <hr>

      <h4>Immagini</h4>
      <p>Max file 3.5MB</p>
      <div class="file-loading">
        <input id="imgstep` + stepNumber + `" name="imgstep" type="file" multiple>
      </div>

      <hr>

      <h4>Testo</h4>
      <textarea id="editor` + stepNumber + `"></textarea>

    </div>
  </div>`;

  let buttonTemplate =
  `<button type="button" class="btn btn-outline-dark text-center stepbtn" id="btnstep` + stepNumber + `">
    step ` + stepNumber +
  `</button>`;


  $("#stepcontainer").append(templateStep);
  $("#steplist").append(buttonTemplate);


}

function saveStep(url, stepNumber){
  let fromTitle = $("#titlestep" + stepNumber).val();
  let fromContent = tinymce.get("editor" + stepNumber).getContent({format: "raw"});

  //console.log(stepNumber + "  -  " + fromContent);

  updateStep(url, stepNumber, fromTitle, fromContent);
}

$(function(){

  let url = URL;

  if(!url){
    window.location = '/404';
    return;
  }


  // MAIN FUNCTION

  getProjectData(url, function(projectData){
    if(!projectData){
      window.location = "/home";
    }

    let headerIcon = '<i class="fa fa-inbox"></i> ';
    $('#project-title').html(headerIcon + projectData.title);

    $('#new-project-title').val(projectData.title);
    $('#project-link').attr("href", "/projects/view.php?url=" + url);
    // input front img
    let published = projectData.published;

    if(published == 1){
      $('#project-visibility').text("Pubblicato");
      $('#project-publish').hide();
    } else {
      $('#project-visibility').text("Non pubblicato");
      $('#project-unpublish').hide();

    }

    let fronImgToken = projectData.img;


    let urlArray = ["/api/media/get_media.php?token=" + fronImgToken];

    let config = [{
      key: fronImgToken,
      url: "/api/media/delete_media.php?token=" + fronImgToken
    }];

    let fileinputConfigFrontImg = {
      initialPreview: urlArray,
      initialPreviewConfig: config,
      initialPreviewAsData: true,
      initialPreviewDownloadUrl: '/api/media/get_media.php?token={key}',
      //deleteUrl: '/api/media/delete_media.php?token={key}',
      maxFileSize: 3500,
      showUpload: true,
      allowedFileExtensions: ["jpg", "jpeg", "gif", "png"],
      elErrorContainer: "#errorFrontImg",
      dropZoneTitle:"Carica qui le tue immagini",
      uploadUrl: "/api/projects/update_front_image.php",
      uploadClass: "btn btn-success",
      theme: "fa",
      browseLabel: "Seleziona ...",
      overwriteInitial: true,
      fileActionSettings: {
        showUpload: true,
        showZoom: false,
        showDelete: false,

        uploadClass: "btn btn-success",
        uploadLabel: "Upload",
        uploadIcon: "<i class=\"fa fa-upload\"></i> ",

        downloadClass: "btn btn-primary",
        downloadLabel: "Download",
        downloadIcon: "<i class=\"fa fa-download\"></i> ",

        zoomClass: "btn btn-primary",

        removeClass: "btn btn-danger"
      },
      browseOnZoneClick: true,
      purifyHtml: true,
      uploadExtraData: function (previewId, index) {
        let data = {
          JWT_token: Cookies.get("JWT_token"),
          url: url
        }
        return data;
      }
    };

    $('#pj-front-img').fileinput(fileinputConfigFrontImg);


    $('#pj-front-img').on('fileuploaded', function(event, data, previewId, index) {
      var form = data.form, files = data.files, extra = data.extra,
          response = data.response, reader = data.reader;
      console.log(response);
    });
  });

  getStepsData(url, function(data){
    if(!data) {
      window.location = '/404';
      return;
    }


    let nStep = 0;
    let fromStep = 0;
    let toStep = 0;

    let tinymceConfig = {
      selector: "",
      themes: "modern",
      height:500,
      plugins: [
        'advlist autolink lists link charmap print preview anchor',
        'searchreplace visualblocks fullscreen',
        'insertdatetime media table contextmenu paste',
        'codesample'
      ],
      toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | codesample',
      codesample_languages: [
        {text: 'HTML/XML', value: 'markup'},
        {text: 'JavaScript', value: 'javascript'},
        {text: 'CSS', value: 'css'},
        {text: 'PHP', value: 'php'},
        {text: 'Ruby', value: 'ruby'},
        {text: 'Python', value: 'python'},
        {text: 'Java', value: 'java'},
        {text: 'C', value: 'c'},
        {text: 'C#', value: 'csharp'},
        {text: 'C++', value: 'cpp'},
        {text:"batch",value:"batch"},
        {text: 'Bash', value: 'bash'}
      ]};
    let fileinputConfig = {
      //deleteUrl: '/api/media/delete_media.php?token={key}',
      showUpload: true,
      allowedFileExtensions: ["jpg", "jpeg", "gif", "png"],
      elErrorContainer: "#errorBlock",
      dropZoneTitle:"Carica qui le tue immagini",
      uploadUrl: "/api/projects/upload_images_step.php",
      uploadClass: "btn btn-success",
      maxFileSize: 3500,
      theme: "fa",
      browseLabel: "Seleziona ...",
      overwriteInitial: false,
      fileActionSettings: {
        showUpload: true,
        showZoom: true,

        uploadClass: "btn btn-success",
        uploadLabel: "Upload",
        uploadIcon: "<i class=\"fa fa-upload\"></i> ",

        downloadClass: "btn btn-primary",
        downloadLabel: "Download",
        downloadIcon: "<i class=\"fa fa-download\"></i> ",

        zoomClass: "btn btn-primary",

        removeClass: "btn btn-danger",
        removeLabel: "Delete",
        removeIcon: "<i class=\"fa fa-trash\"></i> "
      },
      browseOnZoneClick: true,
      purifyHtml: true,
      uploadExtraData: function (previewId, index) {
        let data = {
          JWT_token: Cookies.get("JWT_token"),
          url: url,
          step_num: fromStep
        }
        return data;
      }
    };

    if(data.length == 0){
      nStep = 1;
      fromStep = 1;
      toStep = 1;

      createStep(url, toStep); // create step with api
      addStep(toStep);


      $("#imgstep" + nStep).fileinput(fileinputConfig);

      // tinymce init
      tinymceConfig.selector = "#editor"+nStep;
      tinymce.init(tinymceConfig);

      $('#step' + toStep).show();
      $('#btnstep' + toStep).toggleClass("active");
    } else {
      let steps = Array();
      steps.push(fromStep);


      for (let i in data) {
        nStep++;
        addStep(nStep);

        $('#titlestep' + nStep).val(data[i].title);
        $('#editor' + nStep).val(data[i].content);


        // fileinput init
        //console.log("Step " + nStep );


        setFileInput(i);

        // tinymce init
        tinymceConfig.selector = "#editor"+nStep;
        tinymce.init(tinymceConfig);
      }

      fromStep = 1;
      toStep = 1;
      $('#step' + toStep).show();
      $('#btnstep' + toStep).toggleClass("active");
    }


    /**
    * @event onClick(#save-all)
    */
    $("#save-all").click(function(){
      saveAll();
      $('#pjstatealert').show();
      setTimeout(function(){
        $('#pjstatealert').hide();
      }, 4000);
    });

    /**
    * @event onClick(.stepbtn)
    * @description change step and save it with ajax call
    */
    $(document).on("click", ".stepbtn",function(event){//refreshes every time

      // let title = $("#titlestep"+fromStep);
      // if(!valid(title)) return;

      saveStep(url, fromStep);

      //get which button has been pressed
      let id = event.target.id;

      //set it as target
      toStep = id.substr(7,id.length);

      //hide step which you're coming from
      $("#step"+fromStep).fadeOut();

      //show target step
      $("#step"+toStep).fadeIn();

      $('#btnstep' + toStep).toggleClass("active");
      $('#btnstep' + fromStep).toggleClass("active");

      //set current step as starting step for next change
      fromStep = toStep;


    });

    /**
    * @event onClick(#add-step)
    */
    $("#add-step").click(function(){
      nStep++;//`+nStep+`

      addStep(nStep);

      //set new step as target
      toStep = nStep;

      //hide step which you're coming from
      $("#step"+fromStep).fadeOut();

      //shwo target step
      $("#step"+toStep).fadeIn();

      $('#btnstep' + toStep).toggleClass("active");
      $('#btnstep' + fromStep).toggleClass("active");

      //set current step as starting step for next change
      fromStep = toStep;

      //initialize file input
      $("#imgstep"+fromStep).fileinput(fileinputConfig);

      tinymceConfig.selector = "#editor"+nStep;
      tinymce.init(tinymceConfig);

      createStep(url, nStep);
    });

    /**
    * @event onClick(#change-project-title)
    */
    $('#change-project-title').click(function(){
      $('#project-title').hide();
      $('#change-project-title').hide();
      $('#change-project-title-form').show();

      $('#new-project-title').focus();

    });

    /**
    * @event dblClick(#change-project-title)
    */
    $('#project-title').dblclick(function(){
      $('#project-title').hide();
      $('#change-project-title').hide();
      $('#change-project-title-form').show();

      $('#new-project-title').focus();
    });

    /**
    * @event onClick(#change-project-title-close)
    */
    $(document).on('click', '#change-project-title-close', function(){
      $('#project-title').show();
      $('#change-project-title').show();
      $('#change-project-title-form').hide();
    });

    /**
    * @event onClick(project-publish)
    */

    $('#project-publish').click(function(){
      updateVisibility(url, 1);

      location.reload();
    })

    /**
    * @event onClick(project-unpublish)
    */

    $('#project-unpublish').click(function(){
      updateVisibility(url, 0);

      location.reload();
    })

    /**
    * @event onSubmit(#change-pregect-title-form)
    */
    $(document).on('submit', '#change-project-title-form', function(e){
      e.preventDefault();
      let title = $('#new-project-title').val().trim();
      if(!title || title == "") return;
      if(title.lenght > 100) {
        alert("Max 150 characters!");
        return;
      };

      updateTitle(url, title);

      location.reload();

    });

    /**
    * @event onClick(#delete-project)
    */
    $('#delete-project').click(function(){
      deleteProject(url);
      window.location = "../home";
    });

    /**
    * @function onClick(#previewbtn)
    */
    $("#previewbtn").click(function(){

      let content = getAllContent();

      if(content === "")return;

      $("#previewmodal .modal-body").append(content);

      //finish preview function
    });


    /**
    * @function setFileInput
    */
    function setFileInput(i){
      let actualStep = parseInt(i) + 1;
      getStepMedia(url, actualStep, function(mediaToken){

        let urlArray = [];
        let config = [];
        if(mediaToken.length > 0){


          for (let j in mediaToken){
            let url = "/api/media/get_media.php?token=" + mediaToken[j].token;
            urlArray.push(url);
            config.push({
              key: mediaToken[j].token,
              url: "/api/media/delete_media.php?token=" + mediaToken[j].token
            });
          }

          let fileinputConfigCopy = {
            initialPreview: urlArray,
            initialPreviewConfig: config,
            initialPreviewAsData: true,
            initialPreviewDownloadUrl: '/api/media/get_media.php?token={key}',
            //deleteUrl: '/api/media/delete_media.php?token={key}',
            showUpload: true,
            allowedFileExtensions: ["jpg", "jpeg", "gif", "png"],
            elErrorContainer: "#errorBlock",
            dropZoneTitle:"Carica qui le tue immagini",
            uploadUrl: "/api/projects/upload_images_step.php",
            uploadClass: "btn btn-success",
            maxFileSize: 3500,
            theme: "fa",
            browseLabel: "Seleziona ...",
            overwriteInitial: false,
            fileActionSettings: {
              showUpload: true,
              showZoom: true,

              uploadClass: "btn btn-success",
              uploadLabel: "Upload",
              uploadIcon: "<i class=\"fa fa-upload\"></i> ",

              downloadClass: "btn btn-primary",
              downloadLabel: "Download",
              downloadIcon: "<i class=\"fa fa-download\"></i> ",

              zoomClass: "btn btn-primary",

              removeClass: "btn btn-danger",
              removeLabel: "Delete",
              removeIcon: "<i class=\"fa fa-trash\"></i> "
            },
            browseOnZoneClick: true,
            purifyHtml: true,
            uploadExtraData: function (previewId, index) {
              let data = {
                JWT_token: Cookies.get("JWT_token"),
                url: url,
                step_num: fromStep
              }
              return data;
            }
          };

          $("#imgstep" + actualStep).fileinput(fileinputConfigCopy);

        } else $("#imgstep" + actualStep).fileinput(fileinputConfig);
      });
    }

    /**
    * @function saveAll()
    */
    function saveAll(){
      for(let i = 1; i <= nStep; i++)
        saveStep(url, i);
    }

  });

});



/*$(function(){

  config = {
    selector: "#editor1",
    themes: "modern",
    plugins: [
      'advlist autolink lists link charmap print preview anchor',
      'searchreplace visualblocks fullscreen',
      'insertdatetime media table contextmenu paste',
      'codesample'
    ],
    toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | codesample',
  codesample_languages: [
    {text: 'HTML/XML', value: 'markup'},
    {text: 'JavaScript', value: 'javascript'},
    {text: 'CSS', value: 'css'},
    {text: 'PHP', value: 'php'},
    {text: 'Ruby', value: 'ruby'},
    {text: 'Python', value: 'python'},
    {text: 'Java', value: 'java'},
    {text: 'C', value: 'c'},
    {text: 'C#', value: 'csharp'},
    {text: 'C++', value: 'cpp'}
  ]
  }

  tinymce.init(config);

});

  let nStep = 1;
  let content = "";
  let published = 0;
  let checkcount=0;

  $("#publish_button").click(function(){
    published = 1;
    location.reload();
  })


  updateFileInput();

  $("#addStep").click(function(){
    nStep++;
  let newstep = `<hr><div id="step`+nStep+`">
  <h2>Step `+nStep+`</h2>
      <div class="form-group newproj">
        <h4>Titolo</h4>
        <input class="form-control" onClick="this.select()" id="titlestep`+nStep+`" name="step`+nStep+`" type="text">
      </div>
  <textarea id="editor`+nStep+`" style="height:80vh"></textarea>
</div>`;
    $("#steps").append(newstep);


    config.selector = "#editor"+nStep;
    tinymce.init(config);

  });


  function valid(input){
    if(input.val() == ""){
      input.addClass("has-error");
      input.focusout(function(){
        if(input.val() != "")
          input.removeClass("has-error");
      });
      return false;
    }
    else
      return true;
  }


  $("#form-create-project").submit(function(event){

    event.preventDefault();

    let projtitle = $("#projtitle");
    let categories =  $("#categories");

    if(!valid(projtitle) | !valid(categories)) return;

    for(let i=1;i<=nStep;i++){
      let steptitle = $("#titlestep"+i);
      if(!valid(steptitle)){
        steptitle.attr("placeholder","inserire un titolo per lo step");
        return;
      }
      content += "<h3>"+steptitle.val()+"</h3>";

      let editor = tinymce.get("editor"+i);
      let text = editor.getContent();

      if(text === ""){
        editor.setContent("<h2 style='color:red'>Scrivi qualcosa all'interno del tuo step</h2>",{format:"raw"});
        return;
      }
      content += text;
    }

    let obj = {
      JWT_token: Cookies.get("JWT_token"),
      title: projtitle.val(),
      categories: categories.val(),
      content: content,
      published:published
    };

  //fileinput extra data upload via post
  $("#imgs").fileinput('refresh',{
    uploadExtraData:()=>{
      //alert($(this).attr("id"));
      return obj;
    }
  });


  $("#imgs").fileinput('upload');

});


function updateFileInput(){
  $("#imgs").fileinput({
    showUpload:false,
    previewFileType: "image",
    uploadUrl: "/api/projects/projects_in.php",
    maxFileCount: 20,
    allowedFileTypes: ["image"],
    browseClass: "btn btn-success",
    browseLabel: "Pick an image",
    browseIcon: "<i class=\"glyphicon glyphicon-picture\"></i> ",
    removeClass: "btn btn-danger",
    removeLabel: "Delete",
    removeIcon: "<i class=\"glyphicon glyphicon-trash\"></i> ",
    msgPlaceholder:"Seleziona al massimo 20 immagini",
    fileActionSettings:{showUpload:false},
    browseOnZoneClick: true,
    dropZoneTitle:"Carica qui le tue immagini"+
    "<br> La prima immagine sarà la "+
    "copertina del progetto",
    dropZoneClickTitle:"",
    minFileCount: 1,
    msgFilesTooLess:"Carica almeno un' immagine da usare come anteprima del progetto."
  });
}

*/
