'use strict';

var gulp = require('gulp');
var sass = require('gulp-sass');
var uglify = require('gulp-uglify');
var pump = require('pump');

gulp.task('sass', function () {
  return gulp.src('./assets/sass/main.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest('./dist/css'));
});

gulp.task('watch', function () {
  gulp.watch('./assets/sass/**/*.scss', ['sass']);
  gulp.watch('./assets/sass/**/*.sass', ['sass']);
  gulp.watch('./assets/sass/*.scss', ['sass']);
  gulp.watch('./assets/sass/*.sass', ['sass']);

  gulp.watch('./assets/js/*.js', ['compress']);
});

gulp.task('compress', function (cb) {
  pump([
        gulp.src('./assets/js/*.js'),
        uglify(),
        gulp.dest('./dist/js')
    ],
    cb
  );
});
