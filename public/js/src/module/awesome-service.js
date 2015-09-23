"use strict";

angular.module('invoicio.awesome-module.awesome-service', [])

.factory('awesomeService', function () {
    return {
        getMessage:function () {
            return "This message was returned from the awesomeService";
        }
    };
});