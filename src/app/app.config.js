(function () {
  'use strict';

  angular.module('app').config(bootstrapConfig);

  bootstrapConfig.$inject = ['$locationProvider', '$httpProvider'];

  function bootstrapConfig($locationProvider, $httpProvider) {
    $locationProvider.html5Mode(true).hashPrefix('!');
    // 权限的interceptor
    $httpProvider.interceptors.push('authInterceptor');

  }

})();
