const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin')

module.exports = {
  entry: './resources/assets/index.js',
  output: {
    path: path.resolve(__dirname, 'public'),
    filename: 'js/bundle.js'
  },
  module: {
    rules: [{
      test: /\.scss$/,
      use: [
          MiniCssExtractPlugin.loader,
          {
            loader: 'css-loader'
          },
          {
            loader: 'sass-loader',
            options: {
              sourceMap: true,
              // options...
            }
          }
        ]
    },
    {
      test: /\.(woff(2)?|ttf|eot|svg)(\?v=\d+\.\d+\.\d+)?$/,
      use: [{
            loader: 'file-loader',
            options: {
              name: '[name].[ext]',
              outputPath: 'fonts/'
            }
          }
        ]
    }]
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: 'css/app.css'
    }),
  ]
};
