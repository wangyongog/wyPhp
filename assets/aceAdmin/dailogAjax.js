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
					//dailogAlert.alerts(data.msg);
					dailogAjax.dailogSuccess(adminJs.dialog);
				}else{
					dailogAlert.alerts(data.msg);
				}
			},complete:function(XMLHttpRequest, textStatus){
				
			},beforeSend:function(){
				
			},error:function(){
				dailogAlert.alerts('服务器异常，请联系管理员!');
			}
		});
	}
	,
	dailogSuccess:function(dialog){
		dialog.close();
		window.location.reload();
	}
}
var dailogAlert = {
	alerts :function(msg){
		BootstrapDialog.show({ 
			type : BootstrapDialog.TYPE_DANGER,
			title : '提示', 
			message : msg, 
			size : BootstrapDialog.SIZE_SMALL,
			buttons : [{// 设置关闭按钮 
				label : '确定', 
				action : function(dialog) { 
					dialog.close();
				} 
			}],   
		});
	},
	tips :function(msg){
		
	}
	,
	confirms:function(msg,confirmFUNC, cancelFUNC){
		BootstrapDialog.show({  
            title: '提示',  
            message: msg,  
			type : BootstrapDialog.TYPE_DANGER,
            buttons: [{  
                label: '<i class="fa fa-close"></i> 取消',  
                action: function(dialog){  
				console.log(cancelFUNC)
					if(typeof cancelFUNC !='undefined'){
						cancelFUNC();
					}else{
						dialog.close();
					}
                }  
            }, {  
                label: '<i class="fa fa-check"></i> 确定',  
				cssClass: 'btn btn-primary',
                action: function(dialog){  
                    if(typeof confirmFUNC !='undefined'){
						confirmFUNC();
					}else{
						dialog.close();
					}  
                }  
            }]  
        });
	}
	
}

