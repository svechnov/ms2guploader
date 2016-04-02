typeof $.fn.sortable == 'function' || document.write('<script src="' + ms2guploaderConfig.vendorUrl + 'jquery-ui-sortable/jquery-ui-1.10.4.sortable.min.js"><\/script>');
typeof $.fn.ajaxForm == 'function' || document.write('<script src="' + ms2guploaderConfig.vendorUrl + 'jquery-form/jquery.form.js"><\/script>');
typeof $.fn.jGrowl == 'function' || document.write('<script src="' + ms2guploaderConfig.vendorUrl + 'jgrowl/jquery.jgrowl.min.js"><\/script>');
typeof $.fn.Plupload == 'function' || document.write('<script src="' + ms2guploaderConfig.vendorUrl + 'plupload/js/plupload.full.min.js"><\/script>');
typeof $.fn.Plupload == 'function' || document.write('<script src="' + ms2guploaderConfig.vendorUrl + 'plupload/js/i18n/ru.js"><\/script>');

var ms2guploader = {
    config : {
      actionUrl : ms2guploaderConfig.actionUrl
      ,assetsUrl : ms2guploaderConfig.assetsUrl
      ,vendorUrl : ms2guploaderConfig.vendorUrl
      ,locale: ms2guploaderConfig.cultureKey
      ,editor: ms2guploaderConfig.editor
	  ,formKey: $('#ms2guploaderFormKey').val()
    }
    ,selectors: {
      form: '#ms2guploader'
      , formKey: '#ms2guploaderFormKey'
      , file: '.ms2gu-file'
      , fileDelete: '.ms2gu-file-delete'
      , uploader: {
	        browse_button: 'ms2gu-files-select'
	        //, upload_button: document.getElementById('ms2gu-files-upload')
	        , container: 'ms2gu-files-container'
	        , filelist: 'ms2gu-files-list'
	        , progress: 'ms2gu-files-progress'
	        , progress_bar: 'ms2gu-files-progress-bar'
	        , progress_count: 'ms2gu-files-progress-count'
	        , progress_percent: 'ms2gu-files-progress-percent'
	        , drop_element: 'ms2gu-files-list'
      }
    }
	,sort: function(){


              var rank = {};
              $('#' + ms2guploader.selectors.uploader.filelist).find(ms2guploader.selectors.file).each(function(i){
                  rank[i] = $(this).data('id');
              });



              var data = {
                  action: 'gallery/sort'
                  , rank: rank
                  , form_key: ms2guploader.config.formKey
              };

              $.post(ms2guploader.config.actionUrl, data, function(response) {
                  if (!response.success) {
                      ms2guploader.message.error(response.message);
                  }
              }, 'json');


	}
    ,initialize: function(){
		var form = $(ms2guploader.selectors.form);
	    var pid = form.find('[name="pid"]').val();
	    var form_key = ms2guploader.config.formKey;

	  // Uploader
      ms2guploader.Uploader = new plupload.Uploader({
        runtimes: 'html5,flash,silverlight,html4',
        browse_button: ms2guploader.selectors.uploader.browse_button,
        container: ms2guploader.selectors.uploader.container,
        filelist: ms2guploader.selectors.uploader.filelist,
        progress: ms2guploader.selectors.uploader.progress,
        progress_bar: ms2guploader.selectors.uploader.progress_bar,
        progress_count: ms2guploader.selectors.uploader.progress_count,
        progress_percent: ms2guploader.selectors.uploader.progress_percent,
        drop_element: ms2guploader.selectors.uploader.drop_element,
        form: form,
        multipart_params: {
          action: $('#' + this.container).data('action') || 'gallery/upload',
          pid: pid,
          form_key: form_key
        },
        url: ms2guploader.config.actionUrl,
                flash_swf_url: ms2guploader.config.vendorUrl + 'lib/plupload/js/Moxie.swf',
				silverlight_xap_url: ms2guploader.config.vendorUrl + 'lib/plupload/js/Moxie.xap',
        init: {
          Init: function (up) {
		  	if (this.runtime == 'html5') {
              var element = $(this.settings.drop_element);
              element.addClass('droppable');
              element.on('dragover', function () {
                if (!element.hasClass('dragover')) {
                  element.addClass('dragover');
                }
              });
              element.on('dragleave drop', function () {
                element.removeClass('dragover');
              });
            }
          },
          PostInit: function (up) {},
          FilesAdded: function (up, files) {
            this.settings.form.find('[type="submit"]').attr('disabled', true);
            up.start();
          },
          UploadProgress: function (up, file) {
            //$(up.settings.browse_button).hide();
            $('#' + up.settings.progress).show();
            $('#' + up.settings.progress_count).text((up.total.uploaded + 1) + ' / ' + up.files.length);
            $('#' + up.settings.progress_percent).text(up.total.percent + '%');
            $('#' + up.settings.progress_bar).css('width', up.total.percent + '%');
          },
          FileUploaded: function (up, file, response) {
            response = $.parseJSON(response.response);
            if (response.success) {
              $('#' + up.settings.filelist + ' .note').hide();
              // Successfull action
              var files = $('#' + up.settings.filelist);
              var clearfix = files.find('.clearfix');
              if (clearfix.length != 0) {
                $(response.data.html).insertBefore(clearfix);
              } else {
                files.append(response.data.html);
              }
            } else {
              ms2guploader.message.error(response.message);
            }
          },
          UploadComplete: function (up, file, response) {
            //$(up.settings.browse_button).show();
            $('#' + up.settings.progress).hide();
            up.total.reset();
            up.splice();
            this.settings.form.find('[type="submit"]').attr('disabled', false);
          },
          Error: function (up, err) {
		  	 ms2guploader.message.error(err.message);
          }
        }
      });
      ms2guploader.Uploader.init();


      //Sort files
      $('#' + ms2guploader.selectors.uploader.filelist).sortable({
          items: ms2guploader.selectors.file+':not(.static)',
          update: function( event, ui ) {
              var rank = {};
              $('#' + ms2guploader.selectors.uploader.filelist).find(ms2guploader.selectors.file).each(function(i){
                  rank[i] = $(this).data('id');
              });

              var data = {
                  action: 'gallery/sort'
                  , rank: rank
                  , form_key: ms2guploader.config.formKey
              };

              $.post(ms2guploader.config.actionUrl, data, function(response) {
                  if (!response.success) {
                      ms2guploader.message.error(response.message);
                  }
              }, 'json');
          }
      });




      // Forms listeners
      $(document).on('click', ms2guploader.selectors.fileDelete, function (e) {
        e.preventDefault();

        var $this = $(this);
        var $form = $this.closest('form');
        var $parent = $this.closest(ms2guploader.selectors.file);
        var id = $parent.data('id');

        $.post(ms2guploader.config.actionUrl, {
          action: 'gallery/delete',
          id: id,
          form_key: form_key
        }, function (response, textStatus, jqXHR) {

          if (response.success) {
            $(ms2guploader.selectors.file + '[data-id="' + response.data.id + '"]').remove();
			ms2guploader.sort();
          }
          else {
            ms2guploader.message.error(response.message);
          }
        }, 'json');
        return false;
      });


    }
    ,form: null
    ,button: null

    ,message: {
      success: function (message) {
        if (message) {

          $.jGrowl(message, {theme: 'ms2gus-message-success'});
        }
      }
      ,error: function (message) {
        if (message) {
          $.jGrowl(message, {
            theme: 'ms2gus-message-error'
            //, sticky: true
          });
        }
      }
      ,info: function (message) {
        if (message) {
          $.jGrowl(message, {theme: 'ms2gus-message-info'});
        }
      }
      ,close: function () {
        $.jGrowl('close');
      }
    }
  };




$(document).ready(function(){
	ms2guploader.initialize();
});




 /*  ms2guploader.load(function() {
    ms2guploader.initialize();
  }); */


//todo-me delete this
/// window.ms2guploader = ms2guploader;



