function getMessages() {
    $.ajax({
        method: "GET",
        url: "message/list",
    }).done(function(data) {
        $('#messagesList tbody').html('');
        var messages = data.messages;
        for(var i =0; i < messages.length; i++) {
            var message = messages[i];
            console.log(message);
            $('#messagesList tbody').append('<tr><td>' + message.created + '</td><td>' + message.message + '</td></tr>');
        };
    });
}
$(document).ready(function() {
    // Updating messages
//    setInterval(getMessages(), 3000);
    getMessages();
    
    $('#messageForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            method: "POST",
            url: "message/index",
            data: $('#messageForm').serialize()
        }).done(function() {
            getMessages();
        });
    });
});