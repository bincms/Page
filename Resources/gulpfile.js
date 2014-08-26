var gulp = require('gulp');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var templateCache = require('gulp-angular-templatecache');
var sourcemaps = require('gulp-sourcemaps');
var runSequence = require('run-sequence');
var clean = require('gulp-clean');

gulp.task('build', function() {
    runSequence('build-clean', ['build-scripts', 'build-rest', 'build-templates']);
});

gulp.task('build-clean', function() {
    return gulp.src(['public/dist/*']).pipe(clean());
});

gulp.task('build-templates', function() {
    return gulp.src(['public/admin/views/**/*.html'])
        .pipe(templateCache('templates.js', {module: 'bincms.admin.page.templates', standalone: true, root: 'admin/page'}))
        .pipe(uglify())
        .pipe(gulp.dest('public/dist'));
});

gulp.task('build-rest', function () {
    return gulp.src([
            'public/rest/**/*.js'
        ])
        .pipe(sourcemaps.init())
        .pipe(concat('public/dist/rest.js'))
        .pipe(uglify())
        .pipe(gulp.dest('.'));
});

gulp.task('build-scripts', function () {
    return gulp.src([
            'public/admin/scripts/*.js',
            'public/admin/scripts/**/*.js'
        ])
        .pipe(sourcemaps.init())
        .pipe(concat('public/dist/admin.js'))
        .pipe(uglify())
//        .pipe(sourcemaps.write())
        .pipe(gulp.dest('.'));
});