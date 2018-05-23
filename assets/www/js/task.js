var Task = {
	live:function(){
		$('[data-name="tbody_data"').on('click','.tipClose',function(){
			var url = $(this).attr('_url');
			share.confirm_box('确定关闭此任务？',function(){
				var layars=layer.load(0,{shade:[0.8,'#CCC']});
				$.ajax({
					type:'POST',
					dataType:'json',
					url:url+'&='+(new Date().getTime()),
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
						share.showAlert('服务器异常，请联系管理员',2);return ;
					}
				});
			},null);
		});
		$('.searchForm').on('click',function(){
			formAjax.tbodyLoading();
		});
	}
}
$(function () {
	Task.live();
});
