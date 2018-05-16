<?php

namespace AdminModule;

use Nette\Application\UI\Form;

class EditFurnitureFormFactory
{
    /**
     * @return Form
     */

    public function create()
    {
        $form = new Form;

        $form->addText('nazev', 'Název městského mobiliáře')
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
            'Lavička' => 'Lavička',
            'Zastávka BUS' => 'Zastávka BUS',
            'Stojan na kola' => 'Stojan na kolo',
            'Informační tabule' => 'Informační tabule',
        ])
            ->setPrompt('Zvolte typ')
            ->setRequired('Typ musi byt vyplnen!');


        $form->addText('oznaceni', 'Označení městeského mobiliáře')
            ->setRequired('Označení musí být vyplněno');

        $form->addText('pocet', 'Počet zařízení')
            ->setRequired('Počet musí být vyplněn!');

        $form->addSelect('material', 'Materiál městekého mobiliáře', [
            'Dřevo' => 'Dřevo',
            'Železo' => 'Železo',
            'Beton' => 'Beton',
            'Plast' => 'Plasts',
        ])
            ->setPrompt('Zvolte materiál mobiliáře')
            ->setRequired('Materiál musí být vyplněn!');

        $form->addSelect('stav', 'Stav', [
            'Nové' => 'Nové',
            'Opotřebované' => 'Opotřebované',
            'Staré' => 'Staré',
        ])
            ->setPrompt('Zvolte stav')
            ->setRequired('Stav musí být vyplněn!');


        $form->addText('popis', 'Popis městského mobiliáře')
        ->setRequired(false);

        $form->addText('lat', 'Latitude')
            ->setRequired('Povinné!');


        $form->addText('lng', 'Longitude')
            ->setRequired('Povinné!');


        $form->addSubmit('submit', 'Potvrdit');
        return $form;
    }
}