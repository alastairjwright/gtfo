const gulp = require('gulp');
const imagemin = require('gulp-imagemin');
const watch = require('gulp-watch');

const paths = require('../config').paths;

const ENVIRONMENT = process.env.NODE_ENV;

gulp.task('images', () => {
  return gulp
    .src(paths.images.src)
    .pipe(imagemin({
      optimizationLevel: ENVIRONMENT === 'production' ? 7 : 0,
      progressive: true,
      interlaced: true,
      multipass: true,
      svgoPlugins: [{removeViewBox: false}]
    }))
    .pipe(gulp.dest(paths.images.dest));
});

gulp.task('images-watch', () => {
  watch(paths.images.watch, () => gulp.start('images'));
});
