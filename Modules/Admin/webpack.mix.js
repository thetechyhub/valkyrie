const mix = require('laravel-mix');

require("laravel-mix-alias");
require('laravel-mix-merge-manifest');

var publicPath = "../../public";

mix.alias({
  "@": "/Resources/scripts/",
  "~": "/Resources/scss/",
  "component": "/Resources/scripts/components"
});

mix.setPublicPath(publicPath).mergeManifest();

mix.js(__dirname + '/Resources/scripts/index.js', 'js/admin.js')
  .sass( __dirname + '/Resources/sass/app.scss', 'css/admin.css');



if (!mix.inProduction()) {
  mix.sourceMaps();
}

if (mix.inProduction()) {
  mix.version();
}
