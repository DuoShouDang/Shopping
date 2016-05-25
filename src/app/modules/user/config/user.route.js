/**
 * Created by Jasmine on 5/18/16.
 */
(function () {
  'use strict';

  angular
    .module('app.user')
    .config(UserRoute);

  UserRoute.$inject = ['$stateProvider', '$urlRouterProvider'];

  function UserRoute($stateProvider, $urlRouterProvider) {
    $stateProvider
      .state('authentication', {
        abstract: true,
        templateUrl: 'app/modules/user/views/authentication.view.html',
        url: '/authentication',
        controller: 'AuthenticationController',
        controllerAs: 'vm'
      })
      .state('authentication.signup', {
        url: '/signup',
        templateUrl: 'app/modules/user/views/signup.view.html',
        controller: 'AuthenticationController',
        controllerAs: 'vm',
        data: {
          pageTitle: 'Signup'
        }
      })
      .state('authentication.signin', {
        url: '/signin?err',
        templateUrl: 'app/modules/user/views/signin.view.html',
        controller: 'AuthenticationController',
        controllerAs: 'vm',
        data: {
          pageTitle: 'Signin'
        }
      })
  }
})();
