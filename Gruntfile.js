
module.exports = function (grunt) {
    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        /**
         * sass task
         */
        sass: {// Task
            dev: {// Target
                options: {// Target options
                    style: 'expanded',
                    sourcemap: 'none'
                },
                files: {// Dictionary of files
                    'wp-content/themes/schwulissimo/css/readable-style.scss': 'wp-content/themes/schwulissimo/sass/style.scss', // 'destination': 'source'

                }
            },
            dist: {// Target
                options: {// Target options
                    style: 'compressed',
                    sourcemap: 'none'
                },
                files: {// Dictionary of files
                    'wp-content/themes/schwulissimo/css/style.css': 'wp-content/themes/schwulissimo/sass/style.scss',       // 'destination': 'source'

                }
            }
      },
     
        autoprefixer: {
            options: {
                browsers: ['last 2 versions']
            },
            multiple_files: {
                expand: true,
                flatten: true,
                src: 'wp-content/themes/schwulissimo/css/style.css',
                dest: 'wp-content/themes/schwulissimo/'
            },
      },
      
        uglify: {
            options: {
                mangle: {
                    except: ['jQuery', 'Backbone', 'markers']
                },
                  
            },
            my_target: {
                files: {
                    'wp-content/themes/schwulissimo/js/main.min.js': ['wp-content/themes/schwulissimo/js/dev/bootstrap.js', 'wp-content/themes/schwulissimo/js/dev/main.js'],
                    'wp-content/themes/schwulissimo/js/cityguide-archive.min.js': ['wp-content/themes/schwulissimo/js/dev/cityguide-archive.js'],
                    'wp-content/themes/schwulissimo/js/cityguide-single.min.js': ['wp-content/themes/schwulissimo/js/dev/cityguide-single.js'],
                    'wp-content/themes/schwulissimo/js/archive-partypics.min.js': ['wp-content/themes/schwulissimo/js/dev/archive-partypics.js'],
                    'wp-content/themes/schwulissimo/js/single-partypics.min.js': ['wp-content/themes/schwulissimo/js/dev/single-partypics.js'],
                    'wp-content/themes/schwulissimo/js/archive-veranst.min.js': ['wp-content/themes/schwulissimo/js/dev/archive-veranst.js']
                }
            },
          
      },
      
        ftpPut: {
            options: {
                host: 'ftp94.world4you.com',
                user: 'ftp6975094',
                pass: 'xquhbwp02'
            },
            upload: {
                files: {
                    'wp-content/themes/schwulissimo/style.css': 'wp-content/themes/schwulissimo/style.css'
                }
            }
        },
        
        chokidar: {
            scripts: {
                files: ['**/*.scss', '**/*.js'],
                tasks: ['sass', 'autoprefixer', 'uglify'],
                options: {
                    spawn: false,
                }
            }
        }
    });
    grunt.loadNpmTasks('grunt-ftp');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-autoprefixer');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-chokidar');
    grunt.registerTask('default', ['chokidar']);
};
