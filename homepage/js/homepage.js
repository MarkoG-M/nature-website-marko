const videos = [
    "videos/video4.mp4",
    "videos/video2.mp4",
    "videos/video3.mp4",
    "videos/video5.mp4",
    "videos/video7.mp4"
];

const videoElement = document.getElementById('landing-video');
let currentVideoIndex = 0;


function playNextVideo() {
    currentVideoIndex = (currentVideoIndex + 1) % videos.length;
    videoElement.src = videos[currentVideoIndex];
    videoElement.play();
}

videoElement.src = videos[currentVideoIndex];
videoElement.play();

videoElement.addEventListener('ended', playNextVideo);