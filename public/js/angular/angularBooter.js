AngularBooter = function(appName) {
  return {
    config:       [],
    controllers:  {},
    directives:   {},
    dependencies: [],
    filters:      {},
    services:     {},
    appName:      appName ? appName : 'myApp',
    boot: function() {
      var thiz = this;

      //Create The App Module and Inject Any Dependencies
      angular.module(this.appName, this.dependencies);

      //Instantiate All Of Our Registered Services
      angular.forEach(this.services, function (serviceFunction, serviceName) {
        angular.module(thiz.appName).factory(serviceName, serviceFunction);
      });

      //Instantiate our Registered Directives and Controllers
      angular.module(this.appName)
        .directive(this.directives)
        .controller(this.controllers);

      angular.forEach(this.config, function (c) {
        angular.module(thiz.appName).config(c);
      });

      //Instantiate our Registered Filters
      angular.forEach(this.filters, function (filterFunction, filterName) {
        angular.module(thiz.appName).filter(filterName, filterFunction);
      });

    }
  };
}
