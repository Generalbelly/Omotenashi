const path = require("path");
const CleanWebpackPlugin = require('clean-webpack-plugin');
const Dotenv = require('dotenv-webpack');

module.exports = {
    mode: 'development',
    entry: {
        omotenashi: './resources/assets/cdn/omotenashi.js',
    },
    output: {
        path: path.resolve(__dirname, "public/cdn")
    },
    module: {
        rules: [
            {
                test: /\.scss$/,
                use:  [
                    'style-loader',
                    'css-loader',
                    'sass-loader'
                ]
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
        new CleanWebpackPlugin('public/cdn', {}),
        new Dotenv(),
    ],
    resolve: {
        extensions: ['.js'],
    }
};