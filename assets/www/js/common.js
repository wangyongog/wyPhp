$(".formModal1 .cha").on("click", function () {
	$('#Error_join').html('');
  $(".formModal1").fadeOut(200);
})

$(".formModal1 .Jpostjoin").on("click", function () {
  if(flag){
	flag = false;
	$('#Error_join').html('');
	$(this).html('提交中...');
	Ajax.ajaxPost('main/postJoin',$(this).parents('form').serialize());
}
  
});
function joinbackfun(data){
	flag = true;
	$('.Jpostjoin').html("立即加盟奶酪");
	if(data.status==1){
		$('.formModal1 .content').hide();
		$('.formModal1 .content1').show();
	}else{
		$('#Error_join').html(data.msg);
	}
}
var flag = true;
$('.Jcourse').on('click',function(){
	if(flag){
		flag = false;
		$('#Error_msg').html('');
		$(this).html('预约中...');
		Ajax.ajaxPost('main/postCourse',$(this).parents('form').serialize());
	}
});

function Coursebackfun(data){
	flag = true;
	$('.Jcourse').html("立即预约");
	if(data.status==1){
		$('.formModal .content').hide();
		$('.formModal .content1').show();
	}else{
		$('#Error_msg').html(data.msg);
	}
}
$(".zx").on("mouseenter", function() {
  $(".zxr").fadeIn(200);
})

$(".zxr").on("mouseleave", function() {
  $(".zxr").fadeOut(200);
})

$(".phone").on("mouseenter", function() {
  $(".phoner").fadeIn(200);
  $(".phoneimg").fadeIn(200);
})

$(".phoner").on("mouseleave", function() {
  $(".phoner").fadeOut(200);
  $(".phoneimg").fadeOut(200);
})

$(".weixin").on("mouseenter", function() {
  $(".weixinr").fadeIn(200);
  $(".weixinimg").fadeIn(200);
})

$(".weixinr").on("mouseleave", function() {
  $(".weixinr").fadeOut(200);
  $(".weixinimg").fadeOut(200);
})

$(".jm").on("mouseenter", function() {
  $(".jmr").fadeIn(200);
})

$(".jmr").on("mouseleave", function() {
  $(".jmr").fadeOut(200);
})

$(".totop").on("mouseenter", function() {
  $(".totopr").fadeIn(200);
})

$(".totopr").on("mouseleave", function() {
  $(".totopr").fadeOut(200);
})

$(".jmr").on("click", function() {
  $(".formModal1").fadeIn(200);
})

$(".zxr").on("click", function() {
  $(".formModal").fadeIn(200);
})

$(".formModal .cha").on("click", function() {
	$('#Error_msg').html('');
  $(".formModal").fadeOut(200);
})

$(window).scroll(function() {
  if ($(window).scrollTop() > 50) {
    $(".totop").fadeIn(200);
  } else {
    $(".totop").fadeOut(200);
  }
});

$(".totopr").click(function() {
  $('body,html').animate({
    scrollTop: 0
  },
  500);
  return false;
});
