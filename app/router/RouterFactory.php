<?php

namespace App;

use Nette;
use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;


class RouterFactory
{
    use Nette\StaticClass;

    /**
     * @return Nette\Application\IRouter
     */
    public static function createRouter()
    {
        $router = new RouteList;

        /* Admin module */
        $router[] = new Route('panel/odhlaseni/', [
            'presenter' => 'Sign',
            'action' => 'out',
            'id' => null,
            'module' => 'Admin'
        ]);
        $router[] = new Route('panel/prihlaseni/', [
            'presenter' => 'Sign',
            'action' => 'in',
            'id' => null,
            'module' => 'Admin'
        ]);

        $router[] = new Route('panel/<presenter>/<action>/[<id>/]', [
            'presenter' => 'Homepage',
            'action' => 'default',
            'id' => null,
            'module' => 'Admin'
        ]);

        /* Front module */
        $router[] = new Route('<presenter>/<action>/[<id>/]', [
            'presenter' => 'Homepage',
            'action' => 'default',
            'id' => null,
            'module' => 'Front'
        ]);

        return $router;
    }
}
