function isLoggedIn(token) {
    // The user is logged in if their token isn't expired
    return jwt_decode(token).exp > Date.now() / 1000;
}

function logout() {
    // Remove the idToken from storage
    localStorage.clear();
    main();
}

// Minimal jQuery
const $$ = document.querySelectorAll.bind(document);
const $  = document.querySelector.bind(document);


function renderAfterLoginView(authResult) {
    $('.default').classList.add('is-hidden');
    $('.loading').classList.remove('is-hidden');
    fetch(`https://${env.AUTH0_DOMAIN}/userinfo`, {
        headers: {
            'Authorization': `Bearer ${authResult.access_token}`
        }
    }).then(res => res.json()).then(() => {
        $('.loading').classList.add('is-hidden');
        $('.after-login').classList.remove('is-hidden');
        $('.logout-button').addEventListener('click', logout);
        chrome.runtime.sendMessage({
            type: "login",
            token: authResult.access_token,
        });
    }).catch(logout);
}


function renderDefaultView() {
    $('.default').classList.remove('is-hidden');
    $('.after-login').classList.add('is-hidden');
    $('.loading').classList.add('is-hidden');

    $('.login-button').addEventListener('click', () => {
        $('.default').classList.add('is-hidden');
        $('.loading').classList.remove('is-hidden');
        chrome.runtime.sendMessage({
            type: "authenticate"
        });

        chrome.runtime.onMessage.addListener(function(request, sender, sendResponse) {
            if (request.result) {
                $('.loading').classList.add('is-hidden');
                $('.after-login').classList.remove('is-hidden');
            } else {
                $('.loading').classList.add('is-hidden');
                $('.default').classList.remove('is-hidden');
            }
        });

    });
}

function main () {
    const authResult = JSON.parse(localStorage.authResult || '{}');
    const token = authResult.access_token;
    if (token && isLoggedIn(token)) {
        renderAfterLoginView(authResult);
    } else {
        renderDefaultView();
    }
}

document.addEventListener('DOMContentLoaded', main);