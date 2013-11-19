(function(C2C, $) {
  var dropid = 'global-drop-overlay';

  C2C.PlUploadWrapper = {

    /**
     * TODO / notes:
     * - html5 runtime is currently only available for recent browsers, since other browser don't support multipart and image resizing
     * - silverlight runtime reoved, since it doesn't support exif yet, and html5+flash probably covers more than 99% of users
     * - add some server side work to enhance image quality?
     * - better behaviour for SVGs (eg enable chunking for file >2mB)
     * - use static url for swf file (but we then need crossdomain.xml file)
     */

    image_number: 0,
    pe: null,

    init: function(upload_url, backup_url, backup_js, i18n) {

      this.backup_url = backup_url;
      this.backup_js = backup_js;
      this.i18n = i18n;

      var uploader = new plupload.Uploader({
        runtimes: 'html5,flash', // rq: flash is not working well with FF (getFlashObj() null ?) but anyway, html5 is fine with firefox
        browse_button: 'pickfiles',
        container: 'container', // when using the body as container, flash shim is badly placed when scrolling, so we attach it to the modalbox
        drop_element: dropid,
        file_data_name: 'image_file',
        multipart: true,
        url: upload_url,
        flash_swf_url: '/static/js/plupload/plupload.flash.swf',
        filters: [{
          title: this.i18n.extensions,
          extensions: "jpeg,jpg,gif,png,svg"
        }],
        required_features: 'pngresize,jpgresize,progress,multipart' // a runtime that doesn't have all of these features will fail
      });

      uploader.bind('Init', function(up, params) {
        $('#pickfiles').prop('disabled', false);

        // drag&drop look&feel
        if (up.features.dragdrop) {
          $('#'+dropid).remove(); // be sure it is there only once
          var drop_overlay = $('<div id="'+dropid+'"><span>'+this.i18n.drop+'</span></div>').appendTo('body');

          plupload.addEvent(document, 'dragenter', function(e) {
            if ($('#modalbox').hasClass('in') && $('#image_upload').is(':visible')) {
              drop_overlay.addClass('active');
            }
          });

          plupload.addEvent(document, 'dragleave', function(e) {
            if (e.target.id == dropid || (e.target.offsetParent && e.target.offsetParent.id == dropid)) {
              drop_overlay.removeClass('active');
            }
          });
        }

        pe = setInterval(C2C.PlUploadWrapper.validateImageForms, 500);
      }, this);

      uploader.bind('Error', function(up, err) {
        switch(err.code) {
          // no available runtime with all desired features,
          // load needed js and redirect to backup upload system
          case plupload.INIT_ERROR:
            $.ajax({
              url: this.backup_js,
              dataType: 'script',
              cache: true
            }).done(function() {
              $.modalbox.show({
                remote: this.backup_url
              });
            });
            return;

          // file is with wrong extension, or too big (svg and gif files cannot be resized)
          case plupload.FILE_SIZE_ERROR:
          case plupload.FILE_EXTENSION_ERROR:
            this.displayError(err.file, this.i18n.badselect);
            break;

          // other errors
          default:
            this.displayError(err.file, this.i18n.unknownerror + ' (' + err.message + ')');
            break;
        }
        up.refresh(); // reposition Flash/Silverlight
      }, this);

      uploader.init();

      this.uploader = uploader;

      uploader.bind('BeforeUpload', function(up, file) {
        // increment image_number
        this.image_number++;

        var div = $('#'+file.id);
        div.find('b:first').html(this.i18n.sending);
        div.find('a:first').remove();

        up.settings.multipart_params = {
          plupload : true,
          image_number: this.image_number
        };

        // png and jpg images <2M will get resized only if they exceed c2c limits (8192x2048)
        // images >2M will be resized to max 4096x1024
        if (/\.(png|jpg|jpeg)$/i.test(file.name)) {
          if (file.size >= 2097152) {
            up.settings.resize = { width : 4096, height : 1024, quality : 90 };
          } else {
            up.settings.resize = { width : 8192, height : 2048, quality : 90 };
          }
        }
        // gif and svg are not resizable, prevent uploading too big files
        else if (/\.(gif|svg)$/i.test(file.name)) {
          up.settings.max_file_size = '2mb';
        }
      }, this);

      uploader.bind('FilesAdded', function(up, files) {
        var waiting = this.i18n.waiting;
        var cancel = this.i18n.cancel;

        $('#'+dropid).removeClass('active');

        $.each(files, function(i, file) {
          // do not display files that have been rejected
          if (file.status != plupload.FAILED) {
            $('#files_to_upload').prepend(
              $('<div id="'+file.id+'"/>')
                .append(
                  $('<div class="plupload_progress_bar"><div class="plupload_progress"></div></div>'),
                  $('<span class="plupload_text">'+file.name+' <b>'+waiting+'</b> </span>'),
                  $('<a/>', { href: '#', text: cancel, click: function() { C2C.PlUploadWrapper.cancelUpload(file.id); } })
                )
            );
          }
        });
        up.refresh();  // Reposition Flash/Silverlight
        window.setTimeout(function() {
          up.start();
        }, 500);
      }, this);

      // display upload progress
      uploader.bind('UploadProgress', function(up, file) {
        var div = $('#'+file.id);

        if (file.percent >= 95) {
          div.find('b:first').html(this.i18n.serverop);
        }

        div.find('.plupload_progress:first').width(file.percent);
      }, this);

      // show server response
      uploader.bind('FileUploaded', function(up, file, response) {
        $('.images_submit').show();
        $('#'+file.id).html(response.response)
          .find('.tmp-image-close').click(C2C.PlUploadWrapper.removeEntry);
      });
    },

    // function to display a self-formed error response
    displayError: function(file, errormsg) {
      $('#'+file.id).html($('<div class="image_upload_entry"></div>')
        .append(
          $('<span class="picto action_cancel tmp-image-close"></span>').click(C2C.PlUploadWrapper.removeEntry),
          document.createTextNode(file.name),
          $('<div class="global_form_error"><ul><li>'+errormsg+'</li></ul></div>'))
      );
    },

    removeEntry: function() {
      if (!cssAnimationSupported) {
        $(this).parent().remove();
      } else {
        $(this).parent().addClass('removed')
          .one('webkitAnimationEnd animationend', function(e) {
            $(this).remove();
          });
      }
    },

    cancelUpload: function(file) {
      this.uploader.removeFile(this.uploader.getFile(file));
      $('#'+file).remove();
    },

    // same function as in images_upload.js
    // used to validate with javascript that image information is correct
    // factorize? (is it worth it?)
    validateImageForms: function() {
      if (!$('#modalbox').hasClass('in')) { // means modalbox is closed
        clearInterval(pe);
        return null;
      }

      var images = $('.image_upload_entry input:first');
      var allow_submit = !!images.length;

      images.each(function() {
        var form_error = $(this).siblings('.image_form_error:first');
        if ($(this).val().replace(/^\s+|\s+$/g,"").length < 4) {
          if (!form_error.is(':visible')) {
            form_error.show();
          }
          allow_submit = false;
        } else {
          if (form_error.is(':visible')) {
            form_error.hide();
          }
        }
      });

      if (allow_submit) {
        $('.images_submit').prop('disabled', false);
      } else {
        $('.images_submit').prop('disabled', true);
      }
    }

  };

  // test if css animation and transforms are supported
  // (all browsers that support animation also support 2d transforms)
  function testCssAnimationAndTransforms() {
    var animation = false;
    var props = ['animationName', 'WebkitAnimationName', 'MozAnimationName'];
    var elt = $('div')[0];
    for (var i in props) {
      var prop = props[i];
      if (elt.style[prop] !== undefined) {
        animation = true;
        break;
      }
    }
    return animation;
  }

  var cssAnimationSupported = testCssAnimationAndTransforms();

})(window.C2C = window.C2C || {}, jQuery);
