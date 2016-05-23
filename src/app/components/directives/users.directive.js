/**
 * Created by Jasmine on 5/23/16.
 */
(function () {
  'use strict';

  // Users directive used to force lowercase input
  angular
    .module('app.user')
    .directive('lowercase', lowercase);

  function lowercase() {
    var directive = {
      require: 'ngModel',
      link: link
    };

    return directive;

    function link(scope, element, attrs, modelCtrl) {
      modelCtrl.$parsers.push(function (input) {
        return input ? input.toLowerCase() : '';
      });
      element.css('text-transform', 'lowercase');
    }
  }
}());
