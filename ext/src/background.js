chrome.runtime.onMessage.addListener(function (request) {

    function notifyLoginFailure(error) {
        chrome.notifications.create({
            type: 'basic',
            title: 'Login Failed',
            message: error.message,
            iconUrl: 'icons/icon128.png'
        });
    };

    function sendActivateMessage(token) {
        chrome.tabs.query({
            active: true,
            currentWindow: true,
        }, function (tabs) {
            try {
                const activeTab = tabs[0];
                chrome.tabs.sendMessage(activeTab.id, {
                    app: "omotenashi",
                    start: true,
                    jsFilePath: env.JS_FILE_PATH,
                    cssFilePath: env.CSS_FILE_PATH,
                    token,
                });
            } catch (e) {
                notifyLoginFailure(e);
            }
        });
    }

    if (request.type === 'authenticate') {

        let options = {
            audience: env.AUTH0_AUDIENCE,
            response_type: 'id_token token',
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
                sendActivateMessage(authResult.access_token);
            }).catch(function (e) {
                notifyLoginFailure(e);
                chrome.runtime.sendMessage({
                    result: false,
                });
        });
    } else if (request.type === 'login') {
        sendActivateMessage(request.token);
    }

});