// https://deanhume.com/Home/BlogPost/lazy-loading-images-using-intersection-observer/10163

(function() {

  // Get all of the videos that are marked up to lazy load
  let videos = Array.from(document.querySelectorAll('.js-lazy-video'));
  const config = {
    // If the video gets within 50px in the Y axis, start the download.
    rootMargin: '1500px 0px',
    threshold: 0.01
  };

  let videoCount = videos.length;
  let observer;

  // If we don't have support for intersection observer, loads the videos immediately
  if (!('IntersectionObserver' in window)) {
    videos.forEach(video => loadVideo(video));
  } else {
    // It is supported, load the images
    observer = new IntersectionObserver(onIntersection, config);
    videos.forEach(video => {
      if (video.classList.contains('js-lazy-video--handled')) {
        return;
      }

      observer.observe(video);
    });
  }

  /**
   * Loads the video
   * @param {object} video
   */
  function loadVideo(video) {
    const src = video.dataset.src;
    if (!src) {
      return;
    }

    video.classList.add('js-lazy-video--handled');
    video.classList.add('fade-in');
    video.src = src;
    return;
  }

  /**
   * Load all of the videos immediately
   * @param {array} videos
   */
  function loadVideosImmediately(videos) {
    videos.forEach(video => loadVideo(video));
  }

  /**
   * Disconnect the observer
   */
  function disconnect() {
    if (!observer) {
      return;
    }

    observer.disconnect();
  }

  /**
   * On intersection
   * @param {array} entries
   */
  function onIntersection(entries) {
    // Disconnect if we've already loaded all of the videos
    if (videoCount === 0) {
      observer.disconnect();
    }

    // Loop through the entries
    entries.forEach(entry => {
      // Are we in viewport?
      if (entry.intersectionRatio > 0) {
        videoCount--;

        // Stop watching and load the video
        observer.unobserve(entry.target);
        loadVideo(entry.target);
      }
    });
  }

})();
