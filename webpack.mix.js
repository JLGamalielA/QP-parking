const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications.
 |
 */

// 1. Compile the main app file
mix.js("resources/js/app.js", "public/js");

// 2. Compile the specific Map Handler independently
// Source: resources/js/map-handler.js (As shown in your image)
// Output: public/js/modules/parking/map-handler.js
mix.js("resources/js/map-handler.js", "public/js/modules/parking").version(); // Adds versioning for cache busting

// 3. Compile CSS (Volt Theme)
mix.sass("resources/scss/volt.scss", "public/css").options({
    processCssUrls: false,
}); // Fixes relative paths in CSS

// 4. Configure Webpack to silence deprecation warnings (from your template)
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
        if (rule.oneOf) rule.oneOf.forEach((one) => ensureQuietDeps(one.use));
        ensureQuietDeps(rule.use);
    });
});
