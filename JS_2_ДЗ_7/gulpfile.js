var gulp = require('gulp'),
    jade = require('gulp-jade'),
    browserSync = require('browser-sync'),
    useref = require('gulp-useref'),
    uglify = require('gulp-uglify'),
    minifyCss = require('gulp-minify-css'),
    gulpIf = require('gulp-if');

gulp.task('browserSync', function() {
  browserSync({
    server: {
      baseDir: 'app'
    }
  })
});

gulp.task('Jade', function() {
  return gulp.src('app/templates/*.jade')
         .pipe(jade({
          pretty: true
         }))
         .pipe(gulp.dest('app'))
         .pipe(browserSync.reload({
            stream: true
         }))
});

gulp.task('watch', ['browserSync', 'Jade'], function() {
  gulp.watch('app/templates/*.jade', ['Jade']);
  gulp.watch('app/css/*.css', browserSync.reload);
  gulp.watch('app/js/*.js', browserSync.reload);
});

gulp.task('useref', function() {
  return gulp.src('app/*.html')
    .pipe(gulpIf('*.js', uglify()))
    .pipe(gulpIf('*.css', minifyCss()))
    .pipe(useref())
    .pipe(gulp.dest('dist'))
});