const mix = require('laravel-mix');

require("laravel-mix-alias");
require('laravel-mix-merge-manifest');

var publicPath = "../../public";

require("dotenv").config({ path: "../../.env" });

mix.alias({
  "@": "/Resources/scripts/",
  "~": "/Resources/scss/",
  "@component": "/Resources/scripts/components",
  "@pages": "/Resources/scripts/pages"
});

mix.setPublicPath(publicPath).mergeManifest();


mix.js(__dirname + '/Resources/scripts/index.js', 'js/admin.js')
  .sass( __dirname + '/Resources/sass/app.scss', 'css/admin.css')
  .copyDirectory(__dirname + "/Resources/images", publicPath + "/images/admin");



if (!mix.inProduction()) {
  mix.sourceMaps();
}

if (mix.inProduction()) {
  mix.version();
}
