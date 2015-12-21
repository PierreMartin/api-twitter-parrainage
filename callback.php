<?php
    ini_get('display_errors');
    session_start();

    require 'vendor/abraham/twitteroauth/autoload.php';
    use Abraham\TwitterOAuth\TwitterOAuth;

    define('CONSUMER_KEY', ("Cxn4HC5yMIRcJ9qIRC4pcL7Up"));
    define('CONSUMER_SECRET', ("GuqC2Cmj38BEqdlpwYZLknegOHAV4Dd7RWK8IKv6XwG5eG1QmH"));
    define('OAUTH_CALLBACK', ("https://dev.socialshaker.com/pierre/twitter_partnership_popupV2/callback.php"));

    $request_token = [];
    $request_token['oauth_token']           = $_SESSION['oauth_token'];
    $request_token['oauth_token_secret']    = $_SESSION['oauth_token_secret'];

    if (isset($_REQUEST['oauth_token']) && $request_token['oauth_token'] !== $_REQUEST['oauth_token']) {
        echo 'erreur...';
    } else {
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $request_token['oauth_token'], $request_token['oauth_token_secret']);
        $access_token = $connection->oauth("oauth/access_token", array("oauth_verifier" => $_REQUEST['oauth_verifier']));

        $_SESSION['access_token'] = $access_token; // on garde notre token de connection en session (variable a mettre sur toutes les pages)


        /* ######################### Connection : ######################### */
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

        // API REST :
        $friends = $connection->get("friends/list");

    }
?>

<!DOCTYPE html>
<html ng-app="socialshakerApp" ng-controller="AppController">
<head>
    <meta charset="utf-8">
    <title>test</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="twitter_popup_title">
        <h2>Sélectionnez des amis pour les demandes de game2</h2>
    </div>

    <div class="uiHeaderSection">
        <label>set your message to send :</label>
        <input type="text" ng-model="message">
    </div>

    <div class="uiHeaderSection" ng-show="showNomber_send">
        Nombre d'invitation envoyé : {{ nomber_send }}
        <br>
        <hr>
        Vous avez invité :
        <br>
        <strong ng-repeat="friendSended in friendsSended">
            {{ friendSended }},&nbsp;
        </strong>
    </div>


    <ul class="friends">
        <!--<form action="#">-->
        <div class="uiHeaderSection">Amis suggérés</div>

        <li class="friend" ng-repeat="friend in friends.users" ng-hide="friend.hideFriend">
            <div class="friend_infos">
                <img src="{{ friend.profile_image_url }}" alt="friend image from twitter">
                <strong>{{ friend.name }}</strong>
            </div>

            <input type="checkbox" class="checkbox_twitter" ng-true-value="Y" ng-false-value="N"/>
        </li>

        <div class="uiHeaderSection"><button type="button" ng-click="check(friends.users)" class="btn_twitter btn btn-default">Envoyer les invitations</button></div>{{ friend }}
        <div>Valeurs selectionnées : {{ chkselected }}<div>
       <!-- </form>-->
    </ul>


    <script src="node_modules/angular/angular.min.js"></script>
    <script>

        // 1) enregister tous les checkbox cliqués (dans un tableau)
        // 2) faire une boucle qui permettra de changer la var $screen_name dans send.php

        // from php to js :
        var friends = <?php echo json_encode($friends); ?>;
        /*var friends = [];
        console.log(friends);*/

        var app = angular.module('socialshakerApp', []);

        app.controller('AppController', ['$scope', '$http', function ($scope, $http) {
            $scope.friends          = friends;
            $scope.friendsSended    = [];
            $scope.nomber_send      = 0;
            $scope.message          = 'Come play...';
            $scope.friendSended = ''; // a changer


            $scope.chkselected = [];
            //$scope.friends.users    = [{id:1},{id:2}]; // only test here
            var arr         = [];
            $scope.check= function(data) {
                var arr = [];
                for(var i in data){
                    if(data[i].CHKSELECTED=='Y'){
                        arr.push(data[i].id);
                    }
                }
                console.log(arr);
                $scope.chkselected = arr;
                // Do more stuffs here
            };









            // when to submit form :
            /*$scope.removeFriends = function() {

                // remove friend
                //friend.hideFriend = true;
                $scope.nomber_send ++;

                if ($scope.nomber_send >= 1) {
                    $scope.showNomber_send = true;
                }

                $scope.friendsSended.push(friend.name);
                //console.log($scope.friendsSended);


                // send tweet :
                var screen_name = friend.screen_name;


                $http({
                    method: "GET",
                    url: 'send.php?screen_name='+screen_name+'&message='+$scope.message
                }).then(function successCallback(response) {
                    //console.log(response);
                }, function errorCallback(response) {
                    console.log(response);
                });


            };*/


        }]);

    </script>
</body>
</html>