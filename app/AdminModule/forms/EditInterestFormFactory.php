<?php

namespace AdminModule;

use Nette\Application\UI\Form;

class EditInterestFormFactory
{
    /**
     * @return Form
     */

    public function create()
    {
        $form = new Form;

        $form->addText('nazev', 'Název místa')
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

        $form->addText('cp', 'Číslo popisné')
            ->setRequired('Číslo musí být vyplněno!');

        $form->addSelect('typ', 'Typ', [
            'Obchod' => 'Obchod',
            'Vinárna' => 'Vinárna',
            'Restaurace' => 'Restaurace',
            'Pošta' => 'Pošta',
            'Cukrárna' => 'Cukrárna',
            'Knihovna' => 'Knihovna',
            'Škola' => 'Škola',
            'Obecní úřad' => 'Obecní úřad',
            'Sběrný dvůr' => 'Sběrný dvůr',
        ])
            ->setPrompt('Zvolte typ')
            ->setRequired('Typ musí být vyplněn!');



        $form->addText('popis', 'Popis elektrického zařízení')
            ->setRequired(false);

        $form->addText('telefon', 'Telefon')
            ->setRequired('Telefon musí být vyplněn!');

        $form->addText('web', 'Webová stránka')
            ->setRequired('Webová stránka musí být vyplněna!');

        $form->addText('lat', 'Latitude')
            ->setRequired('Povinné!');


        $form->addText('lng', 'Longitude')
            ->setRequired('Povinné!');

        $form->addUpload('avatar')
            ->setRequired(FALSE)
            ->addRule(Form::IMAGE, 'Soubor musí být JPEG, PNG nebo GIF.')
            ->addRule(Form::MAX_FILE_SIZE, 'Maximální velikost souboru je 10MB.', 10000 * 1024 /* v bytech */);



        $form->addSubmit('submit', 'Potvrdit');
        return $form;
    }
}