/**
 * Created by Jasmine on 5/13/16.
 */
(function () {
  'use strict';

  angular
    .module('app.home')
    .controller('HeaderController', HeaderController);

  HeaderController.$inject = ['$scope', '$state', 'menuService'];

  function HeaderController($scope, $state, menuService) {
    var vm = this;

    vm.isCollapsed = true;
    vm.menu = menuService.getMenu('topbar');

    $scope.$on('$stateChangeSuccess', stateChangeSuccess);

    function stateChangeSuccess() {
      // Collapsing the menu after navigation
      vm.isCollapsed = false;
    }
  }
}());
