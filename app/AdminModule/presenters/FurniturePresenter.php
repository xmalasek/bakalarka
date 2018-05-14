<?php

namespace AdminModule;

use Nette;


class FurniturePresenter extends BasePresenter
{
    private $database;

    public function __construct(Nette\Database\Context $database)
    {
        parent::__construct();
        $this->database = $database;


    }

    public function renderDefault()
    {
        $this->template->furniture = $this->database->table('furniture');
    }

    public function renderShow()
    {
        $this->template->furniture = $this->database->table('furniture');

    }

    public function renderAdd()
    {


    }

    public function renderInfo($id){

        $device = $this->database->table('furniture')->where('id_furniture', $id);

        if (!$device) {
            $this->error('Příspěvek nebyl nalezen');
            $this->redirect('Eletric:default');
        }else{
            $this->template->furniture = $device;
        }
    }


    public function renderFault()
    {


    }


    public function actionFault($id){

        $this['insertFaultForm']->setDefaults([
            'id_device' => $id
        ]);

    }

    //Vytvoreni formulare InsertFurnitureForm
    protected function createComponentInsertFurnitureForm(){

        $form = (new InsertFurnitureFormFactory()) -> create();
        $form->onSuccess[] = [$this, 'insertDeviceSucceeded'];
        $form['lat']->setValue($_GET["lat"]);  //predani lat
        $form['lng']->setValue($_GET["lng"]);  //predani lng
        return $form;

    }

    //vlozeni do databaze furniture
    public function insertDeviceSucceeded($form, $values){
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
        $this->redirect('Furniture:');
    }



    //Vytvoreni formulare InsertFaultForm - formular pro pridavani zavad
    protected function createComponentInsertFaultForm(){

        $form = (new InsertFaultFormFactory()) -> create();
        $form->onSuccess[] = [$this, 'insertFaultSucceeded'];
        return $form;

    }

    //vlozeni error + pridani error do furniture
    public function insertFaultSucceeded($form, $values){

        $data=
            ['description' => $values->description ,
                'datum' => $values->datum];

        $error_id = $this->database->table('error')->insert($data)->id_error;

        $this->database->table('furniture')
            ->where('furniture', $values->id_device)
            ->update([
                'error_id' => $error_id
            ]);

        $this->redirect('Furniutre:default');

    }

    //vytvoreni formulare EdirFurnitureForm - editace mobiliare
    protected function createComponentEditFurnitureForm(){

        $form = (new EditFurnitureFormFactory()) -> create();
        $form->onSuccess[] = [$this, 'updateDeviceSucceeded'];

        return $form;
    }

    //update furniture device
    public function updateDeviceSucceeded($form, $values){

        $this->database->table('furniture')
            ->where('id_furniture', $this->getParameter('id'))
            ->update([

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

        $this->flashMessage('Položka byla úspěšně editována.');

    }

    //metoda actionEdit - vepsani hodnot z databaze do formulare
    public function actionEdit($id){

        $values = $this->database->table('furniture')->get($id);
        if (!$values) {
            $this->error('Příspěvek nebyl nalezen');
        }

        $this['editEletricForm']->setDefaults([

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


    }

    public function handleDelete($deviceId){

        $this->database->table('furniture')->where('id_furniture', $deviceId)->delete();
        $this->flashMessage('Zařízení bylo úspěšně odstraněno.', 'success');

    }




}