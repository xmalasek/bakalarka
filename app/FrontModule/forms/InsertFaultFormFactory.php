<?php

namespace FrontModule;

use Nette\Application\UI\Form;

class InsertFaultFormFactory
{
    /**
     * @return Form
     */

    public function create()
    {
        $form = new Form;

        $form->addText('description', 'Popis závady')
            ->setRequired('Popis musí být vyplněn');


        $form->addText('datum', 'Datum zjištění závady.')
            ->setRequired('Datum musí být vyplněno!');

        $form->addHidden('id_device', 'null');

        $form->addSubmit('submit', 'Potvrdit');


        return $form;
    }
}