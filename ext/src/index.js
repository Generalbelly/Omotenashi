function APP() {
    return {
        insertScript: function(src, d, cb) {
            let script = document.createElement('script');
            if (cb) script.onload = cb;
            if (src.includes('http')||src.includes('//')) {
                script.src = src
            } else {
                script.textContent = src;
            }
            d.appendChild(script);
        },
        insertStyleSheet: function(src, d) {
            let link = document.createElement('link');
            link.rel = "stylesheet";
            link.href = src;
            d.appendChild(link);
        },
        init: function(token, jsFilePath, cssFilePath, driverFilePath) {
            const el = document.querySelector('iframe#omotenashi');
            if (el) return;

            this.insertScript(driverFilePath, document.head);
            this.insertScript(`window.addEventListener('message', function(event) {
                console.log(event);
                if (event.data.activate) {
                    console.log('activate');
                }
            })`, document.body);

            const self = this;
            let iframe = document.createElement('iframe');
            iframe.allow = "fullscreen";
            iframe.style.zIndex = '2147483649';
            iframe.style.position = 'fixed';
            iframe.style.bottom = '0';
            iframe.style.right = '0';
            iframe.style.left = '0';
            iframe.style.width = '100%';
            iframe.id = 'omotenashi';
            iframe.onload = function () {
                const iframeBody = this.contentWindow.document.body;
                self.insertStyleSheet(cssFilePath, iframeBody);
                self.insertScript(`const _ot_ext_token = "${token}"`, iframeBody);
                self.insertScript(jsFilePath, iframeBody);
            };
            document.body.appendChild(iframe);
        }
    };
}

let app = null;

function sendMessage(message) {
    chrome.runtime.sendMessage(null, message);
}

function start(token, jsFilePath, cssFilePath, driverFilePath) {
    if (!app) {
        app = APP();
    }
    app.init(token, jsFilePath, cssFilePath, driverFilePath);
    sendMessage({
        status: 'done',
        app: 'Omotenashi'
    });
}

chrome.runtime.onMessage.addListener(function (request, sender, sendResponse) {
    if (request.app === "Omotenashi" && request.start && request.token) {
        start(request.token, request.jsFilePath, request.cssFilePath, request.driverFilePath);
    }
});


