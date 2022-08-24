import "alpinejs";

// 3840x800: laatst doorgekregen van Yasmin
window.clickROI = function() {
    return {
        originalSize: { width: 3840, height: 1080 },
        displaySize: { width: 3840 / 3, height: 1080 / 3 },
        showROIs: true,
        mousedown: false,

        rois: [],
        prevClicked: { x: 0, y: 0 },

        labelCurrentTime: "00:00:00",
        labelDuration: "00:00:00",

        playbackSpeed: 1,
        autoHideAnimation: true,

        prevTime: 0,
        parallelTimer: null,

        // init
        setROIs: function(rois) {
            this.rois = rois;
            this.$watch("playbackSpeed", value => {
                let video = this.$refs.video;
                video.playbackRate = value;
            });
        },

        moveScrub: function(e) {
            if (this.mousedown) {
                // this.scrub(e);
            }
        },

        scrub: function(e) {
            let video = this.$refs.video;
            let progress = this.$refs.progress;

            let scrubTime = (e.offsetX / progress.offsetWidth) * video.duration;
            // console.log(scrubTime);

            this.prevClicked = { x: 0, y: 0 };
            this.prevTime = scrubTime;
            video.currentTime = scrubTime;
        },

        rewind: function(seconds) {
            let video = this.$refs.video;
            let newTime =
                video.currentTime - seconds > 0
                    ? video.currentTime - seconds
                    : 0;

            this.prevClicked = { x: 0, y: 0 };
            this.prevTime = newTime;
            video.currentTime = newTime;
        },

        togglePlayPause: function() {
            if (!this.$refs.video.paused) {
                this.pause();
            } else {
                this.play();
            }
        },

        // TODO: when to trigger this?
        initTimes: function() {
            let video = this.$refs.video;
            this.labelDuration = new Date(video.duration * 1000)
                .toISOString()
                .substr(11, 8);
        },
        startParallelTimer: function() {
            this.parallelTimer = setInterval(() => {
                this.replayClickEffect();
            }, 20);
        },
        handleProgress: function() {
            let video = this.$refs.video;
            let progressBar = this.$refs.progressBar;
            let percent = (video.currentTime / video.duration) * 100;

            progressBar.style.flexBasis = `${percent}%`;

            this.labelCurrentTime = new Date(video.currentTime * 1000)
                .toISOString()
                .substr(11, 8);
            this.initTimes();
        },
        play: function() {
            this.$refs.video.play();
            this.startParallelTimer();
        },
        pause: function() {
            this.$refs.video.pause();
            clearInterval(this.parallelTimer);
        },
        clickedVideo: function(e, args) {
            let vid = this.$refs.video;
            let viewportOffset = vid.getBoundingClientRect();

            let time = Math.round(vid.currentTime * 100) / 100;
            let x =
                ((e.clientX - viewportOffset.left) * this.originalSize.width) /
                this.displaySize.width;
            let y =
                ((e.clientY - viewportOffset.top) * this.originalSize.height) /
                this.displaySize.height;

            this.prevClicked = { x, y };

            let type = "may_be_seen";
            if (e.shiftKey) {
                type = "must_be_seen";
            }

            // Add the data to the screen
            this.rois.unshift({ time, x, y, type });

            // Post the data
            let data = {
                videoIndex: args.index,
                time,
                x,
                y,
                type,
                _token: document.head.querySelector("meta[name=csrf-token]")
                    .content
            };

            fetch("/add", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
                .then(res => {
                    // console.log(res);
                })
                .catch(res => {
                    console.log(res);
                });

            // Animations
            e.preventDefault();
            this.clickEffect(e);
        },
        removeRoi: function(index, args) {
            if (args.isReplay) {
                alert("Niet mogelijk in replay modus");
                return;
            }

            let roi = this.rois[index];
            this.rois.splice(index, 1);

            let data = {
                ...roi,
                videoIndex: args.videoIndex,
                _token: document.head.querySelector("meta[name=csrf-token]")
                    .content
            };

            fetch("/remove", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
                .then(res => {
                    // console.log(res);
                })
                .catch(res => {
                    console.log(res);
                });
        },
        clickEffect: function(e) {
            var d = document.createElement("div");
            let c = "clickEffect";

            if (e.shiftKey) {
                c = c + " red";
            }

            if (!this.autoHideAnimation) {
                c = c + " noHide";
            }

            console.log(c);
            d.className = c;

            d.style.top = e.clientY + "px";
            d.style.left = e.clientX + "px";
            document.body.appendChild(d);

            if (this.autoHideAnimation) {
                d.addEventListener(
                    "animationend",
                    function() {
                        d.parentElement.removeChild(d);
                    }.bind(this)
                );
            }
        },
        hideAllAnimations: function() {
            document.querySelectorAll(".clickEffect").forEach(function(el) {
                el.parentElement.removeChild(el);
            });
        },
        replayClickEffect: function() {
            let video = this.$refs.video;
            let rois = JSON.parse(JSON.stringify(this.rois));

            // console.log(
            //     "showing points in interval",
            //     this.prevTime,
            //     video.currentTime,
            //     video.currentTime - this.prevTime
            // );

            let toShow = rois.filter(point => {
                return (
                    point.time > this.prevTime &&
                    point.time < video.currentTime &&
                    point.x != this.prevClicked.x &&
                    point.y != this.prevClicked.y
                );
            });

            let viewportOffset = video.getBoundingClientRect();

            toShow.forEach(p => {
                let clientX =
                    viewportOffset.left +
                    (p.x * this.displaySize.width) / this.originalSize.width;
                let clientY =
                    viewportOffset.top +
                    (p.y * this.displaySize.height) / this.originalSize.height;

                this.clickEffect({
                    clientX,
                    clientY,
                    shiftKey: p.type == "must_be_seen"
                });
            });

            this.prevTime = video.currentTime;
        }
    };
};
