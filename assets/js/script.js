$(document).ready(function () {
    $('#comments .icon.like, #comments .icon.dislike').click(function () {
        console.log($(this).attr('data-tydepe'));
    })


    let request = (form) =>{
        $.ajax({
            method : "POST",
            dataType: 'JSON',
            data : form.serialize(),
            url : form.attr('action'),

            beforeSend : function(xhr) {
                return xhr.setRequestHeader('X-PJAX','true'); // IMPORTANT
            },

            success : function (data) {
                console.log('good',data);
            },

            error : function (data) {
                console.log('errroe',data);
            }
        })
    }

    $('#comment-form').submit(function (event) {
        event.preventDefault();
        $.ajax({
            method : "POST",
            dataType: 'JSON',
            data : $(this).serialize(),
            url : $(this).attr('action'),

            beforeSend : function(xhr) {
                return xhr.setRequestHeader('X-PJAX','true'); // IMPORTANT
            },

            success : function (data) {
                console.log('good',data);
                $.pjax.reload('#comments');
            },

            error : function (data) {
                console.log('errroe',data);
            }
        })

        //console.log($(this).serialize())
        //request($(this));
        return false;
    })
})