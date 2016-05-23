/**
 * Created by Jasmine on 5/23/16.
 */
(function () {
  'use strict';

  angular
    .module('app.items')
    .factory('ItemService', ItemService);

  ItemService.$inject = ['$resource'];

  // todo
  function ItemService($resource) {
    return $resource('api/', {
      itemId: 'gid'
    });
  }
}());
