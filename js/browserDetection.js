$(function(){
    isChrome = navigator.userAgent.toLowerCase().indexOf('chrome') > -1;
    isExplorer = navigator.userAgent.indexOf('MSIE') > -1;
    isFirefox = navigator.userAgent.indexOf('Firefox') > -1;
    isSafari = navigator.userAgent.indexOf("Safari") > -1;
    isOpera = navigator.userAgent.toLowerCase().indexOf("op") > -1;
    if ((isChrome)&&(isSafari)) {isSafari=false;}
    if ((isChrome)&&(isOpera)) {isChrome=false;}
})
