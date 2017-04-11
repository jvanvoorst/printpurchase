var gulp = require('gulp'),
	rsync = require('gulp-rsync'),
	gutil = require('gulp-util');

gulp.task('deploy', function() {

		conf = {
		progress: true,
		incremental: true,
		recursive: true,
		emptyDirectories: true,
		root: 'src',
		hostname: 'culibraries01.colorado.edu',
		username: 'vanvoors',
		destination: '/data/web/htdocs/culibraries/printpurchase',
	};

	return gulp.src('src/')
		.pipe(rsync(conf));
});

function throwError(taskName, msg) {
  throw new gutil.PluginError({
      plugin: taskName,
      message: msg
    });
}