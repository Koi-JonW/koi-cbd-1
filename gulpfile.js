const gulp = require('gulp');
const gUtil = require('gulp-util');
const prefix = require('gulp-autoprefixer');
const plumber = require('gulp-plumber');
const sass = require('gulp-sass');
const smaps = require('gulp-sourcemaps');
const browserSync = require('browser-sync').create();
const webpack = require('webpack');

const PATHS = {
  css: {
    input: './src/scss/**/*.scss',
    output: './dist/css',
  },
  js: {
    input: './src/js/**/*.js',
  },
  html: {
    input: './**/*.php',
  },
};

function server(done) {
  browserSync.init({
    files: PATHS.css.output,
    notify: false,
    open: false,
    ghostMode: false,
    proxy: process.env.DOUG_DEV
      ? 'http://localhost:8888/koicbd-new/'
      : 'http://localhost:8888/koicbd/',
  });

  done();
}

function reload(done) {
  browserSync.reload();
  done();
}

function html(done) {
  done();
}

function scss(done) {
  gulp
    .src(PATHS.css.input)
    .pipe(plumber())
    .pipe(smaps.init())
    .pipe(sass({ outputStyle: 'expanded' }))
    .on('error', sass.logError)
    .pipe(
      prefix({
        cascade: false,
      })
    )
    .pipe(smaps.write())
    .pipe(gulp.dest(PATHS.css.output))
    .pipe(browserSync.stream());

  done();
}

function js(done) {
  const webpackCompiler = webpack(require('./webpack.config.js'));

  webpackCompiler.watch({}, (err, stats) => {
    if (err) {
      throw new gUtil.PluginError('webpack', err);
    }

    gUtil.log('[webpack]', stats.toString({ chunks: false }));

    browserSync.reload();
  });

  done();
}

function watcher(done) {
  gulp.watch(PATHS.css.input, gulp.series(scss));
  gulp.watch(PATHS.html.input, reload);
  done();
}

exports.default = gulp.series([html, scss, js, watcher, server]);
