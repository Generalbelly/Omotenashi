function APP() {
	let _isActive = false;

	function insertScript(src, cb) {
		let script = document.createElement('script');
		if (cb) script.onload = cb;
		script.src = src;
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
		init: function() {
            insertScript('http://docker.omotenashi.today/ext/app.js');
            insertStyleSheet('http://docker.omotenashi.today/ext/app.css');
			_isActive = true;
		}
	};
}

let app = null;

function start() {
    if (!app) {
        app = APP();
	}

    if (!app.isActive()) {
        app.init();
    }
}

chrome.runtime.onMessage.addListener(function (request, sender, sendResponse) {
    if (request.app === "omotenashi" && request.start) {
        start();
    }
});
