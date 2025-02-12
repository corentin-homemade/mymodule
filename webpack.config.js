const path = require('path');

module.exports = {
    entry: '/js/index.js',
    output: {
        filename: 'mymodule_grid.bundle.js',
        path: path.resolve(__dirname, 'views/js'),
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env'],
                    },
                },
            },
        ],
    },
    mode: 'development',
    devtool: 'source-map',
};
