exports.browserslist = [
  '> 1%',
  'last 2 versions',
  // 'chrome >= ',
  // 'chromeandroid >= ',
  // 'explorer >= ',
  // 'firefox >= ',
  // 'ios >= ',
  // 'safari >= '
];

exports.paths = {
  images: {
    src: './html/assets/images/**/*',
    dest: './html/assets/images/',
    watch: './html/assets/images/**/*'
  },
  scripts: {
    filename: 'bundle.js',
    src: './html/assets/scripts/components/main.js',
    dest: './html/assets/scripts/',
    watch: './html/assets/scripts/components/*.js'
  },
  styles: {
    src: './html/assets/styles/main.scss',
    dest: './html/assets/styles/',
    watch: './html/assets/styles/**/*.scss'
  }
};
