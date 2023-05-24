<?php

namespace App;

use App\Trait\TimeZone;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    use TimeZone;

    public function __construct($env, $debug)
    {
        $this->changeTimeZone("Europe/Paris");
        
        parent::__construct($env, $debug);
    }

}
