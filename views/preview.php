<?php 
//global $dir_name;
//if(isset($_GET['post'])){
//	$image="images/index_".$_GET['post'].".jpg";
//	$filepath = $dir_name.$image ;
//	if(file_exists($filepath)){
//		echo '<img src="' . plugins_url( $image , dirname(__FILE__) ) . '" > ';
//	}else{
//		echo '<img src="' . plugins_url( "images/index.jpg" , dirname(__FILE__) ) . '" > ';
//	}
//}
//else
//	echo '<img src="' . plugins_url( "images/index.jpg" , dirname(__FILE__) ) . '" > ';

?>

<!--<input type="hidden" value="<?php echo plugins_url( '', __FILE__ ); ?>" id="plugin_dir_name" >
<a href="" ng-app="exampleDialog" ng-controller="MainCtrl" ng-click="openTemplate()">Open with external template for modal</a>

<script>
        var app = angular.module('exampleDialog', ['ngDialog']);

        // Example of how to set default values for all dialogs
        app.config(['ngDialogProvider', function (ngDialogProvider) {
            ngDialogProvider.setDefaults({
                className: 'ngdialog-theme-default',
                plain: false,
                showClose: true,
                closeByDocument: true,
                closeByEscape: true,
                appendTo: false,
                preCloseCallback: function () {
                    console.log('default pre-close callback');
                }
            });
        }]);

            app.controller('MainCtrl',['$scope','$rootScope', 'ngDialog', function ($scope, $rootScope, ngDialog) {
            $rootScope.jsonData = '{"foo": "bar"}';
            $rootScope.theme = 'ngdialog-theme-default';

            $scope.directivePreCloseCallback = function (value) {
                if(confirm('Close it? MainCtrl.Directive. (Value = ' + value + ')')) {
                    return true;
                }
                return false;
            };
         

            $scope.openTemplate = function () {
              
                $scope.value = true;

                ngDialog.open({
                    template: document.getElementById('plugin_dir_name').value+'/externalPreview.php',
                    className: 'ngdialog-theme-plain',
                    scope: $scope
                });
            };
        }]);   

    </script>-->


<!--<script type="text/javascript">
        var app = angular.module('MyApp', []);
        app.controller('MyController',['$scope','$http', function ($scope,$http) {
            //This will hide the DIV by default.
            $scope.IsVisible = false;
            $scope.ShowHide = function () {
                //If DIV is visible it will be hidden and vice versa.
                $scope.IsVisible = $scope.IsVisible ? false : true;
                
                //angular.forEach(element.find('input'), function(input){ 
//                $('#' + post).find('input').each(function (idx, input) {
//            // Do your DOM manipulation here
//            alert($(input).val());
//        });
var formElements = new Array();
jQuery("form :input").each(function(){
    formElements.push([jQuery(this).attr('name'),jQuery(this).val()]);
});
alert(formElements);
//       jQuery(function(jQuery) { 
//        jQuery('input,select').each(
//            function(index){  
//                var input = jQuery(this);
//                alert('Type: ' + input.attr('type') + 'Name: ' + input.attr('name') + 'Value: ' + input.val());
//            }
//        ); 
//});
//                var dataObj = {
//				name : "asmaa",
//				employees : "eng"
//				
//		};	
                $http.post(document.getElementById('plugin_dir_name').value+'/externalPreview.php',formElements).success(function(data){
                 // alert(dataObj);
                  //$scope.ajax_data=data;
              });
            };
             
        }]);
    </script>
    <input type="hidden" value="<?php echo plugins_url( '', __FILE__ ); ?>" id="plugin_dir_name" >
    <div ng-app="MyApp" ng-controller="MyController">
        <input type="button" value="priview" ng-click="ShowHide()" />
        <br />
        <br />
        <div ng-show = "IsVisible">
            
            <?php 
//global $dir_name;
//if(isset($_GET['post'])){
//	$image="images/index_".$_GET['post'].".jpg";
//	$filepath = $dir_name.$image ;
//	if(file_exists($filepath)){
//		echo '<img src="' . plugins_url( $image , dirname(__FILE__) ) . '" > ';
//	}else{
//		echo '<img src="' . plugins_url( "images/index.jpg" , dirname(__FILE__) ) . '" > ';
//	}
//}
//else
//	echo '<img src="' . plugins_url( "images/index.jpg" , dirname(__FILE__) ) . '" > ';

?>
            
        </div>
    </div>-->
  
<input type="button" value="priview" id="preview_btn" class="button button-primary button-large" />
<div id="dialog" title="preview">
<?php 
global $dir_name;
if(isset($_GET['post'])){
	$image="images/index_".$_GET['post'].".jpg";
	$filepath = $dir_name.$image ;
	if(file_exists($filepath)){
		echo '<img src="' . plugins_url( $image , dirname(__FILE__) ) . '" > ';
	}else{
		echo '<img src="' . plugins_url( "images/index.jpg" , dirname(__FILE__) ) . '" > ';
	}
}
else
	echo '<img src="' . plugins_url( "images/index.jpg" , dirname(__FILE__) ) . '" > ';

?>
</div>
 