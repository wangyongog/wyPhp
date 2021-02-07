var adminJs = {
	dialog : null,
	layars:null,
	showIframe :function(title,url,w,h,noshade){
		w =w?w+"px":'';h=h?h+"px":'';
		if(!this.isPc()||((!w||w=='')&&(!h||h==''))){
			w='90%';h='90%';
		}
		var index = layer.open({
		  type: 2,
		  title:title,
		  area: [w,h],
		  fixed: true, //不固定
		  maxmin: false,
		  content: url,
		  closeBtn:1,
		  moveOut:true,
		  fix:false,
		  scrollbar:true,
		  maxmin: false,
		  shadeClose: true,
		  shade:noshade?0:[0.6,'#fff'],
		  success: function(layero, index){
			layer.setTop(layero);
  		  },
		  cancel: function(index, layero){ 
			  layer.close(index);	//只有当点击confirm框的确定时，该层才会关闭
			  return false; 
			}    
		});
	},
	ShowDailog:function(title,url,backFun) {
        adminJs.dialog = BootstrapDialog.show({
            title: title,
            type: BootstrapDialog.TYPE_PRIMARY,
            size: BootstrapDialog.SIZE_LARGE,
            cssClass: "fade",
            closeable: true,
            message: function (dialog) {
                var $message = $('<div></div>');
                var pageToLoad = dialog.getData('pageToLoad');
                $message.load(pageToLoad);
                return $message;
            },
            onshow: function(dialogRef){
            },
            data: {
                'pageToLoad': url,
            },
            buttons: [{
                label: '<i class="fa fa-close"></i> 取消',
                action: function (dialog) {
                    dialog.close();
                }
            }, {
                label: '<i class="fa fa-check"></i> 确定',
                cssClass: 'btn btn-primary',
                action: function (dialog) {
					//console.log(backFun)
					//eval(backFun+'()');
					//dailogAlert.confirms('sssssssss',function(){alert(1)},function(){alert(2)});
                	var formObj = $('.modal-body').find('form');
                	if(typeof backFun !='undefined'){
						eval(backFun+'("'+formObj.attr('action')+'","'+formObj+'")');
					}else{
						dailogAjax.dailogPost(formObj.attr('action'),formObj);
					}
                    //dialog.close();
                }
            }]
        });
	}
	,
	closeThis:function (indexBox){
        var indexBox = indexBox || layer.getFrameIndex(window.name);
        layer.close(indexBox);
    },
	//返回
	goback:function(step) {
		var step = step || -1;
		$(".main_iframe:visible")[0].contentWindow.history.go(step);
	},
	isPc:function(){
		var userAgentInfo=navigator.userAgent;
		var Agents=["Android","iPhone","SymbianOS","Windows Phone","iPad","iPod"];
		var flag=true;
		for(var v=0;v<Agents.length;v++){
			if(userAgentInfo.indexOf(Agents[v])>0){
				flag=false;break;
			}
		}
		return flag;
	},
	showAlert:function(msg,icnum){
		icnum = typeof icnum == 'undefined' ? 0 : icnum;
		layer.alert(msg,{icon: icnum,scrollbar: false});
		/*layer.open({
				  content: '浏览器滚动条已锁',
				  scrollbar: false
				});*/
	},
	bootstrap_alert :function(msg){
		BootstrapDialog.show({ 
			type : BootstrapDialog.TYPE_DANGER,
			title : '提示', 
			message : msg, 
			size : BootstrapDialog.SIZE_SMALL,
			buttons : [{// 设置关闭按钮 
				label : '确定', 
				action : function(dialog) { 
					adminJs.dailogClose(dialog);
				} 
			}],   
		});
	},
	loading:function(){
		adminJs.layars=layer.load(0,{shade:[0.2,'#fff']});
	},
	layer_close:function(){
		layer.close(adminJs.layars);
	},
	dailogClose:function(dialog){
		if(typeof dialog !='undefined'){
			dialog.close();
		}else{
			adminJs.dialog.close();
		}
	},
	//自定义
	bootstrap_confirms:function(msg,confirmFUNC, cancelFUNC){
		BootstrapDialog.show({  
            title: '提示',  
            message: msg,  
			type : BootstrapDialog.TYPE_DANGER,//TYPE_PRIMARY,TYPE_INFO,TYPE_SUCCESS,,TYPE_WARNING,TYPE_DANGER
            buttons: [{  
                label: '<i class="fa fa-close"></i> 取消',  
                action: function(dialog){  
				//console.log(cancelFUNC)
					if(typeof cancelFUNC !='undefined'){
						cancelFUNC();
					}else{
						adminJs.dailogClose(dialog);
					}
                }  
            }, {  
                label: '<i class="fa fa-check"></i> 确定',  
				cssClass: 'btn btn-primary',
                action: function(dialog){  
                	adminJs.dailogClose(dialog);
                    if(typeof confirmFUNC !='undefined'){
						confirmFUNC();
					}
                }  
            }]  
        });
	},
	///简单选择提示
	bootstrap_confirm:function(msg,confirmFUNC, cancelFUNC){
		BootstrapDialog.confirm({
            title: '提示',
            message: msg,
            type: BootstrapDialog.TYPE_PRIMARY,
            closable: true, 
            draggable: true,
            btnCancelLabel: '取消', 
			btnCancelClass: 'btn fa fa-close',
            btnOKLabel: '确定', 
            btnOKClass: ' btn fa fa-check btn-primary', 
            callback: function(result) {
                if(result) {
					if(typeof confirmFUNC !='undefined'){
						confirmFUNC();
					}
                }else {
					if(typeof cancelFUNC !='undefined'){
						cancelFUNC();
					}
                }
            }
        });
	},
	confirm_box:function(msg, confirmFUNC, cancelFUNC){
		layer.confirm(msg, {
		  btn: ['确定','取消'], //按钮
		  icon: 0,
		}, 
		confirmFUNC, 
		cancelFUNC
		);
	},
	///tips层
	tipsObj:function(msg,obj){layer.tips(msg,obj,{tips:3});},
	//提示层
	showMsg:function(msg,icon){
		var icon = icon || 0;
		layer.msg(msg,{icon:icon,time:2000,shade:[0.3,'#fff']});
	},
	closeAllf:function(){
		layer.closeAll(); //疯狂模式，关闭所有层
		/*layer.closeAll('dialog'); //关闭信息框
		layer.closeAll('page'); //关闭所有页面层
		layer.closeAll('iframe'); //关闭所有的iframe层
		layer.closeAll('loading'); //关闭加载层
		layer.closeAll('tips'); //关闭所有的tips层*/    
	},
};

