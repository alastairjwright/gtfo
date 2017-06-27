const autoprefixer = require('gulp-autoprefixer');
const cleanCSS = require('gulp-clean-css');
const gulp = require('gulp');
const gulpif = require('gulp-if');
const sass = require('gulp-sass');
const sassGlob = require('gulp-sass-glob');
const sourcemaps = require('gulp-sourcemaps');
const watch = require('gulp-watch');

const browserslist = require('../config').browserslist;
const paths = require('../config').paths;

const ENVIRONMENT = process.env.NODE_ENV;
const IS_PRODUCTION = ENVIRONMENT === 'production';

gulp.task('styles', () => {
  return gulp
    .src(paths.styles.src)
    .pipe(sourcemaps.init())
    .pipe(sassGlob())
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer({browsers: browserslist}))
    .pipe(gulpif(IS_PRODUCTION, cleanCSS()))
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest(paths.styles.dest));
});

gulp.task('styles-watch', () => {
  watch(paths.styles.watch, () => gulp.start('styles'));
});
