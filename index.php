<!doctype html>
<html lang="en" ng-app>
    <head>
    <meta charset="utf-8">
    <title>MSC Admin</title>
    <link rel="stylesheet" href="css/app.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="js/angular.min.js"></script>
    <script src="js/FileTask.js"></script>
    <script src="js/app.js"></script>
    </head>
    <body>
        <div ng-controller="TasksController">
            <table>
                <thead>
                    <tr>
                        <th>File</th>
                        <th>Total Lines</th>
                        <th>Processed</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="task in tasks">
                        <td>{{task.file}}</td>
                        <td>{{task.lines}}</td>
                        <td>{{task.processed}}</td>
                        <td>X</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>