<?php

namespace MairieVoreppe\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MairieVoreppeUserBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'SonataUserBundle';
    }
}
