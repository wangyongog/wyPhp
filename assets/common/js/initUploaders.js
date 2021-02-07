var uploaders = {
	initUploaders : function(){
		var uploaderArr = [];
		$(".browse_button").each(function() {
            self = $(this);
			//是否多图
			var multi_type = self.data('upload-multi') || '';
            var browse_button_id = self.attr('id'),
			base = self.data('base-url'),
			upload_url = self.data('upload-url'),
			max_size = self.data('max-size'),
			file_extensions = self.data('extensions'),
			
			input = $('input[name="'+browse_button_id+'"]'),
			process = self.siblings('.process'),
			preview = self.siblings('.preview');
            var flash_swf_url = '../plupload/js/Moxie.swf',
            silverlight_xap_url = '../plupload/js/Moxie.xap';

            var uploader = new plupload.Uploader({
				runtimes: 'html5,flash,silverlight,html4',
				browse_button: browse_button_id,
				url: upload_url,
				flash_swf_url: flash_swf_url,
				silverlight_xap_url: silverlight_xap_url,

				filters: {
					max_file_size: max_size || '2mb',
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
							var str = '<div id="' + file.id + '"><b></b>'
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
							if(responseJson.status ==1){
								if(multi_type == ''){
									//input.val(responseJson.path);
									var str = '<div class="file-item">'+
												'<input name="files[]" type="hidden" value="'+responseJson.path+'">'+
												'<img style="width:120px;height:100px" class="img-thumbnail" src="'+responseJson.url+'"/>'+
											'</div>'
									preview.html(str);
								}else{
									var str = '<div class="file-item">'+
												'<input name="files[]" type="hidden" value="'+responseJson.path+'">'+
												'<img style="width:120px;height:100px" class="img-thumbnail" src="'+responseJson.url+'"/>'+
												'<a href="javascript:;" class="close-upimg"></a>'+
											'</div>'
									preview.append(str);
								}
							}
						}
                    },
					Error:function(up,errObject){
					   var errcode=errObject.code;
					   if(errcode==-600 ){
						   adminJs.bootstrap_alert(errObject.file.name+"文件大小已超过"+max_size+",请重新选择上传");
					   }else if( errcode==-601 ){
						   adminJs.bootstrap_alert(errObject.file.name+"文件格式错误,请选择"+file_extensions+"格式的文件后重新上传");
					   }else{
						   adminJs.bootstrap_alert("服务器错误");
					   }
					}
                }
            });

            uploader.init();
            uploaderArr.push(uploader);
        });
	}
}