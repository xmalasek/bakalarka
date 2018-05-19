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

        $form->addPassword('passwordVerifyOld', 'Staré heslo');

        $form->addPassword('password', 'Nové heslo');

        $form->addPassword('passwordVerify', 'Nové heslo pro ověření')
            ->setRequired('Kontrolní heslo musí být vyplněno!')
            ->addRule(Form::EQUAL, 'Hesla se neshodují', $form['password']);

        $form->addEmail('email', 'Email')
            ->setRequired('E-mail nesmí být prázdný!');

        $form->addSubmit('submit', 'Potvrdit');
        return $form;
    }
}