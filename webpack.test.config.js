const path = require("path");
const nodeExternals = require('webpack-node-externals');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const isCoverage = process.env.NODE_ENV === 'coverage';

let config = {
    module: {
        rules: [
            {
                test: /\.vue$/,
                use: [
                    {
                        loader: 'vue-loader',
                        options: {
                            loaders: {
                                js: 'babel-loader'
                            }
                        }
                    }
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
                            },
                        }],
                    ],
                },
            },
        ],
    },
    plugins: [
        new MiniCssExtractPlugin({
            // filename: 'app.[contenthash].css'
        }),
    ],
    resolve: {
        extensions: ['.js', '.vue'],
        alias: {
            vue: 'vue/dist/vue.esm.js'
        }
    },
    externals: [nodeExternals()], // in order to ignore all modules in node_modules folder
    devtool: "inline-cheap-module-source-map",
};


if (isCoverage) {
    config.module.rules.unshift({
        test: /\..{js,vue}$/,
        include: [
            path.resolve(__dirname, "resources/assets/js"),
            path.resolve(__dirname, "resources/assets/ext"),
        ],
        use: {
            loader: "istanbul-instrumenter-loader",
            options: { esModules: true },
        },
        enforce: 'post',
    });
}

config.mode = "development";

module.exports = config;