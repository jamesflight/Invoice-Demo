var gulp = require('gulp');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var ngAnnotate = require('gulp-ng-annotate');
var sourcemaps = require('gulp-sourcemaps');
var jshint = require('gulp-jshint');
var cache = require('gulp-cache');

gulp.task('buildJs', function(){
    gulp.src('public/assets/js/main.js')
        .pipe(uglify())
        .pipe(concat('main.min.js'))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('public/assets/js'));
});

gulp.task('buildJs', function(){
    return gulp.src([
        'bower_components/angular/angular.min.js',
        'public/js/src/**/*.js'
    ])
        .pipe(sourcemaps.init())
        .pipe(cache(ngAnnotate()))
        .pipe(cache(uglify()))
        .pipe(concat('main.min.js'))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('public/js/dist'));
});

gulp.task('lint', function(){
    return gulp.src(['public/js/src/**/*.js'])
        .pipe(jshint({
            globalstrict:true,
            "predef": ["angular"]
        }))
        .pipe(jshint.reporter('default'))
});

gulp.task('js',['buildJs']);

gulp.task('default',['lint', 'buildJs']);

gulp.task('watch', function() {
    gulp.watch('public/js/src/**/*.*', ['default']);
});
