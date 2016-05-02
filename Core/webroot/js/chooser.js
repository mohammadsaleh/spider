/**
 * Created by Mohammad Saleh on 8/24/2015.
 */
$(document).ready(function(){
    $('.link-chooser').on('click', function(e){
        e.preventDefault();
        var href = $(this).attr('href');
        var targetInput = $(this).data('target-input');
        var width = 1000;
        var height = 400;
        var left = (screen.width / 2)-(width / 2);
        var top = (screen.height / 2)-(height / 2);
        var menuWindowDialog = window.open(
            href,
            'Select Menu',
            'toolbar=no, location=no, directories=no, status=no, menubar=no' +
            ', scrollbars=no, resizable=no, copyhistory=no' +
            ', width=' + width + ', height=' + height + ', top=' + top + ', left=' + left
        );
        menuWindowDialog.opener.callback = function(href){
            $(targetInput).val(href);
            menuWindowDialog.close();
        };
    });
    $('.choose-item').on('click', function(e){
        e.preventDefault();
        var href = $(this).attr('href');
        window.opener.callback(href);
    })
})
