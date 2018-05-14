<?php

namespace AdminModule;

use Nette;


class InterestPresenter extends BasePresenter
{
    private $database;

    public function __construct(Nette\Database\Context $database)
    {
        parent::__construct();
        $this->database = $database;


    }

    public function renderDefault()
    {
        $this->template->interest = $this->database->table('interest');
    }

    public function renderShow()
    {
        $this->template->interest = $this->database->table('interest');

    }

    public function renderAdd()
    {


    }

    public function renderInfo($id){

        $device = $this->database->table('interest')->where('id_interest', $id);

        if (!$device) {
            $this->error('Příspěvek nebyl nalezen');
            $this->redirect('Eletric:default');
        }else{
            $this->template->interest = $device;
        }
    }


    public function renderFault()
    {


    }


    public function actionFault($id){

        $this['insertInterestForm']->setDefaults([
            'id_device' => $id
        ]);

    }

    //Vytvoreni formulare InsertFurnitureForm
    protected function createComponentInsertInterestForm(){

        $form = (new InsertInterestFormFactory()) -> create();
        $form['lat']->setValue($_POST["lat"]);  //predani lat
        $form['lng']->setValue($_POST["lng"]);  //predani lng
        $form->onSuccess[] = [$this, 'insertDeviceSucceeded'];

        return $form;

    }

    //vlozeni do databaze furniture
    public function insertDeviceSucceeded($form, $values){
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
        $this->redirect('Interest:');
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

        $this->database->table('interest')
            ->where('interest', $values->id_device)
            ->update([
                'error_id' => $error_id
            ]);

        $this->redirect('Interest:default');

    }

    //vytvoreni formulare EdirFurnitureForm - editace mobiliare
    protected function createComponentEditInterestForm(){

        $form = (new EditFurnitureFormFactory()) -> create();
        $form->onSuccess[] = [$this, 'updateDeviceSucceeded'];

        return $form;
    }

    //update furniture device
    public function updateDeviceSucceeded($form, $values){

        $this->database->table('interest')
            ->where('id_interest', $this->getParameter('id'))
            ->update([

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

        $this->flashMessage('Položka byla úspěšně editována.');

    }

    //metoda actionEdit - vepsani hodnot z databaze do formulare
    public function actionEdit($id){

        $values = $this->database->table('interest')->get($id);
        if (!$values) {
            $this->error('Příspěvek nebyl nalezen');
        }

        $this['editInterestForm']->setDefaults([

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


    }

    public function handleDelete($deviceId){

        $this->database->table('interest')->where('id_interest', $deviceId)->delete();
        $this->flashMessage('Zařízení bylo úspěšně odstraněno.', 'success');

    }
}