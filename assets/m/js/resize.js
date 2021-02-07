$(function () {
  function setRem() {
    var deviceWidth = document.documentElement.clientWidth;
    var fontsize = null;
    if (deviceWidth > 800) {
      deviceWidth = 1366;
      fontsize = deviceWidth / 13.66 + 'px';
    } else {
      fontsize = deviceWidth / 7.5 + 'px';
    }
  
    document.documentElement.style.fontSize = fontsize;
  };
  setRem();

  $(function () {
      var timer;
      $(window).bind("resize",function () {
          clearTimeout(timer);
          timer=setTimeout(function () {
              setRem();
          },10)
      })
  });
})