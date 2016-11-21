'use strict';

var gulp = require('gulp');
var sass = require('gulp-sass');

gulp.task('sass', function () {
  return gulp.src('./assets/sass/main.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest('./dist/css'));
});

gulp.task('sass:watch', function () {
  gulp.watch('./assets/sass/**/*.scss', ['sass']);
  gulp.watch('./assets/sass/**/*.sass', ['sass']);
  gulp.watch('./assets/sass/*.scss', ['sass']);
  gulp.watch('./assets/sass/*.sass', ['sass']);
});
