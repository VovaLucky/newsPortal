function subscribe(text) {
    $('#Subscribe').addClass('hidden');
    $('#Unsubscribe').removeClass('hidden');
    $.post('/subscribe', {id : text});
}

function unSubscribe(text) {
    $('#Subscribe').removeClass('hidden');
    $('#Unsubscribe').addClass('hidden');
    $.post('/subscribe', {id : text});
}
