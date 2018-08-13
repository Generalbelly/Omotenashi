const path = require("path");

module.exports = {
    entry: "./resources/assets/js/app.js",
    output: {
        filename: "app.js",
        path: path.join(__dirname, "./public/js")
    },
    module: {
        rules: [
            {
                test: /\.vue$/,
                loader: 'vue-loader',
                options: {
                    loaders: {
                      js: 'babel-loader'
                    }
                }
            },
            {
                test: /\.styl$/,
                use: [
                    'style-loader',
                    'css-loader',
                    'stylus-loader'
                ]
            },
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: ['babel-loader']
            },
        ]
    },
    plugins: [
        //new UglifyJsPlugin(),
    ],
    resolve: {
        extensions: ['.js', '.vue'],
        alias: {
            vue: 'vue/dist/vue.esm.js'
        }
    }
};
