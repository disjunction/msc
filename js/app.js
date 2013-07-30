function TasksController($scope, $http) {
    $http({method: 'GET', url: 'gw.php'}).
    success(function(data, status, headers, config) {
        $scope.tasks = [];
        for (var i in data) {
            $scope.tasks.push(new FileTask(data[i]));
        }
    }).
    error(function(data, status, headers, config) {
        alert('error while gettig file list');
    });
}
