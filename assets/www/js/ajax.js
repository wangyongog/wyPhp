var formAjax = {
	ajaxPost:function(url,formObj){
		var layars=layer.load(0,{shade:[0.8,'#fff']});
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
				share.showAlert('服务器异常，请联系管理员',2);return ;
			}
		});
	}
	,
	runAjaxResSuccess:function(data){
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
	},
	tbodyLoading:function(page,inajax){
        if($("[data-name='tbody_data']").length < 1){
            return false;
        }
        if(typeof app == 'undefined'){
            return false;
        } 
		var layars=layer.load(0,{shade:[0.8,'#fff']});
		var dataArr = app.split('_');
        var page = page || 1;
        var url = ('/'+dataArr[0]+'/'+dataArr[1]+dataArr[2]+'?inajax=1&page='+page);
		if($("#searchForm").attr('action') !='' && typeof $("#searchForm").attr('action') !='undefined'){
			url = $("#searchForm").attr('action');
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
                url:url+'t='+(new Date().getTime()),
                data:data,
                success:function(data){
                    //var data = eval("("+data+")");
					//console.log(data);
                    formAjax.responseLoading(data);
				return ;
                },complete:function(XMLHttpRequest, textStatus){
					share.closeAllf();
				},beforeSend:function(){
				},error:function(){
					share.showAlert('服务器异常，请联系管理员',2);return ;
				}
            });
        } else {
            $.ajax({
                type:'POST',
                url:url+'t='+(new Date().getTime())+'&jsoncallback=nfAdminAJax.responseLoading',
                data:data,
                dataType:'jsonp'
            });    
        }
        
    },
	/**
    * 返回装载值
    */
    responseLoading : function(data){
        if(data.method == 'write'){
            if(data.append){
                $.each(data.append,function(k,v){
                    if(!v){
                        return true;
                    }
                    //console.log(k,v);
                    //console.log($("[data-name='"+k+"']").length);
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
            if($('.ui-dialog-close').length==1){
                $('.ui-dialog-close').click();    
            }
            if(data.reload == 'ok'){
                if(data.reload_id == ""){
                    xrefresh(data.msg,data.page,data.searchurl);
                    
                }else{
                    if(data.reload_type == "append"){
                        $("#"+data.reload_id).append(data.reload_html);
                    }else{
                        $("#"+data.reload_id).html(data.reload_html);
                    }
                }
            }else{
                show_loading(data.msg,3000);
            }
            return false;    
        }else if(data.method == 'form'){
            adminBox.formBoxShow(data.form.title,data.form.content);
        }else if(data.method == 'dform'){  // 弹出层表单提交
            if(data.stats == 'ok'){
                show_loading(data.msg,3000);
                $('.ui-dialog-close').click();
                return false;    
            }else{
                show_loading(data.msg,3000);
                //alert('ikj');
                return true;
            }
            //alert('ikj');
        }else if(data.method == 'location'){ // 跳转url
            window.location.href = data.location;
            return false;
        }else if(data.method == 'parent'){ // 跳转url
            window.parent.location.href = data.location;
            return false;
        }else if(data.method == 'write2'){
            if(data.html){
                $.each(data.html,function(k,v){
                    if(!v){
                        return true;
                    }
                    $("[data-name='"+k+"']").html(v);
                });
            } 
            
            if($('.ui-dialog-close').length==1){
                $('.ui-dialog-close').click();    
            }
            
            //show_loading(data.msg,3000);
        }else if(data.method == 'alert2'){ // 系统提示
            if($('.ui-dialog-close').length==1){
                $('.ui-dialog-close').click();    
            }
            adminBox.alert2(data.msg);
            return false;
        }
    }
	 
}
$(function () {
	formAjax.tbodyLoading();
});
