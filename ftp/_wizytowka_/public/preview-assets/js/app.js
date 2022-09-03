(function() {

    var app = angular.module('templatesPreview', []);

    app.controller('templatesPrevievController', function($scope, $sce, $location) {

        $scope.templatesRepository = previewSettings.templatesRepository;;
        $scope.currentTemplate = previewSettings.defaultTemplate;
        //$scope.hash = $location.search().hash;
        $scope.hideNavi = false;

        $scope.getIframePath = function() {
            return $sce.trustAsResourceUrl(previewSettings.templatePreviewUrl + $scope.currentTemplate);
        }

        $scope.windowResize = function() {
            setTimeout(function() {
                $(window).resize();
            }, 100);
        }

        $scope.triggerMinimalizationGa = function() {
            if($scope.hideNavi) {
                _gaq.push(['_trackEvent','podglad_wizytowki','strzalka', 'zwin']);
            } else {
                _gaq.push(['_trackEvent','podglad_wizytowki','strzalka', 'rozwin']);
            }
        }

        $scope.$watch('currentTemplate',
            function(newValue, oldValue) {
                _gaq.push(['_trackEvent','podglad_wizytowki',newValue, 'Zaznaczony']);
            }
        );

    });

})();


$(document).ready(function() {
    $(window).resize(function() {
        resizeDemoFrame($(window).height());
    }).resize();
});

var resizeDemoFrame = function(windowHeight) {
    var frameHeight = windowHeight - $('#templatesNavi').outerHeight();
    $('#templateFrame').css({'height' : frameHeight});
};