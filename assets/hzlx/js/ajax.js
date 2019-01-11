var ajax = {
	post_ajax:function(url,data){
		
	},
	post_loading:function(url,data){
		$.ajax({
			type:'POST',
			dataType:'json',
			url:url+'?t='+(new Date().getTime()),
			data:data,
			success:function(data){
				if(data.html.tbody_data && typeof data.html.tbody_data !='undefined'){
					$('.newslist').html(data.html.tbody_data);
					$('.pages').html(data.html.pagin);
				}
					
			},complete:function(XMLHttpRequest, textStatus){

			},beforeSend:function(){
				
			},error:function(){
				
			}
		});
	}
}
$(function () {
	$('#postxq').on('click',function(){
		var self = $(this);
		$('.Error').html('');
		$.ajax({
			type:'POST',
			dataType:'json',
			url:$('#form1').attr('action')+'?t='+(new Date().getTime()),
			data:$('#form1').serialize(),
			success:function(data){
				if(data.status==1){
					$('#prerest').click();
					alert('领取成功！');
					return;
				}else{
					$('.Error').html(data.msg);
				}
			},complete:function(XMLHttpRequest, textStatus){
				self.html('免费领取考试秘笈');
			},beforeSend:function(){
				self.html('领取中...');
			},error:function(){
				
			}
		});
	});
	$('.postReply').on('click',function(){
		var self = $(this);
		$('.Ereply').html('');
		$.ajax({
			type:'POST',
			dataType:'json',
			url:$('#form2').attr('action')+'?t='+(new Date().getTime()),
			data:$('#form2').serialize(),
			success:function(data){
				if(data.status==1){
					$('#onresets').click();
					alert('提交成功！');
					return;
				}else{
					$('.Ereply').html(data.msg);
				}
			},complete:function(XMLHttpRequest, textStatus){
				self.attr('disabled',false);
				self.html('提交留言');
			},beforeSend:function(){
				self.attr('disabled',true);
				self.html('提交中...');
			},error:function(){
				
			}
		});
	});
	
});