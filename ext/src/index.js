function APP() {
    let _isActive = false;

    function insertScript(src, cb) {
        let script = document.createElement('script');
        if (cb) script.onload = cb;
        if (src.includes('http')) {
            script.src = src
        } else {
            script.textContent = src;
        }
        document.head.appendChild(script);
    }

    function insertStyleSheet(src) {
        let link = document.createElement('link');
        link.rel = "stylesheet";
        link.href = src;
        document.head.appendChild(link);
    }

    return {
        isActive: function() {
            return _isActive;
        },
        init: function(token) {
            _isActive = true;
            insertScript(`const _ot_ext_token = "${token}"`);
            insertScript('http://docker.omotenashi.today/ext/app.js');
            insertStyleSheet('http://docker.omotenashi.today/ext/app.css');
        }
    };
}

let app = null;

function start(token) {
    if (!app) {
        app = APP();
    }

    if (!app.isActive()) {
        app.init(token);
    }
}

chrome.runtime.onMessage.addListener(function (request, sender, sendResponse) {
    if (request.app === "omotenashi" && request.start && request.token) {
        start(request.token);
    }
});


