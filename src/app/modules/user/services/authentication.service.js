(function () {
  'use strict';

  angular
    .module('app.user')
    .factory('Authentication', Authentication);

  Authentication.$inject = ['$window', '$cookieStore'];

  function Authentication($window, $cookieStore) {
    var auth = this;
    auth.put = putUser;
    auth.get = getUser;
    auth.del = delUser;

    function putUser(credentials) {
      $window.user = credentials;
      $cookieStore.put("token", credentials.token);
    }

    function getUser() {
      return $window.user;
    }

    function delUser() {
      $window.user = null;
      $cookieStore.remove("token");
    }

    return auth;
  }
}());
