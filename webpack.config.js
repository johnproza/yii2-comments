const WEBPACK = require('webpack');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const PATH = require('path');
var NODE_ENV = process.env.NODE_ENV || 'production';
console.log(NODE_ENV);


const CONFIG = {
    entry: './react/index.js',
    output: {
        path: PATH.resolve(__dirname, './assets/js'),
        filename: '[name].bundle.js',
        chunkFilename: '[name].bundle.js',
        //publicPath: 'dist/'
    },

    stats: NODE_ENV == 'development' ? "errors-only" :"verbose",
    mode: NODE_ENV,
    watch: NODE_ENV == 'development',
    watchOptions: {
        aggregateTimeout: 100
    },
    devtool: NODE_ENV == 'development' ? 'eval' : 'nosources-source-map',


    module:{
        rules:[
            {


                test: /\.(js|jsx)$/,
                exclude: /(node_modules|bower_components)/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ["@babel/preset-env",'@babel/preset-react'],
                        plugins: ["@babel/transform-runtime", "transform-class-properties", "@babel/plugin-syntax-dynamic-import"]
                    }
                }
            }
        ]
    },

    plugins: [
        new WEBPACK.DefinePlugin({
            NODE_ENV: JSON.stringify(NODE_ENV)
        })
    ],

    optimization: {
        minimizer: [
            new UglifyJsPlugin({
                uglifyOptions: {
                    sourceMap: true,
                    compress: {
                        drop_console: true,
                        conditionals: true,
                        unused: true,
                        comparisons: true,
                        dead_code: true,
                        if_return: true,
                        join_vars: true,
                        warnings: false
                    },
                    output: {
                        comments: false
                    }
                }
            })
        ]
    }
}

module.exports = CONFIG;