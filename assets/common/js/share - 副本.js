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
	confirm_box : function (e,text, confirmFUNC, cancelFUNC,tips ,option) {
		var e = e || window.event;
		var alertdiv = '<div id="dialog-confirm" style="text-align:center"><p>'+text+'</p></div>';
		var tips = typeof(tips) != 'object' ? {} : tips ;
		var buttons = [];
		var option = typeof(option) != 'object' ? {} : option ;
		e.preventDefault();
        var title = title || '提示信息';
		if(typeof(tips.confirmTag) == 'undefined' ){
            tips.confirmTag = '确认';
        }
        if(typeof(tips.cancelTag) == 'undefined' && tips==null){
            tips.cancelTag = '取消';
        }
		title = "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-exclamation-triangle red'></i> "+title+"</h4></div>"
		var width = typeof option.width == 'undefined' ? 320 : option.width;
		var height = typeof option.height == 'undefined' ? 160 : option.height;
		
		if(typeof confirmFUNC != 'undefined' && confirmFUNC!=''){
			confirmFUNC = {text :tips.confirmTag,click:confirmFUNC,"class" : "btn btn-minier"} ;
			buttons.push(confirmFUNC);
		}
		if(typeof cancelFUNC != 'undefined' && cancelFUNC!=''){
			confirmFUNC = {text :tips.cancelTag,click:cancelFUNC,"class" : "btn btn-minier"} ;
			buttons.push(confirmFUNC);
		}
		$(document.body).append(alertdiv);
		return $('#dialog-confirm').dialog({
			width: width,
			resizable: false,
			title_html: true,
			height:height,
			title:title,
			modal: true,
			buttons:buttons
		}).show();
        
    },
	confirm_close :function(){
		$('#dialog-confirm').remove();
	}
	,
	alertMsg : function(text, confirmFUNC, cancelFUNC, tips, html, closeBut){
         tips = typeof(tips) != 'object' ? {} : tips ;
         if(typeof(tips.confirmTag) == 'undefined'){
            tips.confirmTag = '确认';
         }
         if(typeof(tips.cancelTag) == 'undefined'){
            tips.cancelTag = '取消';
         }
         var text=text.toString().replace(/\\/g,'\\').replace(/\n/g,'<br />').replace(/\r/g,'<br />'); 
         var options = '';
         if(confirmFUNC != null){
            if(cancelFUNC != null){                
               options += '<div class="dailog dailog-min"><div class="dailogCon"><div class="logo"></div><div class="ftc c333" style="padding-top:40px;"><p class="ft16">'+text+'</p> <div class="pt20 mt20"><a href="###" id="confirmTag" class="btn btn-red">'+tips.confirmTag+'</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="###" class="btn btn-gray" id="cancelTag">'+tips.cancelTag+'</a></div></div></div></div>';
            }else{
                options += '<div class="dailog dailog-min"><div class="dailogCon"><div class="logo"></div><div class="ftc c333" style="padding-top:40px;"><p class="ft16">'+text+'</p> <div class="pt20 mt20"><a href="###" id="confirmTag" class="btn btn-red">'+tips.confirmTag+'</a></div></div></div></div>';
            }  
          }else{
             var showClose = typeof closeBut != 'undefined' ? '<div class="wa_control"><a class="closeAert" href="javascript:;">×</a></div>' : '';
             options = typeof html != 'undefined' ? html : '<div class="dailog dailog-min"><div class="dailogCon"><div class="fl logo"></div>'+showClose+'<div class="ftc c333" style="padding-top:100px;"><p class="ft16">'+text+'</p> </div></div></div>';
         }
         var alertdiv = '<div id="alertdiv" class="hide" style="z-index:9999;">'+options+'</div>';
         $(document.body).append(alertdiv);
         $('#confirmTag').click(function(){                        
              confirmFUNC == null || confirmFUNC();
              share.closeAlertMsg();
			  return false;
         });
         $('#cancelTag').click(function(){
              cancelFUNC == null || cancelFUNC();
              share.closeAlertMsg();
			  return false;
         });
        $('.closeAert').click(function(){
            share.closeAlertMsg();
            return false;
        });
         this.center_box($('#alertdiv').get());   
         $(window).scroll(function(){
             share.center_box($('#alertdiv').get());
         });
         share.showAlertMsg();
    },
	center_box : function (obj){
        var ww = document.documentElement.clientWidth;
        var wh = document.documentElement.clientHeight;
        var ph = $(obj).height();
        var pw = $(obj).width();
        $(obj).css({
            "top":(wh-ph)/2+$(document).scrollTop(),
            "left":(ww-pw)/2
        });
    },
    closeAlertMsg : function(){
        $('#alertdiv').remove();
    },
	showAlertMsg : function(){
        $('#alertdiv').show();
    },
	closeDbox : function(){
        if(this.dialogObj !== null){
            $('.ui-dialog').css('opacity',0);
            this.dialogObj.close();        
        }
        if($('.ui-dialog').length > 0){
            $('.ui-dialog').remove();
        }
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
	}
};
