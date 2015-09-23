"use strict";

angular.module('invoicio.awesome-module.awesome-directive', [])

.directive('awesomeDirective', function ($interval) {
    return {
        template:"<div>An awesome directive is what I am.</div>",
        compile:function () {
            console.log('tet');

            return {
                post:function (scope) {
                    scope.count = 0;
                    console.log(scope.count);

                    $interval(function () {
                        scope.count = scope.count++;
                    }, 1000);
                }
            }
        }
    };
});