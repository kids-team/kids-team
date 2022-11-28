const webpack = require('webpack');
const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");


const createVersion = () => {
	const uid = Date.now();
	const content = '<?php return [ "version" => "' + uid + '"]; ?>';
	fs.writeFile('./version.php', content, err => {
		if (err) {
		  console.error(err)
		  return
		}
		console.log(`Version ${uid} generated`);
	  })
}

module.exports = (env, argv) => {

	console.log("Mode: ", argv.mode)
	let devMode = argv.mode === 'development'
	return {
		mode: 'production',
		entry: {
			style: path.join(__dirname, 'src', 'style.js'),
			admin: path.join(__dirname, 'src', 'admin.js')
		},
		target: 'web',
		resolve: {
			extensions: ['.js']
		},
		module: {
			rules: [
				{ 
					test: /\.(sa|sc|c)ss$/,
					use: [
						MiniCssExtractPlugin.loader,
						"css-loader",
						"postcss-loader",
						"sass-loader",
					],
				},
				
			],
		},
		output: {
			filename: '[name].js',
			path: path.resolve(__dirname),
			assetModuleFilename: 'fonts/[hash][ext][query]'
		},
		plugins: [new MiniCssExtractPlugin()],
		optimization: {
			minimizer: [
				new UglifyJsPlugin({
					uglifyOptions: {
						output: {
							comments: false,
						},
						compress: {
							drop_console: true,
						},
					},
				}),
				new CssMinimizerPlugin()
			],
		},
		watch: devMode,
		watchOptions: {
			ignored: /node_modules/,
		}
	}
}