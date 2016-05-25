(function () {
  'use strict';

  angular
    .module('app.user')
    .controller('AuthenticationController', AuthenticationController);

  AuthenticationController.$inject = ['$scope', '$state', '$location', '$http', 'md5', 'Authentication'];

  function AuthenticationController($scope, $state, $location, $http, md5, Authentication) {
    var vm = this;
    vm.authentication = Authentication;
    vm.signup = signup;
    vm.signin = signin;

    vm.error = $location.search().err;

    // 如果已登陆, 跳转到首页
    if (vm.authentication.get()) {
      $location.path('/');
    }

    // 注册
    function signup(isValid) {
      vm.error = null;

      if (!isValid) {
        $scope.$broadcast('show-errors-check-validity', 'vm.userForm');
        return false;
      }

      vm.credentials.password = md5.createHash(vm.credentials.password);
      $http.post('/api/account/register', vm.credentials).success(function (response) {
        if (response.success) {
          vm.authentication.put({
            email : vm.credentials.email,
            username: vm.credentials.username,
            token: response.successInfo,
            type: 'user'
          });
          $state.go($state.previous.state.name || 'home', $state.previous.params);
        } else {
          vm.error = response.errorInfo;
        }
      }).error(function (response) {
        vm.error = response;
      });
    }

    // 登陆
    function signin(isValid) {
      vm.error = null;

      if (!isValid) {
        $scope.$broadcast('show-errors-check-validity', 'vm.userForm');
        return false;
      }

      vm.credentials.password = md5.createHash(vm.credentials.password);
      $http.post('/api/account/login', vm.credentials).success(function (response) {
        if (response.success) {
          vm.authentication.put({
            email : vm.credentials.email,
            username: vm.credentials.username,
            token: response.successInfo.token,
            type: response.successInfo.type
          });
          $state.go($state.previous.state.name || 'home', $state.previous.params);
        } else {
          vm.error = response.errorInfo;
        }
      }).error(function (response) {
        vm.error = response;
      });
    }

  }

})();
