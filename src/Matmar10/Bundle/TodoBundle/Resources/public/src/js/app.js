

function TodoController($scope) {

    // initialize controller's model
    $scope.todos = [
        {
            text: "learn Angular.js",
            done: false
        },
        {
            text: "build Angular app",
            done: false
        },
        {
            text: "show off Angular app",
            done: false
        }
    ];

    // Define member functions
    $scope.addTodo = function() {
        window.console.log(this);
        $scope.todos.push({
            text: this.todoText,
            done: false
        });
        $scope.remaining++;
        $scope.todoText = "";
    };

    $scope.recalc = function() {
        $scope.remaining = $scope.todos.length;
        angular.forEach($scope.todos, function(todo) {
            if(todo.done) {
                $scope.remaining--;
            }
        });
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
    $scope.recalc();
}