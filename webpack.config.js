const path = require("path");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const Dotenv = require('dotenv-webpack');

module.exports = {
    mode: process.env.APP_ENV !== 'local' ? "production" : "development",
    entry: { app: './resources/assets/js/app.js' },
    output: {
        filename: "js/app.js",
        path: path.join(__dirname, "./public"),
        publicPath: "/",
    },
    devServer: {
        // compress: true,
        // contentBase: path.join(__dirname, "./public"),
        // publicPath: '/',
        // port: 80,
        // proxy: {
        //     '*': {
        //         target: 'https://docker.omotenashi.today',
        //         secure: false
        //     }
        // },
        // host: '0.0.0.0',
        // disableHostCheck: true,
        // hot: true,
        // inline: true,
        // quiet: false,
        // noInfo: false,
        // stats: {
        //     colors: true
        // }
        compress: true,
        contentBase: path.join(__dirname, "./public"),
        publicPath: '/',
        port: 9000,
        proxy: {
            '*': {
                target: 'https://docker.omotenashi.today',
                secure: false
            }
        },
        host: 'localhost',
        disableHostCheck: true,
        hot: true,
        inline: true,
        quiet: false,
        noInfo: false,
        stats: {
            colors: true
        }
    },
    module: {
        rules: [
            {
                test: /\.vue$/,
                use: [
                    {
                        loader: 'vue-loader',
                        options: {
                            loaders: {
                                js: 'babel-loader',
                            }
                        }
                    },
                ]
            },
            {
                test: /\.css$/,
                use:  [
                    'style-loader',
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                ]
            },
            {
                test: /\.scss$/,
                use:  [
                    'style-loader',
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                    'sass-loader'
                ]
            },
            {
                test: /.(png|jpg|jpeg|gif|svg|woff|woff2|ttf|eot)$/,
                loader: 'url-loader?limit=10000',
            },
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: [
                    {
                        loader: 'babel-loader',
                        options: {
                            presets: ['@babel/preset-env'],
                            plugins: [
                                '@babel/plugin-proposal-class-properties',
                                '@babel/plugin-proposal-object-rest-spread',
                            ]
                        }
                    }
                ],
            }
        ]
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: 'css/[name].css',
            path: path.join(__dirname, "./public"),
            publicPath: "/",
        }),
        new Dotenv(),
    ],
    resolve: {
        extensions: ['.js', '.vue'],
        alias: {
            vue: 'vue/dist/vue.esm.js'
        }
    },
    watchOptions: {
        poll: true,
    }
};