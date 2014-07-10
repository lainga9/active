(function(name, definition) {
    if (typeof module != 'undefined') module.exports = definition();
    else if (typeof define == 'function' && typeof define.amd == 'object') define(definition);
    else this[name] = definition();
}('Router', function() {
  return {
    routes: [{"uri":"\/","name":"admin"},{"uri":"activities","name":"activities.index"},{"uri":"activities\/create","name":"activities.create"},{"uri":"activities","name":"activities.store"},{"uri":"activities\/{activities}","name":"activities.show"},{"uri":"activities\/{activities}\/edit","name":"activities.edit"},{"uri":"activities\/{activities}","name":"activities.update"},{"uri":"activities\/{activities}","name":"activities.destroy"},{"uri":"classTypes","name":"classTypes.index"},{"uri":"classTypes\/create","name":"classTypes.create"},{"uri":"classTypes","name":"classTypes.store"},{"uri":"classTypes\/{classTypes}","name":"classTypes.show"},{"uri":"classTypes\/{classTypes}\/edit","name":"classTypes.edit"},{"uri":"classTypes\/{classTypes}","name":"classTypes.update"},{"uri":"classTypes\/{classTypes}","name":"classTypes.destroy"},{"uri":"bookActivity\/{id}","name":"activity.book"},{"uri":"favourites","name":"favourites"},{"uri":"addFavourite","name":"activity.addFavourite"},{"uri":"removeFavourite","name":"activity.removeFavourite"},{"uri":"search","name":"search"},{"uri":"search","name":"search.results"},{"uri":"profile\/edit","name":"profile.edit"},{"uri":"users","name":"users.index"},{"uri":"users\/create","name":"users.create"},{"uri":"users","name":"users.store"},{"uri":"users\/{users}","name":"users.show"},{"uri":"users\/{users}","name":"users.update"},{"uri":"users\/{users}","name":"users.destroy"},{"uri":"login","name":"getLogin"},{"uri":"login","name":"postLogin"},{"uri":"logout","name":"getLogout"},{"uri":"passwordReminder","name":"password.reminder"},{"uri":"passwordReminder","name":"password.reminder"},{"uri":"password\/reset\/{token}","name":"password.reset"},{"uri":"passwordReset","name":"password.reset"}],
    route: function(name, params) {
      var route = this.searchRoute(name),
          rootUrl = this.getRootUrl();

      if (route) {
        var compiled = this.buildParams(route, params);
        return rootUrl + '/' + compiled;
      }

    },
    searchRoute: function(name) {
      for (var i = this.routes.length - 1; i >= 0; i--) {
        if (this.routes[i].name == name) {
          return this.routes[i];
        }
      }
    },
    buildParams: function(route, params) {
      var compiled = route.uri,
          queryParams = {};

      for(var key in params) {
        if (compiled.indexOf('{' + key + '}') != -1) {
          compiled = compiled.replace('{' + key + '}', params[key]);
        } else {
          queryParams[key] = params[key];
        }
      }

      if (!this.isEmptyObject(queryParams)) {
        return compiled + this.buildQueryString(queryParams);
      }

      return compiled;
    },
    getRootUrl: function() {
      return window.location.protocol + '//' + window.location.host + '/active/public';
    },
    buildQueryString: function(params) {
      var ret = [];
      for (var key in params) {
        ret.push(encodeURIComponent(key) + "=" + encodeURIComponent(params[key]));
      }
      return '?' + ret.join("&");
    },
    isEmptyObject: function(obj) {
      var name;
      for (name in obj) {
        return false;
      }
      return true;
    }
  };
}));