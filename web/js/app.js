(function () {

    var app = angular.module('player', []);

    app.controller('PlayerController', function () {
        this.player = player;
    });

    app.controller('PanelController', function () {
        this.tab = 1;

        this.selectTab = function (setTab) {
            this.tab = setTab;
        };

        this.isSelected = function (checkTab) {
            return this.tab === checkTab;
        };
    });

    app.controller('InfoController',['$http',function($http){
            var player = this;
            player.info=[];
            $http.get('http://clanmanager/app_dev.php/player/info/1').success(function(data){
               player.info=data;
            });
    }]);

    app.controller('WarrecordController',['$http',function($http){
            var player = this;
            player.wars=[];
            $http.get('http://clanmanager/app_dev.php/player/warrecord/1').success(function(data){
               player.wars=data;
            });
    }]);

    var player = {
        id: 1,
        tag: '#12345678',
        name: 'RobH',
        th: 9,
    };

})();