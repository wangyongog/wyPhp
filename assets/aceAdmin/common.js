var adminJs = {
	dialog : null,
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
	showMsg:function(html){
		$('.page-content').html(html);
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

jQuery(function($) {
	/*$('.check-all').on('click',function () {
		$(".ids").prop("checked", this.checked);
	});*/
	//parent.document.getElementById('breadcrumbs').innerHTML;
	//alert(parent.document.getElementById('breadcrumbs').innerHTML);
	$('tbody').on('click','.ids',function () {
		var option = $(".ids");
		option.each(function (i) {
			if (!this.checked) {
				$(".check-all").prop("checked", false);
				return false;
			} else {
				$(".check-all").prop("checked", true);
			}
		});
	});
	$('tbody').on('click','.del',function(){
		var url = $(this).attr('_url');
		var msg = $(this).attr('_title') || '确定删除';
		adminJs.confirm_box(msg,function(){
			formAjax.ajaxPost(url);
		}); 
	});
	$('tbody').on('click','.edit',function(){
		var title = $(this).attr('_title') || '编辑';
		var url = $(this).attr('_url');
		var wh = $(this).attr('_wh') || '700,630';
		var whArr = typeof wh !='undefined' ? wh.split(',') : '';
		
		adminJs.showIframe(title, url,whArr[0],whArr[1]);
	});
	$('.page-content').on('click','.add',function(){
		var title = $(this).attr('_title') || '添加';
		var url = $(this).attr('_url');
		var wh = $(this).attr('_wh') || '700,630';
		var whArr = typeof wh !='undefined' ? wh.split(',') : '';
		adminJs.showIframe(title, url,whArr[0],whArr[1]);
	});
	$('.page-content').on('click','.show_dialog',function(){
		var title = $(this).attr('_title') || '添加';
		var url = $(this).attr('_url');
		var backFun = $(this).attr('backFun');
		adminJs.ShowDailog(title, url, backFun);
	});
	
	$('.searchForm').on('click',function(){
		formAjax.tbodyLoading();
	});
	$('.tiphands').on('click',function(){
		var url = $(this).attr('_url');
		var msg = $(this).attr('_msg');
		var ex = url.indexOf('?') == -1 ? '?' : '&';
		adminJs.confirm_box(msg,function(){
			var layars=layer.load(0,{shade:[0.8,'#CCC']});
			$.ajax({
				type:'POST',
				dataType:'json',
				url:url+ex+'t='+(new Date().getTime()),
				data:'',
				success:function(data){
					formAjax.runAjaxResSuccess(data);
					setTimeout(function(){
						formAjax.tbodyLoading();
					},3000);
					
				},complete:function(XMLHttpRequest, textStatus){
					layer.close(layars);
				},beforeSend:function(){
					
				},error:function(){
					adminJs.showAlert('服务器异常，请联系管理员',2);return ;
				}
			});
		},null);
	});
	$('[data-name="tbody_data"').on('change','.layui-textarea',function () {
		$.post($(this).attr('_url') ,{remark:$(this).val()},function(data){
			
		});
	});
	$('tbody').on('click','.tipClose',function(){
		var url = $(this).attr('_url');
		var msg = $(this).attr('_msg')
		var ex = url.indexOf('?') == -1 ? '?' : '&';
		adminJs.confirm_box(msg,function(){
			var layars=layer.load(0,{shade:[0.8,'#CCC']});
			$.ajax({
				type:'POST',
				dataType:'json',
				url:url+ex+'t='+(new Date().getTime()),
				data:'',
				success:function(data){
					formAjax.runAjaxResSuccess(data);
					setTimeout(function(){
						formAjax.tbodyLoading();
					},3000);
					
				},complete:function(XMLHttpRequest, textStatus){
					layer.close(layars);
				},beforeSend:function(){
					
				},error:function(){
					adminJs.showAlert('服务器异常，请联系管理员',2);return ;
				}
			});
		},null);
	});
	$('.tbody_del').on("click",function(){
		if($('.check-all:checked').length < 1){
			adminJs.showAlert('请选择删除选项');
			return false;
		}
		var data = [];
		$('.check-all:checked').each(function(){
			data.push($(this).val()); 
		});
		var btnObj = $(this);
		var key = btnObj.attr("data-param");
		var dataurl = btnObj.attr("_url");
		var data_str = key+"="+data.join(',');
		var url = createurl(dataurl);
		adminJs.confirm_box('删除提示');        
	});
	
	$('.show-details-btn').on('click', function(e) {
		e.preventDefault();
		$(this).closest('tr').next().toggleClass('open');
		$(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
	});
	
	$('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);
	var active_class = 'active';
	$('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
		var th_checked = this.checked;//checkbox inside "TH" table header
		
		$(this).closest('table').find('tbody > tr').each(function(){
			var row = this;
			if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
			else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
		});
	});
})