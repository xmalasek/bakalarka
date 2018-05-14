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
            $this->template->logged_user = array(
                'id' => $user->getIdentity()->getId(),
                'email' => $user->getIdentity()->email,
                'name' => $user->getIdentity()->name,
                'surname' => $user->getIdentity()->surname,
            );
            $this->template->user_editor = $this->JeEditor();
            $this->template->user_admin = $this->JeAdministrator();
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

    protected function JeEditor()
    {
        $user = $this->getUser();
        if ($user->isLoggedIn()) {
            if ($user->getIdentity()->role == 2) {
                return true;
            }
        }
        return false;
    }

    protected function JeAdministrator()
    {
        $user = $this->getUser();
        if ($user->isLoggedIn()) {
            if ($user->getIdentity()->role == 1) {
                return true;
            }
        }
        return false;
    }
}