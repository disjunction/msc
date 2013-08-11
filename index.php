<!doctype html>
<html lang="en" ng-app>
<head>
    <meta charset="utf-8">
    <title>MSC Admin</title>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>

    <!-- twitter bootstrap -->
    <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet" />
    <script src="js/bootstrap.file-input.js"></script>
    <script src="js/bootbox.min.js"></script>
    
    <script src="js/angular.min.js"></script>
    
    <!-- simple ajax file uploaded -->
    <script src="js/uploader.js"></script>
    
    <!-- MSC app scipts -->
    <link href="msc.css" rel="stylesheet" />
    <script src="js/app.js"></script>

</head>
<body>
    <div ng-controller="TasksController" id="TasksController">
        <form id="upload-form"><input type="file" title="Upload CSV file" class="btn-primary"></form>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Source File</th>
                    <th>Total Lines</th>
                    <th>Processed</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="task in tasks">
                    <td>
                        {{task.file}}
                        <a ng-show="task.lines>0" href="data/in/{{task.file}}" title="Download"><i class="icon-download"></i></a>
                    </td>
                    <td>{{task.lines}}</td>
                    <td>
                        {{task.processed}}
                        <a ng-show="task.processed" href="data/out/{{task.outfile}}" title="Download"><i class="icon-download"></i></a>
                    </td>
                    <td>
                        <a href="#" ng-click="remove(task)" title="Delete"><i class="icon-remove"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>