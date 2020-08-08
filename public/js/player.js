let player = videojs('video')

var videoLogged = false

player.on('timeupdate', () => {
    var percentage = Math.ceil(player.currentTime() / player.duration() * 100);

    if(percentage > 5 && !videoLogged) {
        axios.put(`/video/${window.CURRENT_VIDEO}`)

        videoLogged = true
    }
})
