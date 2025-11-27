const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

// 1. Compile the main app file
mix.js("resources/js/app.js", "public/js");

// 2. Compile the specific Map Handler
// Source: resources/js/map-handler.js
// Output: public/js/modules/parking/map-handler.js
mix.js("resources/js/map-handler.js", "public/js/modules/parking").version();

mix.js("resources/js/qr-reader.js", "public/js/modules/parking").version();

// 3. Compile the Global Alert Handler (SweetAlert2 logic)
// Source: resources/js/alert-handler.js
// Output: public/js/utils/alert-handler.js
mix.js("resources/js/alert-handler.js", "public/js/utils").version();
mix.js("resources/js/search-handler.js", "public/js/modules/parking").version();

// 4. Compile CSS (Volt Theme)
mix.sass("resources/scss/volt.scss", "public/css").options({
    processCssUrls: false,
});

// 5. Configure Webpack to silence deprecation warnings
mix.webpackConfig({
    stats: {
        children: true,
    },
});

// Override rules to suppress Sass warnings from dependencies
mix.override((config) => {
    const ensureQuietDeps = (useArray) => {
        if (!Array.isArray(useArray)) return;
        useArray.forEach((u) => {
            if (u && u.loader && u.loader.includes("sass-loader")) {
                u.options = {
                    ...(u.options || {}),
                    sassOptions: {
                        ...(u.options && u.options.sassOptions
                            ? u.options.sassOptions
                            : {}),
                        quietDeps: true,
                        silenceDeprecations: [
                            "legacy-js-api",
                            "import",
                            "global-builtin",
                            "color-functions",
                        ],
                    },
                };
            }
        });
    };

    (config.module.rules || []).forEach((rule) => {
        if (rule.oneOf) {
            rule.oneOf.forEach((one) => ensureQuietDeps(one.use));
        }
        ensureQuietDeps(rule.use);
    });
});
