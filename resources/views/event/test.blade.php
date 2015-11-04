<!DOCTYPE html>
<html lang="en" ng-app>
<head>
    <meta charset="UTF-8">
    <title>AngualarJS</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!--AngularJS-->

</head>
<body ng-init="names=[
{'name':'Komsan','country':'Thailand','salary':50000},
{'name':'Peter','country':'USA','salary':95000},
{'name':'Marry','country':'UK','salary':100000},
];price=100;qty=50">
<div class="container" >
    <h2>AngularJS</h2>
    <input type="text" class="form-control" ng-model="text" placeholder="your name">
    <p>Hello World, @{{ text }}</p>
    <input type="number" class="form-control" ng-model="price" placeholder="Price">
    <input type="number" class="form-control" ng-model="qty" placeholder="Quantity">
    <p>Total Price: @{{ price * qty }}</p>
    <br>
    <input type="text" class="form-control" ng-model="queryString.name" placeholder="Filter by">
    <p>Filtered by: @{{ queryString }}</p>
    <input type="radio" value="name" ng-model="sortString">Sorted by Name
    <input type="radio" value="-name" ng-model="sortString">Sorted by Name (Descending)
    <input type="radio" value="country" ng-model="sortString">Sorted by Country

    <p>@{{ sortString }}</p>
    <table class="table">
        <tr ng-repeat="n in names | filter:queryString | orderBy:sortString">
            <td>@{{ n.name  }}</td>
            <td>@{{ n.country }}</td>
            <td>@{{ n.salary | currency:'THB ' }}</td>
        </tr>
    </table>



</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.12/angular.min.js"></script>
</html>