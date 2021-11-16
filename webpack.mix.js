const mix = require('laravel-mix');
const concat = require('concat-files');

mix.sass('src/scss/style.scss', '.').then(function () {
    concat([
        'src/css/theme.css',
        'style.css'
    ], 'style.css', function (err) {
        if (err) { throw err; }
    });
});;

mix.sass('src/scss/admin.scss', '.')

mix.browserSync({
    proxy: 'kids-team.local',
});