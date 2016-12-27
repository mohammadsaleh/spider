$(document).ready(function(){
    $('.creload').on('click', function() {
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
