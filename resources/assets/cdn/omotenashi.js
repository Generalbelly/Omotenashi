import axios from 'axios';
import Driver from '../driver.js/driver.min';
import uuidv4 from 'uuid';
import '../sass/driver.scss';

window.Omotenashi = window.Omotenashi || (() => {
    const URL = process.env.APP_URL;
    const LOG_KEY = 'omotenashi_log';
    let log = null;

    let KEY = null;

    const retrieveLog = () => {
        try {
            const savedLog = JSON.parse(localStorage.getItem(LOG_KEY));
            return savedLog ? savedLog : {};
        } catch(e) {
            console.log(e)
            // TODO: handle exception
        }
    };


    const saveLog = (log, data) => {
        try {
            log = {
                ...log,
                ...data,
            }
            localStorage.setItem(LOG_KEY, JSON.stringify(log))
            return log;
        } catch (e) {
            console.log(e)
            // TODO: handle exception
        }
    };

    const activateDriver = (key, tutorial, property_id, tutorial_settings) => {
        let {
            only_once = [],
        } = log;

        const {
            name,
            steps,
        } = tutorial;

        let step = 0;

        const EVENT_LABEL = name;
        const GA_TRACKING_ID = property_id;
        const HIT_TYPE = 'event';
        const EVENT_CATEGORY = 'Tutorial';
        const EVENT_ACTION_COMPLETE = 'complete';
        const EVENT_ACTION_INCOMPLETE = 'incomplete';

        const driver = new Driver({
            animate: false,
            onNext() {
                step +=1;
            },
            onPrevious() {
                step -=1;
            },
            onReset() {
                if (!gtag || !GA_TRACKING_ID) return;

                const eventField = {
                    'send_to': GA_TRACKING_ID,
                    'event_label': EVENT_LABEL,
                    'event_category': EVENT_CATEGORY,
                    'value': step,
                    'non_interaction': true
                };

                if (step === steps.length) {
                    gtag(HIT_TYPE, EVENT_ACTION_COMPLETE, eventField);
                } else {
                    gtag(HIT_TYPE, EVENT_ACTION_INCOMPLETE, eventField);
                }

                if (tutorial_settings.only_once === 'yes') {
                    if (!only_once.includes(key)) {
                        only_once = [
                            ...only_once,
                            key,
                        ];
                    }
                    log = saveLog(log, {
                        only_once,
                    });
                }
            }
        });
        driver.defineSteps(steps);
        driver.start();
    }

    const fetchTutorial = (url) => {
        axios.get(`https://${URL}/api/tutorials/${KEY}?url=${url}`)
            .then(response => {
                const {
                    tutorial = {},
                    property_id = null,
                    tutorial_settings = {}
                } =  response.data;

                const {
                    only_once = [],
                } = log;

                const {
                    steps = [],
                    id,
                    path,
                    query,
                } = tutorial;

                const key = `${path}${query ? query : ''}`;
                if (steps.length > 0 && !only_once.includes(key)) {
                    activateDriver(key, tutorial, property_id, tutorial_settings)
                }
            })
            .catch(error => {
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
            KEY = key;
            fetchTutorial(window.location.href);
            startWatchingUrlForSPA();

            log = retrieveLog();

            if (!log.EU_ID) {
                const identifier = uuidv4();
                log = saveLog(log, {
                    EU_ID: identifier,
                });
            }
        },
    }

})()