<?php

namespace wishlist\view;

class VueGenerale
{

    const ClassicPage = 0;
    const DarkPage = 1;

    static function renderHeader()
    {

        $app = \Slim\Slim::getInstance();
        $urlHome = $app->urlFor('route_home');

        $header = <<<END

        <head>
        <meta charset="utf-8">
        <meta name="robots" content="noindex,nofollow">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="./img/favicon.ico" type="image/x-icon"><link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="$urlHome/style/style.css">
        <title>My Wish List</title>
        </head>
END;
        return $header;
    }

    static function renderNavBarre()
    {

        $app = \Slim\Slim::getInstance();
        $urlHome = $app->urlFor('route_home');
        $urlPPerso = $app->urlFor('route_get_pagePerso');
        $urlConnexion = $app->urlFor('route_connexion');
        $urlDeconnexion = $app->urlFor('route_deconnexion');

        if (isset($_SESSION['session'])) {
            $co = "<div><a href='$urlPPerso'>" . $_SESSION['session']['prenom'] . "</a></div>
            <div><a href='$urlDeconnexion' class = 'disconnect'>Se déconnecter</a>
            </div>";
        } else {
            $co = "<div><a href='$urlConnexion' >Se connecter</a></div>";
        }

        $navBarre = <<<END
        <div id="navBarre"> 
            <div>
                <a href="$urlHome">My Wish List</a>
            </div>
            <div style="flex:1"></div>
            <div>
                <a href="$urlHome" >Page d'accueil</a>
            </div>
            $co
        </div><br>

END;
        return $navBarre;
    }

    static function renderPage($html, $p_theme=self::ClassicPage)
    {

        $header = self::renderHeader();
        $nav = self::renderNavBarre();

        $theme ="";
        switch ($p_theme) {

            case self::DarkPage:
                $theme="accueil";
                break;
            
            default:
                # code...
                break;
        }

        $htmlRender = <<<END

        $header
        
    <body id="$theme">
        $nav
        <section id="mainContent">
        $html
        </section>
        
    </body>

END;

        echo $htmlRender;
    }
}