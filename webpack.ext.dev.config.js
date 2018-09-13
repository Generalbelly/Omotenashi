const path = require("path");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const WebpackMd5Hash = require('webpack-md5-hash');
const CleanWebpackPlugin = require('clean-webpack-plugin');

module.exports = {
    mode: 'development',
    entry: { app: './resources/assets/ext/js/app.js' },
    output: {
        // filename: '[name].[chunkhash].js',
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
                            presets: ['babel-preset-stage-2']
                        }
                    }
                ],
            }
        ]
    },
    // optimization: {
    //     runtimeChunk: 'single',
    //     splitChunks: {
    //         cacheGroups: {
    //             vendor: {
    //             test: /[\\/]node_modules[\\/]/,
    //                 name: 'vendors',
    //                 chunks: 'all'
    //             }
    //         }
    //     }
    // },
    plugins: [
        new CleanWebpackPlugin('public/ext', {}),
        new MiniCssExtractPlugin({
            // filename: 'app.[contenthash].css'
        }),
        new WebpackMd5Hash()
    ],
    resolve: {
        extensions: ['.js', '.vue'],
        alias: {
            vue: 'vue/dist/vue.esm.js'
        }
    },
    devtool: '#eval-source-map'
};