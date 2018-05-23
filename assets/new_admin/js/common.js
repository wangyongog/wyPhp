var common = {
	onlive : function(){
		$('#formSubmit').on('click', function(){
			$('#searchForm').submit();
		});
		$('.box-body tbody').on('click','.tipClose', function(){
			var url = $(this).attr('_url');
			
			share.confirm_box('确定关闭此任务？',function(){
				//var layars=layer.load(0,{shade:[0.7,'#000']});
				$.ajax({
					type:'POST',
					dataType:'json',
					url:url+'&='+(new Date().getTime()),
					data:'',
					success:function(data){
						if(data.status == 1){
							layer.confirm(data.info, {
							  btn: ['确定'],
							  icon: 1,
							}, 
							function(){
								window.location.reload();
							},null
							);
							return;
						}else{
							share.showAlert(data.info ,2);
							return ;
						}
					},complete:function(XMLHttpRequest, textStatus){
						//layer.close(layars);
					},beforeSend:function(){
						
					},error:function(){
						share.showAlert('服务器异常，请联系管理员',2);return ;
					}
				});
			},null);
		})
	}
}
$(function () {
	common.onlive();
});
