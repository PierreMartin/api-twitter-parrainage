<?php

    ini_get('display_errors');
    session_start();

    require 'vendor/abraham/twitteroauth/autoload.php';
    use Abraham\TwitterOAuth\TwitterOAuth;

    define('CONSUMER_KEY', ("Cxn4HC5yMIRcJ9qIRC4pcL7Up"));
    define('CONSUMER_SECRET', ("GuqC2Cmj38BEqdlpwYZLknegOHAV4Dd7RWK8IKv6XwG5eG1QmH"));
    define('OAUTH_CALLBACK', ("https://dev.socialshaker.com/pierre/twitter_partnership_popupV2/callback.php"));
    $access_token           = "2232715033-2dTR8gMW08ctb0O6gunS3l5dfl0CfzgQQkjf8GW";
    $access_token_secret    = "mpvSoc35wAtl7j6js4ghIleg2lLaGvXomSaEMP4LGlVvJ";


    /* ######################### CONNECTION ########################## */
    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token, $access_token_secret);


    $request_token  = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));
    $_SESSION['oauth_token']        = $request_token['oauth_token'];
    $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

    $url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>test</title>

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/styles.css">
    </head>
    <body>

        <h2>
            <a href="#" onclick="javascript:open_infos();" class="btn_twitter btn btn-default">Inviter des amis sur twitter - dans popup</a>
        </h2>



        <h2>
            <a href="<?php echo $url; ?>" class="btn_twitter btn btn-default">Inviter des amis sur twitter - sans popup</a>
        </h2>




        <script>
            function open_infos() {
                var width      = 700;
                var height     = screen.height / 2;


                // from php to js :
                var url = <?php echo json_encode($url); ?>;
                console.log(url);

                var myPopup = window.open(
                    url,
                    'nom_de_ma_popup',
                    'menubar=no, scrollbars=no, top=200, left=300, width='+width+', height='+height+' '
                );

                myPopup.opener = window;

            }
        </script>
    </body>
</html>