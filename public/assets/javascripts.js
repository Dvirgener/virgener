

//  ========================================= UNIT ACTIVITIES PAGE ================================================================= 


// Data table for Unit Activities
$(function() {
    $('#example2').DataTable({
        order: [
            [1, 'asc']
        ],
        scrollCollapse: false,
        scrollY: '450px',
    });
});
// Data table for Unit Activities

// search for activities on add SAA buttonc
$(document).on('submit', '#search_act', function (f) {

    f.preventDefault();
    var data = $(this).serialize;
    $.ajax({
        type: 'GET',
        url: '/spendingplan/addsaa',
        data:$(this).serialize(),
        success: function (response) {
            $("#resultTable").html(response);
            $("#resMe").load(location.href + " #resMe>*", ""); 

        }
    })
})
// search for activities on add SAA buttonc

// * Check all boxes
$(document).on('click', '#checkall', function () {
    $("#saa_adder input[type='checkbox'").prop('checked', this.checked);
})

// * Check to check atleast one checkbox
$(document).on('click', '.form-check-input', function () {
    var checkboxes = $('.form-check-input');
    checkboxes.change(function () {
        if ($('.form-check-input:checked').length > 0) {
            checkboxes.removeAttr('required');
        } else {
            checkboxes.attr('required', 'required');
        }
    });
});

// function view Saa Details
$(document).on('click', '.view_saa_but', function () {
    var saa_id = $(this).val();
    //ajax code    
    $.ajax({
        type: "GET",
        url: "/spendingplan/viewsaa?id=" + saa_id,
        // response code
        success: function (response) {
                $("#saa_view").html(response);
        }
        // response code
    })
    // ajax code
});
// function view Saa Details


// function Delete Saa Details
$(document).on('click', '.delete_saa_but', function () {

    var saa_id = $(this).val();
    //ajax code    
    $.ajax({
        type: "GET",
        url: "/spendingplan/deletesaa?id=" + saa_id,
        // response code
        success: function (response) {
                $("#saa_row").load(location.href + " #saa_row>*", ""); 
        }
        // response code
    })
    // ajax code
});
// function Delete Saa Details



//  ========================================= UNIT ACTIVITIES PAGE ================================================================= 




//  ========================================= KARAOKE PAGE ================================================================= 

// Data table for Song Playlist

$(function() {
    $('#example').DataTable({
        order: [
            [0, 'desc']
        ],
        scrollCollapse: false,
        scrollY: '350px',
    });
});
// Data table for Song Playlist

// Youtube API
        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
        var player;
        let url = YoutubeGetID(data)
        let videoUrl = data
        function onYouTubeIframeAPIReady() {
            player = new YT.Player('playersa', {
                height: '750',
                width: '1550',
                border: 2,
                videoId: url,
                playerVars: {
                    'autoplay': 1,
                },
                events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChange
                }
            });
        }
        function onPlayerReady(event) {
            event.target.playVideo();
        }
        function onPlayerStateChange(event) {
            if (event.data == YT.PlayerState.ENDED) {
                setInterval(2000);
                window.location.href = "/playlist";
            }
        }
        function YoutubeGetID(url) {
            var ID = "";
            url = url
                .replace(/(>|<)/gi, "")
                .split(/(vi\/|v=|\/v\/|youtu\.be\/|\/embed\/)/);
            if (url[2] !== undefined) {
                ID = url[2].split(/[^0-9a-z_\-]/i);
                ID = ID[0];
            } else {
                ID = url;
            }
            return ID;
        }
// Youtube API

// Live Search Function
$(function(){
    $("#live-search").keyup(function () {
        var input = $(this).val();
        if (input != "") {
            $.ajax({
                url: "/livesearch",
                method: "GET",
                data: { input: input },
                success: function (data) {
                    $("#searchResult").html(data);
                    $("#searchResult").css("display","block");
                }
            })
        } else {
            $("#searchResult").css("display","none");
        }
    })
})
// Live Search Function




//  ========================================= KARAOKE PAGE ================================================================= 



