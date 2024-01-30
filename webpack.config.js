const webpack = require("webpack")
const path = require("path")
const MiniCssExtractPlugin = require("mini-css-extract-plugin")
const fs = require("fs")

const CssMinimizerPlugin = require("css-minimizer-webpack-plugin")
const TerserPlugin = require("terser-webpack-plugin")

const createVersion = () => {
    const uid = Date.now()
    const content = '<?php return [ "version" => "' + uid + '"]; ?>'
    fs.writeFile("./version.php", content, (err) => {
        if (err) {
            console.error(err)
            return
        }
        console.log(`Version ${uid} generated`)
    })
}

class CustomPlugin {
    constructor(name, command, stage = "afterEmit") {
        this.name = name
        this.command = command
        this.stage = stage
    }

    apply(compiler) {
        compiler.hooks[this.stage].tap(this.name, () => {
            const uid = Date.now()
            const content = '<?php return [ "version" => "' + uid + '"]; ?>'
            fs.writeFile("./version.php", content, (err) => {
                if (err) {
                    console.error(err)
                    return
                }
                console.log(`Version ${uid} generated`)
            })
        })
    }
}

module.exports = (env, argv) => {
    let devMode = argv.mode === "development"
    return {
        mode: "production",
        entry: {
            style: path.join(__dirname, "src", "style.js"),
            admin: path.join(__dirname, "src", "admin.js"),
        },
        target: "web",
        resolve: {
            extensions: [".js"],
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
            filename: "assets/css/[name].js",
            path: path.resolve(__dirname),
            assetModuleFilename: "fonts/[hash][ext][query]",
        },
        plugins: [
            new MiniCssExtractPlugin({
                filename: "assets/css/[name].css",
            }),
            new CustomPlugin("Generate version", "php version.php"),
        ],
        optimization: {
            minimize: true,
            minimizer: [new TerserPlugin({}), new CssMinimizerPlugin()],
        },
        watch: devMode,
        watchOptions: {
            ignored: /node_modules/,
        },
    }
}
