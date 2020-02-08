App = Ember.Application.create();

App.Router.map(function() {
  // put your routes here
});

App.IndexRoute = Ember.Route.extend({
  model: function() {
    return jQuery.getJSON('../../road_to_eurocup/get.php');
  }
});
