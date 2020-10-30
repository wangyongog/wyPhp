var layars = null;
var dailogAjax = {
	dailogPost:function(url,formObj,dialog){
		var formObj = formObj || $('form');
		var ex = url.indexOf('?') == -1 ? '?' : '&';
		$.ajax({
			type:'POST',
			enctype: 'multipart/form-data',
			dataType:'json',
			url:url+ex+'t='+(new Date().getTime()),
			data:formObj.serialize(),
			success:function(data){
				if(data.status == 1){
					parent.adminJs.dailogClose();
					if(data.msg){
						parent.adminJs.showMsg(data.msg,data.status );
					}
					setTimeout(function(){dailogAjax.dailogSuccess();},2000);
					
				}else{
					parent.adminJs.bootstrap_alert(data.msg);
				}
			},complete:function(XMLHttpRequest, textStatus){
				
			},beforeSend:function(){
				
			},error:function(){
				parent.adminJs.bootstrap_alert('服务器异常，请联系管理员!');
			}
		});
	}
	,
	dailogSuccess:function(){
		parent.$.learuntab.refreshTab();
		//parent.$(".main_iframe:visible")[0].contentWindow.location.reload();
	}
}

var formAjax = {
	ajaxPost:function(url,formObj){
		layars = layer.load(0,{shade:[0.2,'#fff'],time: 1000});
		setTimeout(function(){
            var formObj = formObj || $('form');
			var ex = url.indexOf('?') == -1 ? '?' : '&';
			$.ajax({
				type:'POST',
				enctype: 'multipart/form-data',
				dataType:'json',
				url:url+ex+'t='+(new Date().getTime()),
				data:formObj.serialize(),
				success:function(data){
					formAjax.runAjaxResSuccess(data);
				},complete:function(XMLHttpRequest, textStatus){
					layer.close(layars);
				},beforeSend:function(){
					
				},error:function(){
					$evt.showAlert('服务器异常，请联系管理员',2);return ;
				}
			});
        },1000);
	}
	,
	runAjaxResSuccess:function(data){
		if(data.status == 1){
			parent.layer.msg(
				data.msg,
				{icon:1,time:2000,shade:[0.2,'#fff']},
				function(index){
					var indexbox = parent.layer.getFrameIndex(window.name);
					if(indexbox){
						$evt.closeThis(indexbox);
						/*if(typeof parent.IframeCount =='undefined' ||(parent.IframeCount&&parent.IframeCount<=1)){
							if(data.url&&data.url!='javascript:history.back(-1);'){
								$evt.goUrl(data.url,parent);
							}else{
								parent.$.learuntab.refreshTab();
							}
						}*/
					}
					if(data.reload){
						parent.$.learuntab.refreshTab();
						return;
					}
					if(data.goback){
						$evt.goback();
						return;
					}
					if(data.url){
						$evt.goUrl(data.url,data.tab_name);
						return;
					}
					parent.adminJs.closeThis();
				}
			);
			return;
		}else{
			$evt.showAlert(data.msg,2);
			/*layer.alert(data.msg,{icon:2},
			function(index){
				//var indexBox=parent.layer.getFrameIndex(window.name);
				var indexBox = top.location!=self.location ? true : false;
				if(indexBox){
					if(data.url&&data.url!='javascript:history.back(-1);'){
						$evt.goUrl(data.url,parent);
					}
					//$evt.closeThis();
				}
				parent.layer.close(index);
				//layer.closeAll('loading');
			});*/
		}
	},
	tbodyLoading:function(page,inajax){
        if($("[data-name='tbody_data']").length < 1){
            return false;
        }
        if(typeof app == 'undefined'){
            return false;
        } 
		parent.adminJs.loading();
		var dataArr = app.split('_');
        var page = page || 1;
        var url = ('/'+dataArr[0]+'/'+dataArr[1]+dataArr[2]+'?inajax=1&page='+page);
		if($("#searchForm").attr('action') !='' && typeof $("#searchForm").attr('action') !='undefined'){
			url = $("#searchForm").attr('action');
			url = url.indexOf('?') == -1 ? '?page='+page : '&page='+page;
		}
		var data = $("#searchForm").serialize();
		setTimeout(function(){
            formAjax.dynamicLoading(url,data);
        },1000);
	},
	dynamicLoading:function(url,data,sync){
        var sync = sync || 'yes';
		var url = url.indexOf('?') == -1 ? url+'?' : url+'&';
        if(sync == 'yes'){
            $.ajax({
                type:'POST',
                dataType:'json',
                url:url+'t='+(new Date().getTime()),
                data:data,
                success:function(data){
                    //var data = eval("("+data+")");
                    formAjax.responseLoading(data);
                },complete:function(XMLHttpRequest, textStatus){
					parent.adminJs.layer_close();
				},beforeSend:function(){
				},error:function(){
					parent.adminJs.showAlert('服务器异常，请联系管理员',2);return ;
				}
            });
        } else {
            $.ajax({
                type:'POST',
                url:url+'t='+(new Date().getTime())+'&jsoncallback=formAjax.responseLoading',
                data:data,
                dataType:'jsonp'
            });    
        }
        
    },
	/**
    * 返回装载值
    */
    responseLoading : function(data){
		var icon = data.status == 1 ? 1 : 2;
        if(data.method == 'write'){
            if(data.append){
                $.each(data.append,function(k,v){
                    if(!v){
                        return true;
                    }
                    $("[data-name='"+k+"']").append(v);
                });
            }

            if(data.remove){
                $.each(data.remove,function(k,v){
                    if(!v){
                        return true;
                    }
                    $("[data-name='"+k+"']").remove();
                });
            }

            if(data.html){
                $.each(data.html,function(k,v){
                    if(!v){
                        return true;
                    }
                    $("[data-name='"+k+"']").html(v);
                });
            }
            if(data.runFunction){                        
               // eval(''+data.runFunction+'('+data.data+');');    
				eval(''+data.runFunction+'("'+data.data+'");');
            }       
            if(data.runFunctionJson){  
                eval(data.runFunctionJson+"(data.data)");      
            }
        }else if(data.method == 'alert'){   // 仅提示一下
			if(data.msg){
				parent.adminJs.showMsg(data.msg,icon);
			}
            if(data.location){
				setTimeout(function(){window.location.href = data.location;},2000);
				return;
			}
			if(data.parent){
				setTimeout(function(){window.parent.location.href = data.parent;},2000);
				return;
			}
			if(data.reload){
				setTimeout(function(){parent.$.learuntab.refreshTab();},2000);
				return;
			}
            return false;
        }else if(data.method == 'iframe'){
			parent.adminJs.addframes(data.url,data.tab_name);
            return;
        }else if(data.method == 'alert1'){ // 系统提示
            if(data.msg){
				parent.adminJs.showAlert(data.msg,icon);
			}
        }
    },
	 
}
$(function () {
	formAjax.tbodyLoading();
});
