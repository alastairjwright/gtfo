const browserify = require('browserify');
const buffer = require('vinyl-buffer');
const gulp = require('gulp');
const gulpif = require('gulp-if');
const source = require('vinyl-source-stream');
const sourcemaps = require('gulp-sourcemaps');
const uglify = require('gulp-uglify');
const watch = require('gulp-watch');
const concat = require('gulp-concat');

const paths = require('../config').paths;

const ENVIRONMENT = process.env.NODE_ENV;
const IS_PRODUCTION = ENVIRONMENT === 'production';

gulp.task('scripts:dependencies', () => {
  return gulp.src([
      './bower_components/jquery/dist/jquery.min.js',
      './bower_components/jquery.easing/js/jquery.easing.min.js',
      './bower_components/gsap/src/minified/TweenMax.min.js'
    ])
    .pipe(sourcemaps.init())
    .pipe(concat('libraries.js'))
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest(paths.scripts.dest));
});

gulp.task('scripts:main', () => {
  return browserify({
      entries: paths.scripts.src,
      debug: true
    })
    .bundle()
    .pipe(source(paths.scripts.filename))
    .pipe(buffer())
    .pipe(sourcemaps.init({loadMaps: true}))
    .pipe(gulpif(IS_PRODUCTION, uglify({
      output: {
        max_line_len: 500
      }
    })))
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest(paths.scripts.dest));
});

gulp.task('scripts-watch', () => {
  watch(paths.scripts.watch, () => gulp.start('scripts:main'));
});
