<?php

namespace AdminModule;

use Nette\Application\UI\Form;

class InsertWasteFormFactory
{
    /**
     * @return Form
     */

    public function create()
    {
        $form = new Form;

        $form->addText('nazev', 'Název eletrického zařízení')
            ->setRequired('Název musí být vyplněn');


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
            ->setPrompt('Zvolte ulici')
            ->setRequired('Ulice musi byt vyplnena!');

        $form->addSelect('typ', 'Typ', [
            'Odpadkový koš' => 'Odpadkový koš',
            'Psí koš' => 'Psí koš',
            'Kontejner na plast' => 'Kontejner na plast',
            'Kontejner na sklo' => 'Kontejner na sklo',
            'Kontejner na papír' => 'Kontejner na papír',
            'Kontejner na domovní odpad' => 'Kontejner na domovní odpad',
            'Kontejner na olej' => 'Kontejner na olej',

        ])
            ->setPrompt('Zvolte typ')
            ->setRequired('Typ musi byt vyplnen!');


        $form->addText('oznaceni', 'Označení odpadového zařízení')
            ->setRequired('Označení musí být vyplněno');

        $form->addText('pocet', 'Počet zařízení')
            ->setRequired('Počet musí být vyplněn!');

        $form->addSelect('stav', 'Stav', [
            'Nové' => 'Nové',
            'Opotřebované' => 'Opotřebované',
            'Staré' => 'Staré',
        ])
            ->setPrompt('Zvolte stav')
            ->setRequired('Stav musí být vyplněn!');;

        $form->addText('objem', 'Objem zařízení v litrech')
            ->setRequired('Objem musí být vyplněn!');

        $form->addText('popis', 'Popis odpadového zařízení');

        $form->addText('lat', 'Latitude')
            ->setRequired('Povinné!');


        $form->addText('lng', 'Longitude')
            ->setRequired('Povinné!');



        $form->addSubmit('submit', 'Potvrdit');
        return $form;
    }
}