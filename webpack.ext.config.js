const path = require("path");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const Dotenv = require('dotenv-webpack');

module.exports = {
    mode: process.env.APP_ENV === 'prod' ? "production" : "development",
    entry: { app: './resources/assets/ext/js/app.js' },
    output: {
        path: path.resolve(__dirname, "public/ext")
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
                                ["transform-imports", {
                                    "@fortawesome": {
                                        "transform": "@fortawesome/free-solid-svg-icons/${member}",
                                        "preventFullImport": true,
                                        "skipDefaultConversion": true,
                                    }
                                }],
                            ]
                        }
                    }
                ],
            }
        ]
    },
    plugins: [
        new MiniCssExtractPlugin(),
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