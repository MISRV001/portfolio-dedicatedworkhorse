var app = angular.module('myApp', ['ngRoute']);

app.config(['$routeProvider', function($routeProvider) {
	$routeProvider.
		when('/home', {
			templateUrl: 'home/home.html',
			controller: 'homeController'
		}).
		when('/resume', {
			templateUrl: 'resume/resume.html',
			controller: 'resumeController'
		}).
		when('/projects', {
			templateUrl: 'projects/projects.html',
			controller: 'projectsController'
		}).
		when('/projects/parallax', {
			templateUrl: 'projects/parallax/parallax.html',
			controller: 'parallaxController'
		}).
		when('/contact', {
			templateUrl: 'contact/contact.html',
			controller: 'contactController'
		}).
		when('/about', {
			templateUrl: 'about/about.html',
			controller: 'aboutController'
		}).
		otherwise({
			redirectTo: '/home'
		});
}]);
