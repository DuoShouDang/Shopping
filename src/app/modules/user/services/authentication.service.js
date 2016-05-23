(function () {
  'use strict';

  angular
    .module('app.user')
    .factory('Authentication', Authentication);

  Authentication.$inject = ['$cookieStore'];

  function Authentication($cookieStore) {
    var auth = this;
    auth.put = putUser;
    auth.get = getUser;
    auth.del = delUser;

    function putUser(credentials) {
      $cookieStore.put('email', credentials.email);
      $cookieStore.put('username', credentials.username);
      $cookieStore.put('token', credentials.token);
      $cookieStore.put('type', credentials.type);
    }

    function getUser() {
      var user = {
        email: $cookieStore.get('email'),
        username: $cookieStore.get('username'),
        token: $cookieStore.get('token'),
        type: $cookieStore.get('type')
      };
      if (user.token) {
        return user;
      }
      return false;
    }

    function delUser() {
      $cookieStore.remove('email');
      $cookieStore.remove('username');
      $cookieStore.remove('token');
      $cookieStore.remove('type');
    }

    return auth;
  }
}());
