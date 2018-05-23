<?php

namespace AdminModule;

use Nette\Application\UI\Form;

class FiltrFurnitureFormFactory
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
             'Horka' => 'Horka',
             'Nová' => 'Nová',
             'Dálka' => 'Dálka',
             'Kukýrna' => 'Kukýrna',
             'Drásovská' => 'Drásovská',
             'U nádraží' => 'U nádraží',
        ])
            ->setPrompt('Všechny ulice');

        $form->addSubmit('submit', 'Zobrazit');
        return $form;
    }
}