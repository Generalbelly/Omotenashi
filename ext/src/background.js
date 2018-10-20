
chrome.runtime.onMessage.addListener(function (request) {

    function sendActivateMessage() {
        chrome.tabs.query({
            active: true,
            currentWindow: true,
        }, function (tabs) {
            const activeTab = tabs[0];
            chrome.tabs.sendMessage(activeTab.id, {
                app: "omotenashi",
                start: true,
            });
        });
    }

    if (request.type === 'authenticate') {

        // scope
        //  - openid if you want an ID Token returned
        //  - offline_access if you want a Refresh Token returned
        // device
        //  - required if requesting the offline_access scope.
        let options = {
            scope: 'openid offline_access',
            device: 'chrome-extension'
        };

        new Auth0Chrome(env.AUTH0_DOMAIN, env.AUTH0_CLIENT_ID)
            .authenticate(options)
            .then(function (authResult) {
                localStorage.authResult = JSON.stringify(authResult);
                chrome.notifications.create({
                    type: 'basic',
                    iconUrl: 'icons/icon128.png',
                    title: 'Login Successful',
                    message: 'Let\'s start building tutorials now'
                });
                chrome.runtime.sendMessage({
                    result: true,
                });
                sendActivateMessage();
            }).catch(function (err) {
                chrome.notifications.create({
                    type: 'basic',
                    title: 'Login Failed',
                    message: err.message,
                    iconUrl: 'icons/icon128.png'
                });
                chrome.runtime.sendMessage({
                    result: false,
                });
        });
    } else if (request.type === 'login') {
        sendActivateMessage();
    }
});