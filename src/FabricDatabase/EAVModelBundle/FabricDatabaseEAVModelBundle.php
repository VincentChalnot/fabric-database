<?php

namespace FabricDatabase\EAVModelBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class FabricDatabaseEAVModelBundle extends Bundle
{
    /**
     * @return string
     */
    public function getParent()
    {
        return 'CleverAgeEAVManagerEAVModelBundle';
    }
}
