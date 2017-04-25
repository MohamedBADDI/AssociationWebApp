<?php

namespace AclBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AclBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
