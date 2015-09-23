"use strict";

angular.module('invoicio', [
    'invoicio.awesome-module'
]).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});