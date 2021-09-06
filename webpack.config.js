const webpack = require("webpack");
const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin')

module.exports = {
  entry: {
      'app': './resources/assets/index.js',
      'external': './resources/assets/external.js',
  },
  output: {
    path: path.resolve(__dirname, 'public'),
    filename: (pathData) => {
        return pathData.chunk.name === 'app' ? 'js/bundle.js' : 'js/[name].js';
    }
  },
  mode: 'development',
  module: {
    rules: [{
      test: /\.scss$/,
      use: [
        MiniCssExtractPlugin.loader,
        { loader: 'css-loader' },
        { loader: 'sass-loader', options: { sourceMap: true } }
      ]
    },
      {
        test: /\.css$/,
        use: [
          MiniCssExtractPlugin.loader,
          { loader: 'css-loader' }
        ]
      },
      {
        test: /\.(woff(2)?|ttf|eot|svg|otf)(\?v=\d+\.\d+\.\d+)?$/,
        use: [{
          loader: 'file-loader',
          options: {
            name: '[name].[ext]?[contenthash]',
            outputPath: '/fonts/',
            publicPath: '/app/fonts/'
          }
        }
        ]
      },
      {
        test: /\.(png|jpg|jpeg|gif)$/,
        use: {
          loader: 'file-loader',
          options: {
            name: '[name].[ext]?[contenthash]',
            outputPath: '/images',
            publicPath: '/images'
          }
        }
      }
    ]
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: 'css/[name].css'
    }),
  ]
};
