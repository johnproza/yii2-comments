$(document).ready(function () {
    $('#expires').blur(function () {
        let date = new Date($(this).val());
        $('#commentsban-expires').val(date.getTime()/1000);
        //console.log(date.getTime());
    })
})