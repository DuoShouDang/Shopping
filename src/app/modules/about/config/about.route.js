/**
 * Created by Jasmine on 5/13/16.
 */
(function () {
  'use strict';

  angular
    .module('app.about')
    .config(AboutRoute);

  AboutRoute.$inject = ['$stateProvider', '$urlRouterProvider'];

  function AboutRoute($stateProvider, $urlRouterProvider) {
    $stateProvider
      .state('about', {
        controller: 'AboutController',
        controllerAs: 'vm',
        templateUrl: 'app/modules/about/views/about.view.html',
        url: '/about',
        data: {
          pageTitle: 'About us'
        }
      });
  }
})();
