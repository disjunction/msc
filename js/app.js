function FileTask(file) {
    if (typeof file == 'object') {
        for (var key in file) {
            this[key] = file[key];
        }
    } else {
        this.file = file;
        this.lines = -1;
        this.processed = -1;
    }
}

function TasksController($scope, $http) {
    // uploader has to be re-initialized afetr each use
    $('input[type=file]').bootstrapFileInput();
    
    $scope.loadList = function() {
        $http({method: 'GET', url: 'gw.php'}).
        success(function(data, status, headers, config) {
            $scope.tasks = [];
            if (Array.isArray(data)) {
                $scope.tasks = [];
                for (var i in data) {
                    $scope.tasks.push(new FileTask(data[i]));
                }
            } else {
                console.log("unexpected response: " + data);
            }
        }).
        error(function(data, status, headers, config) {
            alert('error while gettig file list');
        });
        
        // uploader has to be re-initialized after each use, because of DOM reload
        $scope.uploader = new uploader($('input[type=file]').get(0), {
            url: 'gw.php?a=upload',
            success: function() {
                $scope.loadList();
            }
        });
    };

    
    setInterval($scope.loadList, 3000);
    
    $scope.remove = function(task) {
        //console.log( Array.prototype.slice.call(arguments));
        bootbox.confirm("Are you sure you want to delete " + task.file  + "?", function(doIt) {
            if (doIt) {
                $http({method: 'GET', url: 'gw.php', params: {a: 'remove', f: task.file}}).
                success(function(data, status, headers, config) {
                    $scope.loadList();
                });
            }
        });
    }
    
    $scope.loadList();
}
