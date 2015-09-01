'use strict';
module.exports = function(grunt) {

    require('load-grunt-tasks')(grunt);

    grunt.initConfig({

        watch: {
            options: {
                livereload: true,
                sourcemap: 'none'
            },
            sass: {
                files: ['css/**/*.{scss,sass}'],
                tasks: ['sass']
            }
        },

        sass: {
            dist: {
                options: {
                    style: 'compressed',
                },
                files: {
                    'css/admin/admin-main-style.css': 'css/admin/admin-main-style.scss',
                    'css/calendar.css': 'css/calendar.scss'
                }
            }
        },

        imagemin: {
            dist: {
                options: {
                    optimizationLevel: 7,
                    progressive: true,
                    interlaced: true
                },
                files: [{
                    expand: true,
                    cwd: 'img/',
                    src: ['**/*.{png,jpg,gif,svg}'],
                    dest: 'img/'
                }]
            }
        }

    });

    grunt.registerTask('default',
        ['sass', 'watch']
    );

    grunt.registerTask('image',
        ['imagemin']
    );

};