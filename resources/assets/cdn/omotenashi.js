import axios from 'axios'
import Driver from '../driver.js/driver.min'
import '../sass/driver.scss'

window.Omotenashi = window.Omotenashi || (() => {
    const URL = process.env.APP_URL
    let KEY = null

    const activateDriver = (steps) => {
        const driver = new Driver({
            animate: false,
            allowClose: false,
        })
        driver.defineSteps(steps)
        driver.start()
    }

    const fetchTutorial = (url) => {
        axios.get(`https://${URL}/api/tutorials/${KEY}?url=${url}`)
            .then(response => {
                const steps =  response.data.steps
                if (steps.length > 0) {
                    activateDriver(steps)
                }
            })
            .catch(error => {
                console.log(error);
            });
    }

    const startWatchingUrlForSPA = () => {
        const self = this
        let path = null
        const proxiedPushState = window.history.pushState
        window.history.pushState = function(stateObj, title, URL) {
            const newPath = arguments[2]
            if (newPath !== path) {
                path = newPath
                self.fetchTutorial(window.location.origin + newPath)
            }
            return proxiedPushState.apply(this, arguments)
        }
    }

    return {
        init(key) {
            KEY = key
            fetchTutorial(window.location.href)
            startWatchingUrlForSPA()
        },
    }

})()