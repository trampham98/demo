const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const browserSync = require('browser-sync').create();
const concat = require('gulp-concat');
var autoprefixer = require( 'gulp-autoprefixer' );

// style css
function styleVendors() {
    var stream = gulp.src('./assets/scss/vendors/*.min.css')
    .pipe(concat('vendors.css'))
    .pipe(gulp.dest('./assets/css'));

    return stream;
}

function styleTheme() {
    var stream = gulp.src('./assets/scss/**/*.scss')
    .pipe(sass())
    .pipe( autoprefixer( 'last 2 versions' ) )
    .pipe(gulp.dest('./assets/css'));

    return stream;
}

// concat file .min.js
gulp.task( 'concat-vendors', function() {
    var stream = gulp.src('./assets/js/vendors/*.js')
    .pipe(concat('vendors.js'))
    .pipe(gulp.dest('./assets/js'));

    return stream;
});

// watch live
gulp.task( 'watch-bs', function() {
    browserSync.init({
        proxy: "demo.local"
    });

    gulp.watch('./assets/scss/**/*.scss', styleVendors);
    gulp.watch('./assets/scss/**/*.scss', styleTheme);

    gulp.watch('./**/*.php').on('change', browserSync.reload);
    gulp.watch('./assets/css/*.css').on('change', browserSync.reload);
});

// watch normal
gulp.task( 'watch', function() {
    gulp.watch('./assets/scss/**/*.scss', styleVendors);
    gulp.watch('./assets/scss/**/*.scss', styleTheme);
});

exports.style = styleVendors;
exports.style = styleTheme;