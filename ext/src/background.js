const appName = env.APP_NAME;
let omotenashiTabId = null;
let comingFromSite = false;
let tutorialUrl = null;

function validate(token) {
    return jwt_decode(token).exp > Date.now() / 1000;
}

function getToken() {
    const authResult = JSON.parse(localStorage.authResult || '{}');
    const token = authResult.access_token;
    if (token) {
        const isValid = validate(token);
        return isValid ? token : null;
    }
    return null;
}

function clearMeta() {
    comingFromSite = false;
    tutorialUrl = null;
}

function logout() {
    // Remove the idToken from storage
    omotenashiTabId = null;
    localStorage.clear();
}

function startApp(tabId, token) {
    chrome.tabs.sendMessage(tabId, {
        app: appName,
        start: true,
        jsFilePath: env.JS_FILE_PATH,
        driverFilePath: env.DRIVER_JS_FILE_PATH,
        cssFilePath: env.CSS_FILE_PATH,
        token
    });
    omotenashiTabId = tabId;
}

function activateApp(token) {
    chrome.tabs.query({
        active: true,
        currentWindow: true,
    }, function (tabs) {
        try {
            const activeTab = tabs[0];
            startApp(activeTab.id, token);
        } catch (e) {
            console.log(e);
        }
    });
}

function authenticate() {
    new Auth0Chrome(env.AUTH0_DOMAIN, env.AUTH0_CLIENT_ID)
        .authenticate({
            audience: env.AUTH0_AUDIENCE,
            prompt: 'none',
        })
        .then(function (authResult) {
            localStorage.authResult = JSON.stringify(authResult);
            activateApp(authResult.access_token);
        })
        .catch(function (e) {
            console.log(e);
        });
}

chrome.browserAction.onClicked.addListener(function(tab) {
    const token = getToken();
    if (token) {
        startApp(tab.id, token);
    } else {
        authenticate();
    }
});

chrome.tabs.onUpdated.addListener(function(tabId, changeInfo, tab) {
    const token = getToken();
    if (token && tabId === omotenashiTabId) {
        startApp(tabId, token);
    } else if (comingFromSite && tutorialUrl === tab.url) {
        if (token) {
            startApp(tabId, token);
        } else {
            authenticate();
        }
    }
});

chrome.runtime.onMessage.addListener(function (request={}, sender, sendResponse) {
    if (request.app === appName) {
        if (request.status === 'done') {
            clearMeta()
        }
    }
});

chrome.runtime.onMessageExternal.addListener(function (request={}, sender, sendResponse) {
    if (request.app === appName) {
        let response = {
            state: 'success',
        }
        if (request.message === 'version') {
            const manifest = chrome.runtime.getManifest();
            response.version = manifest.version
        } else if (request.message.state && request.message.state === 'coming') {
            comingFromSite = true;
            tutorialUrl = request.message.tutorialUrl
        }
        sendResponse(response);
    }
    return true;
});
