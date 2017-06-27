const gulp = require('gulp');
const requireDir = require('require-dir');

requireDir('./gulp/tasks');

gulp.task('default', [
  'images',
  'scripts:dependencies',
  'scripts:main',
  'styles'
]);

gulp.task('watch', [
  'images-watch',
  'scripts-watch',
  'styles-watch'
]);
