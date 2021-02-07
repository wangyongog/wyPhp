var share = {
	wait : 60,
	dialogObj:null,
	
	inArray: function(needle, haystack){
        var arrLen = haystack.length;
        for(var i = 0; i < arrLen; i++) {
            if(haystack[i] == needle) return true;
        }
        return false;
    },
	
	
	// 验证手机号码
    isPhone : function(phone){
        var mob=$.trim(phone);
        if($.trim(phone)=="" || !phone){
            return false;
        }
        if($.trim(phone)!=""){
            var reg = /^[1-9][0-9]{10}/;
            if(!reg.test(phone)){
                return false;
            }
        }

        return true;
    },
	isPhoneNew : function(phone){
		if(!/^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(17[0-9]{1}))+\d{8})$/.test(phone)){
			return false;
		}
		return true;
	}
	,
    disTime : function(o){
		var o = typeof(o) == 'undefined' || o == '' ? 'clear_code' : o;
        var evt = $('#'+o).find('a');
        if (share.wait == 0) {   
            evt.addClass('getyzm') ;           
            evt.html('获取验证码');
            share.wait = 60;
        } else { 
            evt.removeClass("getyzm"); 
            evt.html(share.wait+'秒获取验证码');
            share.wait--;
            setTimeout(function() {
                share.disTime(o)
                },
                1000)
        }
    }
	,
	isUsername : function(username,min,max){
        var username = $.trim(username);
        var min = min || 6;
        var max = max || 18;
        var len = username.length;
        if(!username){
            return false;
        }

        if(len <min || len >max){
            return false;
        }
        var reg = /^([0-9]|[a-z])+$/;
        if(!reg.test(username)){
            return false;
        }

        return true;
    },
	checkPassLength : function(password,min,max){
        var password = $.trim(password);
        var min = min || 6;
        var max = max || 20;
        if(password.length < 1){
            return false;
        }

        if(password.length<min || password.length>max){
            return false;
        }

        return true;
    },
	//判断正整数
	isNum : function(str){
		var reNum = /^[1-9]+[0-9]*]*$/;
  		return !reNum.test(str) ? false: true;
	},//判断大于0正数
	isNumZore : function(str){
		var reNum =  /^[0-9]+.?[0-9]*$/;
  		return !reNum.test(str) ? false: true;
	},
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

