var gulp = require('gulp'),
    minifyCSS = require('gulp-minify-css'),
    uglify = require('gulp-uglify'),
    less = require('gulp-less'),
    concat = require('gulp-concat');
    
paths = {
    scripts : 'dev/js/*.js',
    less : 'dev/less/*.less'
}    



gulp.task('script', function(){
    return gulp.src(paths.scripts)
            .pipe(uglify())
            .pipe(concat('site.js'))
            .pipe(gulp.dest('js/'))
})


gulp.task('less', function(){
    return gulp.src(paths.less)
            .pipe(less())
            .pipe(concat('admin.css'))
            .pipe(minifyCSS())
            .pipe(gulp.dest('css/'))
})


gulp.task('watch', function(){
    gulp.watch(paths.scripts, ['script']);
    gulp.watch(paths.less, ['less']);
})


gulp.task('default', ['watch', 'script', 'less'])