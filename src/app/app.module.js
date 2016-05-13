(function () {
  'use strict';

  angular
    .module('app', ['app.core', 'app.home', 'app.about'])
    .run(App);

  function App() {

  }
})();
