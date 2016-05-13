(function () {
  'use strict';

  angular.module('app.home').config(HomeRoute);

  HomeRoute.$inject = ['$stateProvider', '$urlRouterProvider'];

  function HomeRoute($stateProvider, $urlRouterProvider) {
    $stateProvider
      .state('home', {
        controller: 'HomeController',
        controllerAs: 'vm',
        templateUrl: 'app/modules/home/views/home.view.html',
        url: '/'
      });
  }
})();
