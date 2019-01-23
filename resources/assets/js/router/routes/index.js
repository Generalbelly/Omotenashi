/**
 * The file enables `@/router/index.js` to import all routes
 * in a one-shot manner. There should not be any reason to edit this file.
 */

const files = require.context('.', false, /\.js$/)
let routes = []

files.keys().forEach(key => {
    if (key === './index.js') return
    files(key).default.forEach(route => {
        routes.push(route)
    })
})

export default routes
