(function () {
  'use strict';

  angular
    .module('app', ['app.core', 'app.home', 'app.about', 'app.user', 'app.items'])
    .run(App);

  function App() {

  }
})();
