
var uploaders = {
	initUploaders : function(){
		var uploaderArr = [];
		$(".browse_button").each(function() {
            self = $(this);
            var browse_button_id = self.attr('id'),
			base = self.attr('data-base-url'),
			upload_url = self.attr('data-upload-url'),
			max_size = self.attr('data-max-size'),
			file_extensions = self.attr('data-extensions'),
			
			input = self.siblings('input'),
			process = self.siblings('.process'),
			preview = self.siblings('.preview');
            var flash_swf_url = './plupload/Moxie.swf',
            silverlight_xap_url = './plupload/Moxie.xap';

            var uploader = new plupload.Uploader({
				runtimes: 'html5,flash,silverlight,html4',
				browse_button: browse_button_id,
				url: upload_url,
				flash_swf_url: flash_swf_url,
				silverlight_xap_url: silverlight_xap_url,

				filters: {
					max_file_size: max_size || '1mb',
					mime_types: [
						{title: "Image files", extensions: file_extensions}
					]
				},

                init: {
					
                    PostInit: function () {
                    },

                    FilesAdded: function (up, files) {
                        plupload.each(files, function(file) {
							//process.find('.filename').html(file.name + ', ');
                            //process.find('.filesize').html(plupload.formatSize(file.size) + ', ');
							var str = '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ')<b></b>'
							+'<div class="progress"><div class="progress-bar" style="width: 0%"></div></div>'
							+'</div>';
							process.find('.percent').html(str);
						});
                        up.start();
                    },

                    UploadProgress: function (up, file) {
                        var d = document.getElementById(file.id);
						d.getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
						var prog = d.getElementsByTagName('div')[0];
						var progBar = prog.getElementsByTagName('div')[0]
						progBar.style.width= 2*file.percent+'px';
						progBar.setAttribute('aria-valuenow', file.percent);
                    },

                    FileUploaded: function (up, file, result) {
						if (result.status == 200){
							var responseJson = JSON.parse(result.response);
							input.val(responseJson.fname);
                        	preview.children('img').attr('src', responseJson.furl);
						}
                    }
                }
            });

            uploader.init();
            uploaderArr.push(uploader);
        });
	}
}