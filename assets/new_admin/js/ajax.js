var formAjax = {
	ajaxPost : function(){
	},
	runAjaxResSuccess :function(data){
		if(data.status == 1){
			layer.msg(
				data.info,
				{icon:1,time:2000,shade:[0.8,'#fff']},
				function(index){
					var indexbox=parent.layer.getFrameIndex(window.name);
					if(indexbox){
						if(typeof parent.IframeCount =='undefined' ||(parent.IframeCount&&parent.IframeCount<=1)){
							if(data.url&&data.url!='javascript:history.back(-1);'){
								share.goUrl(data.url,parent);
							}else{
								parent.location.reload();
							}
						}
						share.closeThis();
					}else if(data.reload){
						window.location.reload();
					}
					layer.close(index);
				}
			);
			return;
		}else{
			layer.alert(data.info,{title:data.info,icon:2},
			function(index){
				var indexBox=parent.layer.getFrameIndex(window.name);
				if(indexBox){
					if(data.url&&data.url!='javascript:history.back(-1);'){
						share.goUrl(data.url,parent);
					}
					//share.closeThis();
				}
				layer.close(index);
				//layer.closeAll('loading');
			});
		}
	}
}
$(function () {
	//formAjax.tbodyLoading();
});
