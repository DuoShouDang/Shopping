/**
 * Created by Jasmine on 5/23/16.
 */
(function () {
  'use strict';

  angular
    .module('app.items')
    .run(menuConfig);

  menuConfig.$inject = ['menuService'];

  function menuConfig(menuService) {
    menuService.addMenuItem('topbar', {
      title: 'Items',
      state: 'items.list',
      position: 0
    });

  }
}());
