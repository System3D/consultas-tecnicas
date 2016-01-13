// public/js/services/ProjectService.js

angular.module('ProjectService', [])

.factory('Project', function($http) {

    function tranlsate( word ) {                
        word = word.replace("#", "/");
        word = word.replace("obras", "projects");
        word = word.replace("clientes", "clients");
        word = word.replace("contatos", "projects");
        word = word.replace("consultas-tecnicas", "technical_consults");
        word = word.replace("etapas", "stages");
        word = word.replace("dicsiplinas", "disciplines");
        return word;
    }

    var urlpathname    	= tranlsate( window.location.pathname );
    var urlhash        	= tranlsate( window.location.hash );
    var apiurl      	= window.location.protocol + '//' + window.location.hostname + '/api';    

    return {
        
        // get all the projects
        get : function(  ) {
            return $http.get( window.location.protocol + '//' + window.location.hostname + '/projects' );
        },

        // save a project (pass in project data)
        save : function( projectData ) {
            return $http({
                method: 'POST',
                url: apiurl + '/projects',
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                data: $.param(projectData)
            });
        },

        // destroy a project
        destroy : function( id ) {
            return $http.delete( apiurl + '/projects/' + id);
        },

    }

});