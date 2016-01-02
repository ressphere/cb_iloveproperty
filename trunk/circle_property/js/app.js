/*global angular */
'use strict';
/**
 * The main app module
 * @name app
 * @type {angular.Module}
 * @requires This js require to include jstorage.min.js in your php script
 */
 
var app = angular.module('app', ['flow'])
  .config(['flowFactoryProvider', function (flowFactoryProvider) {
    flowFactoryProvider.defaults = {
      permanentErrors: [500, 501],
      maxChunkRetries: 1,
      chunkRetryInterval: 5000,
      simultaneousUploads: 1
    };
    // Can be used with different implementations of Flow.js
    flowFactoryProvider.factory = fustyFlowFactory;
  }]);