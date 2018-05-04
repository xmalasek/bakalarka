<?php

namespace AdminModule;

use Nette;
use Nette\Application\UI;

class SignPresenter extends BasePresenter
{
    /**
     * @var Nette\Database\Context
     */
    private $database;

    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }

    protected function createComponentSignInForm()
    {
        $form = new UI\Form;
        $form->addText('username', 'Uživatelské jméno:')
            ->setRequired('Prosím vyplňte své uživatelské jméno.');

        $form->addPassword('password', 'Heslo:')
            ->setRequired('Prosím vyplňte své heslo.');

        $form->addSubmit('submit', 'Přihlásit');

        $form->onSuccess[] = [$this, 'signInFormSubmitted'];
        return $form;
    }

    public function signInFormSubmitted($form, $values)
    {
        try {
            $user = $this->getUser();
            $user->login($values->username, $values->password);

//            TODO remember me vlasnost
            $user->setExpiration('12 hours', TRUE);

            //FIXME redirect na stranku, kde jsem byl
            $this->redirect('Homepage:');
        } catch (Nette\Security\AuthenticationException $e) {
            $form->addError('Nesprávné přihlašovací jméno nebo heslo.');
        }
    }

    public function renderOut() {
        $user = $this->getUser();
        $user->logout();
        $this->redirect('Sign:in');
    }
}