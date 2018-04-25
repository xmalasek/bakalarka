<?php

namespace AdminModule;

use Nette;

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     *
     */
    public function beforeRender()
    {
        parent::beforeRender();
    }

    /**
     *
     */
    public function actionDefault()
    {

    }
}