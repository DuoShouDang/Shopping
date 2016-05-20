(function () {
  'use strict';

  angular
    .module('app', ['app.core', 'app.home', 'app.about', 'app.user'])
    .run(App);

  function App() {

  }
})();
