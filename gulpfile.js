const gulp = require('gulp'),
    phpcs = require('gulp-phpcs'),
    sass = require('gulp-ruby-sass'),
    cleanCSS = require('gulp-clean-css'),
    autoprefixer = require('gulp-autoprefixer'),
    rename = require('gulp-rename');

gulp.task('psr-2', () =>
    gulp.src(['src/**/*.php', '!vendor/**/*.*', '!node_modules/**/*.php'])
        .pipe(phpcs({
            bin: 'vendor/bin/phpcs',
            standard: 'PSR2',
            warningSeverity: 0
        }))
        .pipe(phpcs.reporter('log'))
);

gulp.task('sass', () =>
    sass('tw_bootstrap/scss/*.scss')
        .on('error', sass.logError)
        .pipe(gulp.dest('app/Resources/css'))
);

gulp.task('minify-css', ['autoprefixer'], () =>
    gulp.src('app/Resources/css/*.css')
        .pipe(cleanCSS())
        .pipe(rename('bootstrap.min.css'))
        .pipe(gulp.dest('web/css'))
);

gulp.task('autoprefixer', ['sass'], () =>
    gulp.src('app/Ressources/css/*.css')
        .pipe(autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        }))
        .pipe(gulp.dest('app/Ressources/css/*.css'))
);

gulp.task('default', ['psr-2', 'minify-css']);

gulp.task('watch', () => {
    gulp.watch('tw_bootstrap/scss/*.scss', ["sass", "minify-css"]).on('change', (event) => {
        console.log('Le fichier ' + event.path + ' a ete modifier');
    })
});