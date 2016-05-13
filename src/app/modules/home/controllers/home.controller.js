(function () {
  'use strict';

  angular
    .module('app.home')
    .controller('HomeController', HomeController);

  function HomeController() {
    var vm = this;
    vm.heading = 'Hello World!';
    vm.content = 'This is an example AngularJS seed by Big Green Snake. ';
  }
})();
