
chrome.runtime.onMessage.addListener(function (request) {

    function generateRandomString() {
        return Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
    }

    function sendActivateMessage(token) {
        chrome.tabs.query({
            active: true,
            currentWindow: true,
        }, function (tabs) {
            const activeTab = tabs[0];
            chrome.tabs.sendMessage(activeTab.id, {
                app: "omotenashi",
                start: true,
                token,
            });
        });
    }

    if (request.type === 'authenticate') {

        // scope
        //  - openid if you want an ID Token returned
        //  - offline_access if you want a Refresh Token returned
        // device
        //  - required if requesting the offline_access scope.

        const nonce = generateRandomString();
        let options = {
            audience: 'http://docker.omotenashi.today',
            response_type: 'id_token token',
            nonce,
        };

        new Auth0Chrome(env.AUTH0_DOMAIN, env.AUTH0_CLIENT_ID)
            .authenticate(options)
            .then(function (authResult) {
                console.log(authResult);
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
                sendActivateMessage(authResult.access_token);
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
        sendActivateMessage(request.token);
    }
});