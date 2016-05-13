/**
 * Created by Jasmine on 5/13/16.
 */
(function () {
  'use strict';

  angular.module('app.about').config(HomeRoute);

  HomeRoute.$inject = ['$stateProvider', '$urlRouterProvider'];

  function HomeRoute($stateProvider, $urlRouterProvider) {
    $stateProvider
      .state('about', {
        controller: 'AboutController',
        controllerAs: 'vm',
        templateUrl: 'app/modules/about/views/about.view.html',
        url: '/about'
      });
  }
})();
