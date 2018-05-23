<?php

namespace AdminModule;

use Nette;
use Nette\Utils\FileSystem;


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
        $this->myRenderDefault(null);
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
            $this->redirect('interest:default');
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

    //Vytvoreni formulare InsertInterestForm
    protected function createComponentInsertInterestForm(){

        $form = (new InsertInterestFormFactory()) -> create();
        $form['lat']->setValue($_POST["lat"]);  //predani lat
        $form['lng']->setValue($_POST["lng"]);  //predani lng
        $form->onSuccess[] = [$this, 'insertDeviceSucceeded'];

        return $form;

    }

    //vlozeni do databaze interest
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



    protected function createComponentInsertFaultForm(){

        $form = (new InsertFaultFormFactory()) -> create();
        $form->onSuccess[] = [$this, 'insertFaultSucceeded'];
        return $form;

    }


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


    protected function createComponentEditInterestForm(){

        $form = (new EditInterestFormFactory()) -> create();
        $form->onSuccess[] = [$this, 'updateDeviceSucceeded'];

        return $form;
    }


    public function updateDeviceSucceeded($form, $values){

        $interest = $this->database->table('interest')->get($this->getParameter('id'));
        $avatar = $values->avatar;
        if($avatar->isImage() and $avatar->isOk()) {
            if (!is_null($interest->avatar)) {
                FileSystem::delete('admin/upload/interest/'.$interest->avatar);
            }

            $file_ext=strtolower(mb_substr($avatar->getSanitizedName(), strrpos($avatar->getSanitizedName(), ".")));
            $file_name = $interest->id_interest . $file_ext;
            $avatar->move('admin/upload/interest/'. $file_name);
            $values->avatar = $file_name;
        }
        else {
            $values->avatar = $interest->avatar;
        }

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
                'avatar' => $values->avatar

            ]);

        $this->flashMessage('Položka byla úspěšně editována.');

    }

    //metoda actionEdit - vepsani hodnot z databaze do formulare
    public function actionEdit($id){

        $values = $this->database->table('interest')->get($id);
        if (!$values) {
            $this->flashMessage('Položka nebyla nalezena.', 'fail');
            $this->redirect(':Admin:Interest:default');
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

        if(is_null($values->avatar)) {
            $this->template->avatar_path = '';
        }
        else {
            $this->template->avatar_path = '/admin/upload/interest/'.$values->avatar;
        }


    }

    public function handleDelete($deviceId){

        $interest = $this->database->table('interest')->get($deviceId);
        if(!is_null($interest->avatar))
        {
            FileSystem::delete('admin/upload/interest/'.$interest->avatar);
        }
        $this->database->table('interest')->where('id_interest', $deviceId)->delete();
        $this->flashMessage('Zařízení bylo úspěšně odstraněno.', 'info');
    }

    protected function createComponentFiltrInterestForm(){

        $form = (new FiltrInterestFormFactory()) -> create();
        $form->onSuccess[] = [$this, 'filtrDeviceSucceeded'];

        return $form;
    }

    private function myRenderDefault($value) {
        if(!isset($this->template->interest))
        {
            if(!$value)
            {
                $this->template->interest = $this->database->table('interest');
            }
            else {
                $this->template->interest = $this->database->table('interest')->where('ulice', $value);
            }
        }
    }

    public function filtrDeviceSucceeded($form, $values){
        $this->myRenderDefault($values->ulice);
    }
}