<?php

namespace MairieVoreppe\UsefulBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MairieVoreppeUsefulBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
       public function getParent()
       {
            return 'ShtumiUsefulBundle';
       }
}
