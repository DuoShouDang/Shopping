/**
 * Created by Jasmine on 5/19/16.
 */
(function () {
  'use strict';

  angular
    .module('app.core')
    .factory('authInterceptor', authInterceptor);

  authInterceptor.$inject = ['$q', '$injector'];

  function authInterceptor($q, $injector) {
    var service = {
      responseError: responseError
    };

    return service;

    // http response 错误时处理
    // todo: 测试文件
    function responseError(rejection) {
      switch (rejection.status) {
        case 401:
          // todo: 删除浏览器中user的数据
          $injector.get('$state').transitionTo('authentication.signin');
          break;
        case 403:
          // todo: forbidden页面
          // $injector.get('$state').transitionTo('forbidden');
          break;
      }
      // 否则执行默认
      return $q.reject(rejection);
    }

  }
}());
