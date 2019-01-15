import axios from 'axios'
import Driver from '../../../../driver.js/src/index'
import '../sass/driver.scss'

window.Omotenashi = window.Omotenashi || {
    init(key) {
        const url = process.env.APP_URL
        axios.get(`https://${url}/api/tutorials/${key}?url=${window.location.href}`)
            .then(response => {
                const steps =  response.data.steps
                if (steps.length > 0) {
                    const driver = new Driver({
                        animate: false,
                    })
                    driver.defineSteps(steps)
                    driver.start()
                }
            })
            .catch(error => {
                console.log(error);
            });
    }
};