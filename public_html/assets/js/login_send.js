$(document).ready(function () {
    $("#loginform").submit(function (event) {
        event.preventDefault();
        var form = $("#loginform");
        $.ajax({
            type: 'POST',
            url: '/process.php',
            data: form.serialize() + "&" + $.param({'form-action': document.activeElement.getAttribute('value')}),
            dataType: 'json',
            success: function (data) {
                if ((data.status) === 'successful') {
                    $('#pwsuccessful .message').html(data.reason);
                    $('#pwsuccessful').show();
                    setTimeout(function () {
                        window.location.replace("/");
                    }, 1000);
                }
                else {
                    $('#pwfailure .message').html(data.reason);
                    $('#pwfailure').show();
                }
            }
        });
    });
});