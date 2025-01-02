importScripts("https://js.pusher.com/beams/service-worker.js");
self.addEventListener('fetch', function(event) {
    console.log(event.request);
  });