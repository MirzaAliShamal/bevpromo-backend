<!doctype html>
<html ng-app="app">
  <head>
    <link rel="stylesheet" type="text/css" href="/angular/main.css"/>
    <link rel="stylesheet" type="text/css" href="/angular/ui-grid-unstable.css"/>
  </head>
  <body>
    <div ng-controller="MainCtrl">
      <div class="control-group">
        <input type="button" class="btn btn-small" ng-click="expandAllRows()" value="Expand All"/>
        <input type="button" class="btn btn-small" ng-click="collapseAllRows()" value="Collapse All"/>
      </div>
      <div ui-grid="gridOptions" ui-grid-pinning ui-grid-expandable class="grid"></div>
    </div>
  <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.2.16/angular.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.2.16/angular-touch.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.2.16/angular-animate.js"></script>
  <script src="http://ui-grid.info/docs/grunt-scripts/csv.js"></script>
  <script src="http://ui-grid.info/docs/grunt-scripts/pdfmake.js"></script>
  <script src="http://ui-grid.info/docs/grunt-scripts/vfs_fonts.js" charset="utf-8"></script>
  <script src="/angular/ui-grid-unstable.js" charset="utf-8"></script>
  <script src="/angular/app.js" charset="utf-8"></script>
  </body>
</html>