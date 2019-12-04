<?php

namespace wishlist\view;

class VueHome
{
    public function render()
    {
        $html=<<<END
        <div>
    <a href="./liste" > La liste de toutes les listes </a>
</div>

<div>
    <a href="./item" > La liste de tout les items </a>
</div>

<br>
END;

        VueGenerale::renderPage($html);

    }
}
