$(document).ready(function () {
    $("#ponysurvey").submit(function (event) {
        event.preventDefault();
        var form = $("#ponysurvey");
        $.ajax({
            type: 'POST',
            url: '/process.php',
            data: form.serialize() + "&" + $.param({'form-action': document.activeElement.getAttribute('value')}),
            dataType: 'json',
            success: function (data) {
                if (data.status === 'successful') {
                    $('#submitord6').remove();
                    $('#successord7').show();
                    $('#submitpass').show();
                }
                else if (data.status === 'failure') {
                    alert(data.reason);
                    $('#submitfail').show();
                }
            },
            error: function (data) {

            }
        });
    });
});