<?php

namespace AdminModule;

use Nette\Application\UI\Form;

class InsertEletricFormFactory
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
        ])
            ->setPrompt('Zvolte ulici')
            ->setRequired('Ulice musi byt vyplnena!');

        $form->addSelect('typ', 'Typ', [
            'Světlo' => 'Světlo',
            'Rozhlas' => 'Rozhlas',
        ])
            ->setPrompt('Zvolte typ')
            ->setRequired('Typ musi byt vyplnen!');

        $form->addSelect('svitidlo', 'Svítidlo:', [
            'Led' => 'Led',
            'Žárovka' => 'Žárovka',
    ])
        ->setPrompt('Zvolte svítidlo')
        ->setRequired(false); // nepovinná

        $form->addText('oznaceni', 'Označení eletrického zařízení')
            ->setRequired('Označení musí být vyplněno');

        $form->addText('pocet', 'Počet eletrických zařízení')
            ->setRequired('Počet musí být vyplněn!');

        $form->addSelect('stav', 'Stav', [
            'Nové' => 'Nové',
            'Opotřebované' => 'Opotřebované',
            'Staré' => 'Staré',
        ])
            ->setPrompt('Zvolte stav')
            ->setRequired('Stav musí být vyplněn!');;

        $form->addSelect('stozar', 'Stožár:', [
            'Betonový' => 'Betonový',
            'Dřevěný' => 'Dřevěný',
            'Železný' => 'Železný',
        ])
            ->setPrompt('Zvolte stožár')
            ->setRequired('Stažár musí být vyplněn!');

        $form->addText('popis', 'Popis elektrického zařízení');

        $form->addText('lat', 'Latitude')
            ->setRequired('Povinné!');


        $form->addText('lng', 'Longitude')
            ->setRequired('Povinné!');



        $form->addSubmit('submit', 'Potvrdit');
        return $form;
    }
}