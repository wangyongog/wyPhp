var Ajax = {
	page:1,
	ajaxPost:function(url,data,sync){
        var sync = sync || 'yes';
		var url = url.indexOf('?') == -1 ? url+'?' : url+'&';
        if(sync == 'yes'){
            $.ajax({
                type:'POST',
                url:url+'t='+(new Date().getTime()),
                data:data,
                success:function(data){
                    Ajax.responseLoading(data);
                },complete:function(XMLHttpRequest, textStatus){
				
				},beforeSend:function(){
				},error:function(){
					alert('服务器异常，请联系管理员',2);return ;
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
			
        }
    },
	 
}
$(function () {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
});
