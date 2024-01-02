

    $(document).ready(function() {
        $('#example').DataTable({
            order: [
                [0, 'desc']
            ],
            scrollCollapse: false,
            scrollY: '350px',
        });
    });

        var tag = document.createElement('script');

        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        var player;

        let url = YoutubeGetID(data)

        let videoUrl = data

        function onYouTubeIframeAPIReady() {
            player = new YT.Player('playersa', {
                height: '390',
                width: '640',
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
        
