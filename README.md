# wp-enqueues

Helper functions to enqueue CSS &amp; JS files from two static files named `.js-enqueues` and `.css-enqueues` from the theme's root directory

Include `enqueues.php` file in your theme's `functions.php`

Add your CSS/JS files in the respective `.js-enqueues` and `.css-enqueues` files and your assets will be enqueued to your theme

Make sure you use the `!!` delimiter to add arguments

i.e, custom-styles !! /css/custom.css !! parent-theme-styles,some-other-style !! rand !! all

i.e, custom-scripts !! /js/custom.js !! jquery,some-other-script-handle !! false !! all

