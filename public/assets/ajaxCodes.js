

$(document).on('click', '#selectCue', function () {
    
    var id = $(this).val();

    $.ajax({
        type: 'GET',
        url: '/karaoke/song?cue=' + id,
        contentType: false,
        processData: false,
        success: function () {
            $("#playlistDiv").load(location.href + " #playlistDiv>*", ""); 

        }
    })
})