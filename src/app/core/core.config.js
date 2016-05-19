/*jshint -W030 */
(function () {
  'use strict';

  angular.module('app.core').constant('config', {
    appName: 'Shopping',
    appVersion: '0.1.0'
  });

  // Setting HTML5 Location Mode
  angular
    .module('app.core')
    .config(bootstrapConfig);

  bootstrapConfig.$inject = ['$locationProvider', '$httpProvider'];

  function bootstrapConfig($locationProvider, $httpProvider) {
    $locationProvider.html5Mode(true).hashPrefix('!');
    // 权限的interceptor
    $httpProvider.interceptors.push('authInterceptor');
  }

});
