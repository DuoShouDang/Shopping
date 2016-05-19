(function () {
  'use strict';

  angular
    .module('app.user')
    .controller('AuthenticationController', AuthenticationController);

  AuthenticationController.$inject = ['$scope', '$state', '$http'];

  function AuthenticationController($scope, $state, $http) {
    var vm = this;
    vm.signin = signin;

    function signin(isValid) {
      if (isValid) {
        alert(vm.inputVal);
      }
      $http.post('/api/account/register').success(function (response) {
        console.log(response)
      }).error(function (response) {
        console.log(response)
      });
    }

  }

})();
