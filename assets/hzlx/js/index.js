function countUp(elem, endVal, startVal, duration, decimal) {
    var startTime = 0;
    var dec = Math.pow(10, decimal);
    var progress, value;

    function startCount(timestamp) {
        //console.log(timestamp)
        startTime = !startTime ? timestamp : startTime;
        progress = timestamp - startTime;
        value = startVal + (endVal - startVal) * (progress / duration);
        value = (value > endVal) ? endVal : value;
        value = Math.floor(value * dec) / dec;
        elem.innerHTML = value.toFixed(decimal);
        progress < duration && requestAnimationFrame(startCount)
    }
    requestAnimationFrame(startCount)
}
var b1 = $('.b1')[0];
var b2 = $('.b2')[0];
var b3 = $('.b3')[0];
var b4 = $('.b4')[0];
var b5 = $('.b5')[0];

var arr1 = config.nums[0];
var arr2 = config.nums[1];
var arr3 = config.nums[2];
var arr4 = config.nums[3];
var arr5 = config.nums[4];


var start = null;

function step(timestamp) {
    if (!start) start = timestamp;
    var progress = timestamp - start;
    if (progress < 2000) {
        window.requestAnimationFrame(step);
    }
}

window.requestAnimationFrame(step);
var pall = false;
$(document).ready(function () {
    $(window).scroll(function () {
        if (pall == false) {
            var a = document.getElementById("eq").offsetTop;
            if (a >= $(window).scrollTop() && a < ($(window).scrollTop() + $(window).height())) {
                countUp(b1, arr1, 0, 2000, 0);
                countUp(b2, arr2, 0, 2000, 0);
                countUp(b3, arr3, 0, 2000, 0);
                countUp(b4, arr4, 0, 2000, 0);
                countUp(b5, arr5, 0, 2000, 0);
                pall = true;
            }
        }  
    });
});
 // 控制字数
 $('.conlist-zjly-list dd span:nth-of-type(1)').each(function () {
    var maxwidth = 25;
    if ($(this).text().length > maxwidth) {
        $(this).text($(this).text().substring(0, maxwidth));
        $(this).html($(this).html() + "....");
    }
});
$('.advatg-txt').each(function () {
    var maxwidth = 41;
    if ($(this).text().length > maxwidth) {
        $(this).text($(this).text().substring(0, maxwidth));
        $(this).html($(this).html() + "....");
    }
});