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
        $user = $this->getUser();
        if ($user->isLoggedIn()) {
            $this->template->user = array(
                'id' => $user->getIdentity()->getId(),
                'email' => $user->getIdentity()->email,
                'name' => $user->getIdentity()->name,
                'surname' => $user->getIdentity()->surname,
            );
        }
        parent::beforeRender();
    }

    /**
     *
     */
    public function actionDefault()
    {
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:in');
        }
    }
}