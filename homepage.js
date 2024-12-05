const videos = [
    "videos/video2.mp4",
    "videos/video3.mp4",
    "videos/video4.mp4",
    "videos/video5.mp4",
    "videos/video6.mp4",
    "videos/video7.mp4"
];

const videoElement = document.getElementById('landing-video');
let currentVideoIndex = 0;

// Funktion, um das nächste Video zu laden
function playNextVideo() {
    currentVideoIndex = (currentVideoIndex + 1) % videos.length; // Loopt zurück zum ersten Video
    videoElement.src = videos[currentVideoIndex];
    videoElement.play();
}

// Starte das erste Video
videoElement.src = videos[currentVideoIndex];
videoElement.play();

// Event-Listener für das Ende eines Videos
videoElement.addEventListener('ended', playNextVideo);