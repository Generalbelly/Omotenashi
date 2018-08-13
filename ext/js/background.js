chrome.browserAction.onClicked.addListener(function(tab) {
    chrome.tabs.sendMessage(tab.id, {
        app: "omotenashi",
        start: true,
    });
});
