const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const browserSync = require('browser-sync').create();
var autoprefixer = require( 'gulp-autoprefixer' );

function style() {
    var stream = gulp.src('./scss/**/*.scss')
    .pipe(sass())
    .pipe( autoprefixer( 'last 2 versions' ) )
    .pipe(gulp.dest('./css'));

    return stream;
}

function watch() {
    browserSync.init({
        proxy: "buffcodebase.local"
    });

    gulp.watch('./scss/**/*.scss', style);
    gulp.watch('./**/*.php').on('change', browserSync.reload);
    gulp.watch('./css/*.css').on('change', browserSync.reload);
}

exports.style = style;
exports.watch = watch;