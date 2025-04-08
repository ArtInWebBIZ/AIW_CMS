var gulp = require('gulp'),
    sass = require('gulp-sass')(require('sass')),
    autoprefixer = require('gulp-autoprefixer'),
    cleanCSS = require('gulp-clean-css'),
    rename = require('gulp-rename'),
    sourcemaps = require('gulp-sourcemaps')
    ;

gulp.task('sass', function ()
{
    // Create Task "sass"
    return gulp.src('dev/sass/style.sass') // We indicate the source

        // Initialize the creation of a transformation card
        .pipe(sourcemaps.init())

        // We convert SASS to CSS by means of gulp-sass
        .pipe(sass({
            outputStyle: 'expanded'
        }).on('error', sass.logError)) // We bring errors to the console

        // Add from CSS the drugs for different browsers and their versions (including for IE)
        .pipe(autoprefixer({}))

        // Minimize CSS
        .pipe(cleanCSS({
            compatibility: 'ie8'
        }))

        // Rename the minimized styles file
        .pipe(rename("/style.min.css"))

        // Record transformations into a separate file
        .pipe(sourcemaps.write('.'))

        // We indicate the directory where we write down the minimized styles file
        .pipe(gulp.dest('public_html/css'))
});

gulp.task('watch', function ()
{
    gulp.watch(['dev/sass/*.sass'], gulp.parallel('sass'));
});

gulp.task('default', gulp.parallel('watch'));


// Installation of all additions for GULP
// yarn init
// yarn add --save-dev gulp gulp-sass sass gulp-autoprefixer browserslist gulp-clean-css gulp-rename gulp-sourcemaps
// npm install gulp
// gulp
