const mix = require('laravel-mix');

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
mix.extract();

/**
 * Mix all the core css required in every page together
 */

// mix
//     .postCss("resources/css/tailwind.css", "public/css/all.css", [
//         require("tailwindcss"),
//     ])
//     .sass('resources/scss/all.scss', 'public/css/all.css');


/**
 * Here we will build all the js and other css needed for the frontend app to function
 */
// mix.js("resources/js/build/app.js", "public/js/app.js").vue()
//     .sass("resources/scss/app.scss", "public/css");


    /**
     * Here we will build all the files needed for the user portal to function
     *
     */
// mix.js("resources/js/build/portal.js", "public/js/portal/app.js").vue()
//     .sass("resources/scss/portal.scss", "public/css/portal.css");


    /**
     * Here we will build all the files needed for the user shop to function
     *
     */
mix.js("resources/js/build/shop.js", "public/js/shop/shop.js").vue()
    .sass("resources/scss/shop.scss", "public/css/shop/shop.css");


    /**
     |
     | Here We will build all the files needed for the admin area dashboard
     | We will commnent out the app side until this build is completed
     | Making sure that  we are accurate
     |
     */

    // mix.js("resources/js/build/admin.js", "public/js/admin/app.js").vue()
    // .sass('resources/scss/admin.scss', 'public/css/admin/app.css');

