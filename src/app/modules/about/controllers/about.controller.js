/**
 * Created by Jasmine on 5/13/16.
 */
(function () {
  'use strict';

  angular
    .module('app.about')
    .controller('AboutController', AboutController);

  function AboutController() {
    var vm = this;
    vm.content = 'asdasdasd?';
    vm.alert = customAlert;

    function customAlert() {
      alert('Hello!!!');
    }

  }
})();
