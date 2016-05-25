/**
 * Created by Jasmine on 5/23/16.
 */
(function () {
  'use strict';

  angular
    .module('app.items')
    .config(ItemsRoute);

  ItemsRoute.$inject = ['$stateProvider', '$urlRouterProvider'];

  function ItemsRoute($stateProvider, $urlRouterProvider) {
    $stateProvider
      .state('items', {
        abstract: true,
        url: '/items',
        template: '<ui-view/>'
      })
      .state('items.list', {
        url: '',
        templateUrl: 'app/modules/items/views/list-items.view.html',
        controller: 'ListItemsController',
        controllerAs: 'vm',
        data: {
          pageTitle: 'Items List'
        }
      })
      .state('items.view', {
      url: '/:itemId',
      templateUrl: 'app/modules/items/views/view-item.view.html',
      controller: 'ItemsController',
      controllerAs: 'vm',
      resolve: {
        itemResolve: getItem
      },
      data: {
        pageTitle: 'Item info'
      }
    });
  }

  getItem.$inject = ['$stateParams', 'ItemService'];

  function getItem($stateParams, ItemService) {
    return ItemService.get({
      itemId: $stateParams.itemId
    }).$promise;
  }

})();
