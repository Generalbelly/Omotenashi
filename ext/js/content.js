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
		activate: function() {
            insertScript("http://localhost:9000/ext/app.js");
            insertStyleSheet("http://localhost:9000/ext/app.css");
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
		app.activate();
		console.log('started');
    } else {
		console.log('already started');
	}
}

chrome.extension.onMessage.addListener(function(request, sender, sendResponse) {
    if (request.app === "omotenashi" && request.start) {
        start();
    }
});