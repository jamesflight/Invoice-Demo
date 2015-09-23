"use strict";

angular.module('invoicio.awesome-module.awesome-directive', [])

.directive('awesomeDirective', function ($interval) {
    return {
        template:"<div>An awesome directive is what I am.</div>"
    };
});