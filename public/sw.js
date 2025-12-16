const CACHE_NAME = 'taskify-cache-v1';
const STATIC_ASSETS = [
  '/favicon.ico',
  '/icon.png'
];

// Skip caching for authenticated routes
const SKIP_CACHE_PATHS = [
  '/dashboard',
  '/tasks',
  '/team',
  '/calendar',
  '/analytics',
  '/profile'
];

self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME).then(cache => {
      // Only cache static assets, skip routes that need auth
      return cache.addAll(STATIC_ASSETS).catch(err => {
        console.log('Cache install error:', err);
      });
    })
  );
  self.skipWaiting();
});

self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(keys =>
      Promise.all(
        keys.map(key => {
          if (key !== CACHE_NAME) {
            return caches.delete(key);
          }
        })
      )
    )
  );
  return self.clients.claim();
});

self.addEventListener('fetch', event => {
  const { request } = event;
  const url = new URL(request.url);

  // Skip non-GET requests
  if (request.method !== 'GET') {
    return;
  }

  // Skip caching for authenticated routes
  if (SKIP_CACHE_PATHS.some(path => url.pathname.startsWith(path))) {
    return;
  }

  // Skip caching for API routes
  if (url.pathname.startsWith('/api/')) {
    return;
  }

  // Only cache static assets (images, CSS, JS, fonts, etc.)
  const isStaticAsset = /\.(jpg|jpeg|png|gif|svg|ico|css|js|woff|woff2|ttf|eot)$/i.test(url.pathname) ||
                        url.pathname === '/manifest.webmanifest' ||
                        url.pathname === '/sw.js';

  if (!isStaticAsset) {
    return;
  }

  event.respondWith(
    caches.match(request).then(response => {
      if (response) {
        return response;
      }

      return fetch(request, {
        redirect: 'follow'
      }).then(response => {
        // Don't cache if not a valid response
        if (!response || response.status !== 200 || response.type !== 'basic') {
          return response;
        }

        // Clone the response
        const responseToCache = response.clone();

        caches.open(CACHE_NAME).then(cache => {
          cache.put(request, responseToCache);
        });

        return response;
      }).catch(error => {
        console.log('Fetch failed:', error);
        throw error;
      });
    })
  );
});


