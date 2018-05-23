<?php

namespace AdminModule;

use Nette;
use Nette\Utils\FileSystem;


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
        $this->myRenderDefault(null);
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
        $form['lat']->setValue($_POST["lat"]);  //predani lat
        $form['lng']->setValue($_POST["lng"]);  //predani lng
        $form->onSuccess[] = [$this, 'insertDeviceSucceeded'];

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
                'datum' => $values->datum,
                'email' => $values->email,
            ];

        $error_id = $this->database->table('error')->insert($data)->id_error;

        $this->database->table('furniture')
            ->where('id_furniture', $values->id_device)
            ->update([
                'error_id' => $error_id
            ]);

        $this->redirect('Furniture:default');

    }

    //vytvoreni formulare EdirFurnitureForm - editace mobiliare
    protected function createComponentEditFurnitureForm(){

        $form = (new EditFurnitureFormFactory()) -> create();
        $form->onSuccess[] = [$this, 'updateDeviceSucceeded'];

        return $form;
    }

    //update furniture device
    public function updateDeviceSucceeded($form, $values){

        $furniture= $this->database->table('furniture')->get($this->getParameter('id'));
        $avatar = $values->avatar;
        if($avatar->isImage() and $avatar->isOk()) {
            if (!is_null($furniture->avatar)) {
                FileSystem::delete('admin/upload/furniture/'.$furniture->avatar);
            }

            $file_ext=strtolower(mb_substr($avatar->getSanitizedName(), strrpos($avatar->getSanitizedName(), ".")));
            $file_name = $furniture->id_furniture . $file_ext;
            $avatar->move('admin/upload/furniture/'. $file_name);
            $values->avatar = $file_name;
        }
        else {
            $values->avatar = $furniture->avatar;
        }

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
                'avatar' => $values->avatar


            ]);



        $this->flashMessage('Položka byla úspěšně editována.');

    }

    //metoda actionEdit - vepsani hodnot z databaze do formulare
    public function actionEdit($id){

        $values = $this->database->table('furniture')->get($id);
        if (!$values) {
            $this->flashMessage('Položka nebyla nalezena.', 'fail');
            $this->redirect(':Admin:Furniture:default');
        }

        $this['editFurnitureForm']->setDefaults([

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

        if(is_null($values->avatar)) {
            $this->template->avatar_path = '';
        }
        else {
            $this->template->avatar_path = '/admin/upload/furniture/'.$values->avatar;
        }


    }

    public function handleDelete($deviceId){

        $furniture = $this->database->table('furniture')->get($deviceId);
        if(!is_null($furniture->avatar))
        {
            FileSystem::delete('admin/upload/furniture/'.$furniture->avatar);
        }
        $this->database->table('furniture')->where('id_furniture', $deviceId)->delete();
        $this->flashMessage('Zařízení bylo úspěšně odstraněno.', 'info');

    }

    protected function createComponentFiltrFurnitureForm(){

        $form = (new FiltrFurnitureFormFactory()) -> create();
        $form->onSuccess[] = [$this, 'filtrDeviceSucceeded'];

        return $form;
    }

    private function myRenderDefault($value) {
        if(!isset($this->template->furniture))
        {
            if(!$value)
            {
                $this->template->furniture = $this->database->table('furniture');
            }
            else {
                $this->template->furniture = $this->database->table('furniture')->where('ulice', $value);
            }
        }
    }

    public function filtrDeviceSucceeded($form, $values){
        $this->myRenderDefault($values->ulice);
    }



}