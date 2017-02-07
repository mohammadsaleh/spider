$(document).ready(function(){
    function refreshCaptcha(){
        $('.creload').each(function () {
            $(this).trigger('click');
        })
        setTimeout(refreshCaptcha, captchaTimeout);
    }
    setTimeout(refreshCaptcha, captchaTimeout);
    $('html').on('click', '.creload', function() {
        var imageId = $(this).data('target');
        var mySrc = $(imageId).attr('src');
        var glue = '?';
        if(mySrc.indexOf('?')!=-1)  {
            glue = '&';
        }
        $(imageId).attr('src', mySrc + glue + new Date().getTime());
        return false;
    });
})
