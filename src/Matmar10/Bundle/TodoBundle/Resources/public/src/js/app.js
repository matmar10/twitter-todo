/*
angular.module('taskServices', ['ngResource']).
    factory('Task', function ($resource) {
        return $resource('/api/task/:id', {}, {
            query:{
                method:'GET',
                params:{
                    phoneId:'phones'
                },
                isArray: true
            }
        });
    });
*/

function TodoController($scope) {

    var _recalculate = function() {
        $scope.remaining = $scope.todos.length;
        angular.forEach($scope.todos, function(todo) {
            if(todo.done) {
                $scope.remaining--;
            }
        });
    };
/*
    $http.get('/api/tasks').success(function(data) {
        $scope.todos = data;
    });
*/
    // initialize controller's model
    $scope.todos = [
        {
            text: "Meet the ShopSavvy team.",
            done: false
        },
        {
            text: "Build a sample Angular app.",
            done: false
        },
        {
            text: "Make awesome new ShopSavvy web product.",
            done: false
        }
    ];

    // Define member functions
    $scope.addTodo = function() {
        $scope.todos.push({
            text: this.todoText,
            done: false
        });
        $scope.remaining++;
        $scope.todoText = "";
    };

    $scope.handleCompleted = function($todo) {
        _recalculate();
        if($todo.done) {
            $.ajax({
                data: "Finished task: " + $todo.text + "",
                dataType: 'json',
                type: 'POST',
                url: '/api/tweet'
            }).done(function(response) {
                // tweet was OK
            }).fail(function(response) {
                // tweet failed
            });
        }

    };

    $scope.removeDone = function() {
        var todos = $scope.todos;
        $scope.todos = [];
        angular.forEach(todos, function(todo) {
            if (!todo.done) {
                $scope.todos.push(todo);
            }
        });
    };

    // call recalc once to update the model's 'remaining' value
    // Note: this needs to be called after definition
    _recalculate();
}