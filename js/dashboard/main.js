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

(function($) {

  // Configure tooltips for collapsed side navigation
  $('.navbar-sidenav [data-toggle="tooltip"]').tooltip({
    template: '<div class="tooltip navbar-sidenav-tooltip" role="tooltip" style="pointer-events: none;"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
  })
  // Toggle the side navigation
  $("#sidenavToggler").click(function(e) {
    e.preventDefault();
    $("body").toggleClass("sidenav-toggled");
    $(".navbar-sidenav .nav-link-collapse").addClass("collapsed");
    $(".navbar-sidenav .sidenav-second-level, .navbar-sidenav .sidenav-third-level").removeClass("show");
  });
  // Force the toggled class to be removed when a collapsible nav link is clicked
  $(".navbar-sidenav .nav-link-collapse").click(function(e) {
    e.preventDefault();
    $("body").removeClass("sidenav-toggled");
  });
  // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
  $('body.fixed-nav .navbar-sidenav, body.fixed-nav .sidenav-toggler, body.fixed-nav .navbar-collapse').on('mousewheel DOMMouseScroll', function(e) {
    var e0 = e.originalEvent,
      delta = e0.wheelDelta || -e0.detail;
    this.scrollTop += (delta < 0 ? 1 : -1) * 30;
    e.preventDefault();
  });
  // Scroll to top button appear
  $(document).scroll(function() {
    var scrollDistance = $(this).scrollTop();
    if (scrollDistance > 100) {
      $('.scroll-to-top').fadeIn();
    } else {
      $('.scroll-to-top').fadeOut();
    }
  });
  // Configure tooltips globally
  $('[data-toggle="tooltip"]').tooltip()
  // Smooth scrolling using jQuery easing
  $(document).on('click', 'a.scroll-to-top', function(event) {
    var $anchor = $(this);
    $('html, body').stop().animate({
      scrollTop: ($($anchor.attr('href')).offset().top)
    }, 1000, 'easeInOutExpo');
    event.preventDefault();
  });



  /**
  *
  * Modal
  */
  $(function(){
    $("#frontimg").fileinput({
      showUpload: false,
      allowedFileExtensions: ["jpg", "jpeg", "gif", "png"],
      elErrorContainer: "#errorBlock",
      uploadUrl: "/api/projects/create_project.php",
      fileActionSettings: {
        showUpload: false,
        showZoom: false,
        removeClass: "btn btn-primary",
        removeLabel: "Delete",
        removeIcon: "<i class=\"fa fa-trash\"></i> ",
      },
      browseOnZoneClick:true,
      uploadExtraData: function (previewId, index) {
        let data = {
          JWT_token: Cookies.get("JWT_token"),
          title: $('#pjtitle').val().trim()
        }
        return data;
      }
    });


    /**
    * @event create_project
    */
    $("#createpj").click(function(){

      $('#errorBlock').html("").hide();

      let title = $('#pjtitle').val().trim();

      if(!title || title == "") {
        $('#errorBlock').html('<i class="fa fa-exclamation-circle"></i>' + " Inserire un titolo!").show();
        return;
      }

      if(!$('#frontimg').val()) {
        $('#errorBlock').html('<i class="fa fa-exclamation-circle"></i>' + " Inserire un immagine!").show();
        return;
      }

      $("#frontimg").fileinput("upload");
    });

    $('#frontimg').on('fileuploaded', function(event, data, previewId, index) {
      var form = data.form, files = data.files, extra = data.extra,
          response = data.response, reader = data.reader;

      if(response){
        window.location = "edit-project.php?url=" + response.Url;
      }

      $('#frontimg').fileinput('reset');
    });
  })
})(jQuery); // End of use strict
