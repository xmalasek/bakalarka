<?php

namespace AdminModule;

use Nette\Application\UI\Form;

class FiltrEletricFormFactory
{
    /**
     * @return Form
     */

    public function create()
    {
        $form = new Form;

         $form->addSelect('ulice', 'Ulice', [
            'V dědině' => 'V Dědině',
            'Hlavní' => 'Hlavní',
        ])
            ->setPrompt('Všechny ulice');

        $form->addSubmit('submit', 'Zobrazit');
        return $form;
    }
}