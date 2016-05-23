/**
 * Created by Jasmine on 5/13/16.
 */
(function () {
  'use strict';

  angular
    .module('app.home')
    .controller('HeaderController', HeaderController);

  HeaderController.$inject = ['$scope', '$state', '$http', 'menuService', 'Authentication'];

  function HeaderController($scope, $state, $http, menuService, Authentication) {
    var vm = this;

    vm.isCollapsed = true;
    vm.menu = menuService.getMenu('topbar');
    vm.authentication = Authentication.get();
    vm.logout = logout;

    $scope.$on('$stateChangeSuccess', stateChangeSuccess);

    function stateChangeSuccess() {
      // Collapsing the menu after navigation
      vm.isCollapsed = false;
      vm.authentication = Authentication.get();
    }

    function logout() {
      $http.post('/api/account/logout', vm.authentication).success(function (response) {
        if (response.success) {
          vm.authentication.del();
        }
        $state.go($state.current.state.name);
      }).error(function (response) {
        vm.error = response;
      });
    }
  }
}());
