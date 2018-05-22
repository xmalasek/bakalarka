<?php

namespace AdminModule;

use Nette\Application\UI\Form;

class EditUserFormFactory
{
    /**
     * @return Form
     */
    public function create()
    {
        $form = new Form;

        $form->addText('degree', 'Akadamický titul');

        $form->addText('name', 'Jméno')
            ->setRequired('Jméno nesmí být prázdné!');

        $form->addText('surname', 'Příjmení')
            ->setRequired('Příjmení nesmí být prázdné!');

        $form->addSelect('role', 'Role');

        $form->addPassword('password', 'Nové heslo');

        $form->addPassword('passwordVerifyOld', 'Současné heslo');

        $form->addEmail('email', 'Email')
            ->setRequired('E-mail nesmí být prázdný!');

        $form->addSubmit('submit', 'Potvrdit');
        return $form;
    }
}