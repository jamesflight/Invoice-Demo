"use strict";

angular.module('invoicio.awesome-module.awesome-controller', [])

.controller('awesomeController', function ($scope, awesomeService) {
    $scope.message = "This is on the awesome controller scope.";

    $scope.message2 = awesomeService.getMessage();
});