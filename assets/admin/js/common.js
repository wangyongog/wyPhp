var adminJs = {
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
		  shade:noshade?0:[0.8,'#000'],
		  success: function(layero, index){
    		//console.log(layero, index);
			layer.setTop(layero);
  		  },
		  cancel: function(index, layero){ 
			  layer.close(index);	//只有当点击confirm框的确定时，该层才会关闭
			  return false; 
			}    
		});
	},
	closeThis:function (){
        var indexBox = parent.layer.getFrameIndex(window.name);
        parent.IframeCount--;
        parent.layer.close(indexBox);
    }
	,
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
	confirm_box:function(msg, confirmFUNC, cancelFUNC){
		layer.confirm(msg, {
		  btn: ['确定','取消'], //按钮
		  icon: 0,
		}, 
		confirmFUNC, 
		cancelFUNC
		);
	},
	goUrl:function(url,obj){obj=obj?obj:self;obj.location=url;},
	///tips层
	tipsObj:function(msg,obj){layer.tips(msg,obj,{tips:3});},
	//提示层
	msg:function(msg){
		layer.msg(msg);
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

function resize(resizeHandle){
	var d = document.documentElement;
	var timer;//避免resize触发多次,影响性能
	var width = d.clientWidth, height = d.clientHeight;
	$(top.window).on('resize',function(e){
		if((width != d.clientWidth || height != d.clientHeight)){
			width = d.clientWidth, height = d.clientHeight;
			if(timer){clearTimeout(timer);}
			timer = setTimeout(function(){
				resizeHandle();
			},10);	
		}
	});
	
}