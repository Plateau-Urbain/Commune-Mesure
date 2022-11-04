const webpack = require("webpack");
const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin')

const ASSET_PATH = process.env.ASSET_PATH || '/'

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
        test: /\.(woff(2)?|ttf|eot|otf)(\?v=\d+\.\d+\.\d+)?$/,
        use: [{
          loader: 'file-loader',
          options: {
            name: '[name].[ext]?[contenthash]',
            outputPath: '/fonts/',
            publicPath: ASSET_PATH + 'fonts/'
          }
        }
        ]
      },
      {
        test: /\.(png|jpg|jpeg|gif|svg)$/,
        use: {
          loader: 'file-loader',
          options: {
            name: '[name].[ext]?[contenthash]',
            outputPath: '/images/',
            publicPath: ASSET_PATH + 'images/'
          }
        }
      }
    ]
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: 'css/[name].css'
    }),
    new webpack.DefinePlugin({
      'process.env.ASSET_PATH': JSON.stringify(ASSET_PATH),
    })
  ]
};
