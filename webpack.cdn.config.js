const path = require("path");
const CleanWebpackPlugin = require('clean-webpack-plugin');
const Dotenv = require('dotenv-webpack');

module.exports = {
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
    },
    watchOptions: {
        poll: true,
    }
};