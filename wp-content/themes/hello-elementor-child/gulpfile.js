const gulp         = require('gulp');
const sass         = require('gulp-sass')(require('sass'));
const browserSync  = require('browser-sync').create();
const concat       = require('gulp-concat');
const autoprefixer = require( 'gulp-autoprefixer' );
const cleanCSS     = require('gulp-clean-css');
const sourcemaps   = require('gulp-sourcemaps');

// vendors css
// function combineVendorCSS() {
//     return gulp.src('./assets/vendors/css/min/*.min.css')
//         .pipe(concat('vendors.css'))
//         .pipe(gulp.dest('./assets/css'));
// }

// gulp.task('minify-vendor-css',function() {
//     return gulp.src(['./assets/vendors/css/slick-theme.css'])
//         .pipe(sourcemaps.init())
//         .pipe(cleanCSS())
//         .pipe(sourcemaps.write())
//         .pipe(concat('vendors.css'))
//         .pipe(gulp.dest('./assets/css'));
// });

// gulp.task('minify-vendor-css',function() {
//     return gulp.src('./assets/css/vendors.css')
//       .pipe(sourcemaps.init())
//       .pipe(cleanCSS())
//       .pipe(sourcemaps.write())
//       .pipe(gulp.dest('./assets/css/demo'));
// });

// theme
function generateThemeCSS() {
    return gulp.src('./assets/scss/**/*.scss')
        .pipe(sass())
        .pipe( autoprefixer( 'last 2 versions' ) )
        .pipe(gulp.dest('./assets/css'));
}

// concat file .min.js
// gulp.task( 'concat-vendorsjs', function() {
//     return gulp.src('./assets/js/vendors/*.js')
//         .pipe(concat('vendors.js'))
//         .pipe(gulp.dest('./assets/js'));
// });

// watch live
gulp.task( 'watch-bs', function() {
    browserSync.init({
        proxy: "demo.local"
    });
    gulp.watch('./assets/scss/**/*.scss', generateThemeCSS);
    gulp.watch('./**/*.php').on('change', browserSync.reload);
    gulp.watch('./assets/css/*.css').on('change', browserSync.reload);
});

// watch normal
gulp.task( 'watch', function() {
    gulp.watch('./assets/scss/**/*.scss', generateThemeCSS);
});

// exports.style = combineVendorCSS;
exports.style = generateThemeCSS;