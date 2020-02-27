<?php

namespace UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class UserBundle extends Bundle
{
    //Hériter FOSUserBundle depuis notre UserBundle
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
