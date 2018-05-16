<?php

namespace AdminModule;

use Nette;
use Nette\Application\Responses\JsonResponse;
use Nette\Utils\Json;
use Tracy\Debugger;

class AddPresenter extends BasePresenter
{
    private $database;

    public function __construct(Nette\Database\Context $database)
    {
        parent::__construct();
        $this->database = $database;

    }

    public function renderDefault()
    {

    }

    protected function createComponentInsertEletricForm()
    {

        $form = (new EditEletricFormFactory())->create();
        $form->onSuccess[] = [$this, 'insertEletricDeviceSucceeded'];

        return $form;
    }

    public function insertEletricDeviceSucceeded($form, $values){



        $this->database->table('eletric')->insert([
            'nazev' => $values->nazev ,
            'ulice' => $values->ulice,
            'typ' => $values->typ,
            'svitidlo' => $values->svitidlo,
            'oznaceni' => $values->oznaceni,
            'pocet' => $values->pocet,
            'stav' => $values->stav,
            'stozar' => $values->stozar,
            'popis' => $values->popis,
            'lat' => $values->lat,
            'lng' => $values->lng,

        ]);



        $this->redirect('Add:');


    }

    protected function createComponentInsertFurnitureForm()
    {

        $form = (new EditFurnitureFormFactory())->create();
        $form->onSuccess[] = [$this, 'insertFurnitureDeviceSucceeded'];

        return $form;
    }

    public function insertFurnitureDeviceSucceeded($form, $values){
        $this->database->table('furniture')->insert([
            'nazev' => $values->nazev ,
            'ulice' => $values->ulice,
            'typ' => $values->typ,
            'oznaceni' => $values->oznaceni,
            'pocet' => $values->pocet,
            'material' => $values->material,
            'stav' => $values->stav,
            'popis' => $values->popis,
            'lat' => $values->lat,
            'lng' => $values->lng,

        ]);
        $this->redirect('Add:');
    }

    protected function createComponentInsertInterestForm()
    {

        $form = (new EditInterestFormFactory())->create();
        $form->onSuccess[] = [$this, 'insertInterestDeviceSucceeded'];

        return $form;
    }

    public function insertInterestDeviceSucceeded($form, $values){
        $this->database->table('interest')->insert([
            'nazev' => $values->nazev ,
            'ulice' => $values->ulice,
            'cp' => $values->cp,
            'typ' => $values->typ,
            'popis' => $values->popis,
            'telefon' => $values->telefon,
            'web' => $values->web,
            'lat' => $values->lat,
            'lng' => $values->lng,

        ]);
        $this->redirect('Add:');
    }

    protected function createComponentWasteEletricForm()
    {

        $form = (new EditWasteFormFactory())->create();
        $form->onSuccess[] = [$this, 'insertWasteDeviceSucceeded'];

        return $form;
    }

    public function insertWasteDeviceSucceeded($form, $values){



        $this->database->table('waste')->insert([
            'nazev' => $values->nazev ,
            'ulice' => $values->ulice,
            'typ' => $values->typ,
            'oznaceni' => $values->oznaceni,
            'pocet' => $values->pocet,
            'stav' => $values->stav,
            'objem' => $values->objem,
            'popis' => $values->popis,
            'lat' => $values->lat,
            'lng' => $values->lng,

        ]);



        $this->redirect('Waste:');


    }

}