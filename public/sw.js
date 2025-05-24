const cacheName = "blog-app-cache";
const filesToCache = [
    "/",
    "/offline.html",
    "/assets/images/logo.png",
    "/assets/images/logo-512x512.png",
    "/assets/css/style.css",
    "/assets/images/no_connection.png",
    "/assets/vendors/bootstrap/css/bootstrap.css",
    "/assets/vendors/bootstrap/js/bootstrap.bundle.min.js",
    "/assets/vendors/boxicons/css/boxicons.min.css",
];

self.addEventListener("install", function (event) {
    event.waitUntil(
        caches.open(cacheName).then(function (cache) {
            return cache.addAll(filesToCache);
        })
    );
});

self.addEventListener("activate", function (event) {
    event.waitUntil(
        caches.keys().then(function (keyList) {
            return Promise.all(
                keyList.map(function (key) {
                    if (key !== cacheName) {
                        return caches.delete(key);
                    }
                })
            );
        })
    );
});

self.addEventListener("fetch", function (event) {
    if (event.request.method !== "GET") return;

    event.respondWith(
        fetch(event.request)
            .then(function (response) {
                return response;
            })
            .catch(function () {
                return caches.open(cacheName).then(function (cache) {
                    if (event.request.mode === "navigate") {
                        return cache.match("/offline.html");
                    }
                    return cache.match(event.request);
                });
            })
    );
});
