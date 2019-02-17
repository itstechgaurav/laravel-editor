var cacheName = 'v2'; 

// Default files to always cache
var cacheFiles = [
	'./css/app.css',
    './js/app.js',
    'https://fonts.googleapis.com/css?family=Fira+Mono'
]


self.addEventListener('install', function(e) {

    // e.waitUntil Delays the event until the Promise is resolved
    e.waitUntil(

    	// Open the cache
	    caches.open(cacheName).then(function(cache) {

	    	// Add all the default files to the cache
			return cache.addAll(cacheFiles);
	    })
	); // end e.waitUntil
});


self.addEventListener('activate', function(e) {

    e.waitUntil(

    	// Get all the cache keys (cacheName)
		caches.keys().then(function(cacheNames) {
			return Promise.all(cacheNames.map(function(thisCacheName) {

				// If a cached item is saved under a previous cacheName
				if (thisCacheName !== cacheName) {

					// Delete that cached file
					return caches.delete(thisCacheName);
				}
			}));
		})
	); // end e.waitUntil

});


self.addEventListener('fetch', function(e) {
	e.respondWith(
		caches.match(e.request)
			.then(function(response) {
				if ( response ) {
					return response;
				}
				var requestClone = e.request.clone();
				return fetch(requestClone)
					.then(function(response) {

						if ( !response ) {
							return response;
						}
						if(['css', 'js', 'json', 'png', 'jpg', 'jpeg', 'svg', 'ico'].includes(e.request.url.split('.')[e.request.url.split('.').length - 1])) {
                            var responseClone = response.clone();
                            caches.open(cacheName).then(function(cache) {
                                cache.put(e.request, responseClone);
                                return response;
                
                            }); 
                        } else {
                            return response;
                        }

					})
					.catch(function(err) {
						console.log('[ServiceWorker] Error Fetching & Caching New Data', err);
					});
			})
	);
});