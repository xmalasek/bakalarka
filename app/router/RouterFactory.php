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
        $router[] = new Route('admin/<presenter>/<action>/[<id>/]', [
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
