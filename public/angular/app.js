
var app = angular.module('app', ['ui.grid', 'ui.grid.expandable']);

app.controller('MainCtrl', ['$scope', '$http', '$log', function ($scope, $http, $log) {
    $scope.gridOptions = {
        expandableRowTemplate: 'expandableRowTemplate.html',
        expandableRowHeight: 150
    }

    $scope.gridOptions.columnDefs = [
        { name: 'program'},
        { name: 'coupon_quantity'},
    ];

    $http.get('/api/test')
        .success(function(data) {
            for(i = 0; i < data.length; i++){
                data[i].subGridOptions = {
                    columnDefs: [ {name:"Id", field:"program"},{name:"Name", field:"coupon_quantity"} ],
                    data: data[i].friends
                }
            }
            $scope.gridOptions.data = data;
        });

    $scope.gridOptions.onRegisterApi = function(gridApi){
        $scope.gridApi = gridApi;
    };

    $scope.expandAllRows = function() {
        $scope.gridApi.expandable.expandAllRows();
    }

    $scope.collapseAllRows = function() {
        $scope.gridApi.expandable.collapseAllRows();
    }
}]);