$(".menu .btn").on("click", function () {
  $(".menu ul").fadeIn(500);
  $(".black").fadeIn(500);
  $(this).addClass("active");
})

$(".black").on("click", function () {
  $(".menu ul").fadeOut(500);
  $(".black").fadeOut(500);
})

$(".footerbtn").on("click", function() {
  $(".jmModal").fadeIn(500);
})

$(".jmModal .close").on("click", function() {
  $(".jmModal").fadeOut(500);
})

$(".joinbtn").on("click", function() {
  $(".joinModal").fadeIn(500);
})

$(".joinModal .close").on("click", function() {
  $(".joinModal").fadeOut(500);
})

$(".team .item img").on("click", function() {

  $(".teacherModal .title").html($(this).attr('alt'));
  $(".teacherModal .description").html($(this).attr('_description'));
  $(".teacherModal img").attr("src",$(this).attr("src"));
  $(".teacherModal").fadeIn(500);
})

$(".teacherModal .close").on("click", function() {
  $(".teacherModal").fadeOut(500);
})

$(".teacher .item img").on("click", function() {

  $(".teacherModal .title").html($(this).attr('alt'));
  $(".teacherModal .description").html($(this).attr('_description'));
  $(".teacherModal img").attr("src",$(this).attr("src"));
  $(".teacherModal").fadeIn(500);
})

$(".teacherModal .closes").on("click", function() {
  $(".teacherModal").fadeOut(500);
})

$(".video0").on("click", function() {
  $(this).fadeOut(500)
  $(".video1").fadeIn(500);
})

$(window).scroll(function() {
  if ($(window).scrollTop() > 50) {
    $(".totop").fadeIn(200);
  } else {
    $(".totop").fadeOut(200);
  }
});

$(".totop").click(function() {
  $('body,html').animate({
    scrollTop: 0
  },
  500);
  return false;
});