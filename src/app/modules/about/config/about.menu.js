/**
 * Created by Jasmine on 5/13/16.
 */
(function () {
  'use strict';

  angular
    .module('app.about')
    .run(menuConfig);

  menuConfig.$inject = ['menuService'];

  function menuConfig(menuService) {
    menuService.addMenuItem('topbar', {
      title: 'About Us',
      state: 'about',
      roles: ['*'],
      position: 100
    });
  }
}());
