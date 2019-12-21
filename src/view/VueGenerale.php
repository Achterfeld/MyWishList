<?php

namespace wishlist\view;

class VueGenerale
{

    static function renderHeader()
    {
        $header=<<<END

        <head>
        <meta charset="utf-8">
        <meta name="robots" content="noindex,nofollow">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="./img/favicon.ico" type="image/x-icon"><link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="/myWishList/style/style.css">
        <title>My Wish List</title>
        </head>
END;
return $header;
    }

    static function renderNavBarre()
    {
        if (isset($_SESSION['session'])) {
            $co = '<div><a href="/myWishList/pagePerso">'.$_SESSION['session']['prenom'].'</a></div>';
        } else {
            $co = '<div><a href="/myWishList/connexion" >Se connecter</a></div>';
        }

        $navBarre=<<<END
        <div id="navBarre"> 
        <div> <a href="/myWishList">My Wish List</a></div>
        <div style="flex:1"></div>
        $co
        <div><a href="./" >Page d'accueil</a></div>
        </div><br>

END;
return $navBarre;
    }

    static function renderPage($html){

        $header = self::renderHeader();
        $nav = self::renderNavBarre();


        $htmlRender =<<<END
        
        $header
        $nav
        $html

END;

        echo $htmlRender;
    }

}
