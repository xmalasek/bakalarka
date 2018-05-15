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
        $router[] = new Route('panel/eletric/add', [
            'presenter' => 'Eletric',
            'action' => 'add',
            'id' => null,
            'module' => 'Admin'
        ]);
        $router[] = new Route('panel/furniture/add', [
            'presenter' => 'Furniture',
            'action' => 'add',
            'id' => null,
            'module' => 'Admin'
        ]);
        $router[] = new Route('panel/interest/add', [
            'presenter' => 'Interest',
            'action' => 'add',
            'id' => null,
            'module' => 'Admin'
        ]);
        $router[] = new Route('panel/waste/add', [
            'presenter' => 'Waste',
            'action' => 'add',
            'id' => null,
            'module' => 'Admin'
        ]);
//        TODO add metody pro vsechno
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
        $router[] = new Route('panel/elektricke-zarizeni/<action>/[<id>/]', [
            'presenter' => 'Eletric',
            'action' => array(
                Route::VALUE => 'default',
                Route::FILTER_TABLE => array(
                    'editace' => 'edit',
                    'nahlasit-zavadu' => 'fault',
                    'informace' => 'info',
                    'seznam' => 'show',
                )
            ),
            'id' => null,
            'module' => 'Admin'
        ]);
        $router[] = new Route('panel/zavady/<action>/[<id>/]', [
            'presenter' => 'Fault',
            'action' => array(
                Route::VALUE => 'default',
                Route::FILTER_TABLE => array(
                    'informace' => 'info',
                    'seznam' => 'show',
                ),
                Route::FILTER_STRICT => true
            ),
            'id' => null,
            'module' => 'Admin'
        ]);
        $router[] = new Route('panel/mestsky-mobiliar/<action>/[<id>/]', [
            'presenter' => 'Furniture',
            'action' => array(
                Route::VALUE => 'default',
                Route::FILTER_TABLE => array(
                    'editace' => 'edit',
                    'nahlasit-zavadu' => 'fault',
                    'informace' => 'info',
                    'seznam' => 'show',
                )
            ),
            'id' => null,
            'module' => 'Admin'
        ]);
        $router[] = new Route('panel/mista-zajmu/<action>/[<id>/]', [
            'presenter' => 'Interest',
            'action' => array(
                Route::VALUE => 'default',
                Route::FILTER_TABLE => array(
                    'editace' => 'edit',
                    'nahlasit-zavadu' => 'fault',
                    'informace' => 'info',
                    'seznam' => 'show',
                )
            ),
            'id' => null,
            'module' => 'Admin'
        ]);
        $router[] = new Route('panel/odpadove-hospodarstvi/<action>/[<id>/]', [
            'presenter' => 'Waste',
            'action' => array(
                Route::VALUE => 'default',
                Route::FILTER_TABLE => array(
                    'editace' => 'edit',
                    'nahlasit-zavadu' => 'fault',
                    'informace' => 'info',
                    'seznam' => 'show',
                )
            ),
            'id' => null,
            'module' => 'Admin'
        ]);
// todo pridat dalsi tranky
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
