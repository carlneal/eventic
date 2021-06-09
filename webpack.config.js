var Encore = require('@symfony/webpack-encore');

Encore
        // directory where compiled assets will be stored
        .setOutputPath('public/assets/')

        // public path used by the web server to access the output path
        .setPublicPath('/assets/')

        // frontend and dashboard entries
        .addEntry('app', './assets/js/app.js')
        .addEntry('app.orange', './assets/js/themes/app.orange.js')
        .addEntry('app.lightblue', './assets/js/themes/app.lightblue.js')
        .addEntry('app.darkblue', './assets/js/themes/app.darkblue.js')
        .addEntry('app.yellow', './assets/js/themes/app.yellow.js')
        .addEntry('app.purple', './assets/js/themes/app.purple.js')
        .addEntry('app.pink', './assets/js/themes/app.pink.js')
        .addEntry('app.red', './assets/js/themes/app.red.js')
        .addEntry('app.green', './assets/js/themes/app.green.js')
        .addEntry('app.dark', './assets/js/themes/app.dark.js')
        .addEntry('app.fr', './assets/js/i18n/app.fr.js')
        .addEntry('app.es', './assets/js/i18n/app.es.js')
        .addEntry('app.ar', './assets/js/i18n/app.ar.js')
        .addEntry('events', './assets/js/events.js')
        .addEntry('event', './assets/js/event.js')
        .addEntry('organizerprofile', './assets/js/organizerprofile.js')
        .addEntry('installer', './assets/js/installer.js')

        // each filename will now include a hash that changes whenever the contents of that file change
        .enableVersioning()

        .copyFiles({
            from: './assets/img',

            // optional target path, relative to the output dir
            to: 'img/[path][name].[ext]',

            // if versioning is enabled, add the file hash too
            to: 'img/[path][name].[hash:8].[ext]'

        })

        // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
        .splitEntryChunks()

        // will require an extra script tag for runtime.js
        // but, you probably want this, unless you're building a single-page app
        .enableSingleRuntimeChunk()

        .cleanupOutputBeforeBuild()
        .enableBuildNotifications()
        .enableSourceMaps(!Encore.isProduction())
        // enables hashed filenames (e.g. app.abc123.css)
        .enableVersioning(Encore.isProduction())

        // enables @babel/preset-env polyfills
        .configureBabel(() => {
        }, {
            useBuiltIns: 'usage',
            corejs: 3
        })

        // enables Sass/SCSS support
        .enableSassLoader()

        // enables PostCSS and autoprefixing
        .enablePostCssLoader()

        .autoProvidejQuery()
        .autoProvideVariables({
            $: 'jquery',
            jQuery: 'jquery',
            'window.jQuery': 'jquery'
        })
        ;
module.exports = Encore.getWebpackConfig();