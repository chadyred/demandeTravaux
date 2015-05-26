<?php

namespace MairieVoreppe\AdminBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MairieVoreppeAdminBundle extends Bundle
{
     public function getParent()
    {
        return 'SonataAdminBundle';
    }
}
