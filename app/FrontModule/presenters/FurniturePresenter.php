<?php

namespace FrontModule;

use Nette;


class FurniturePresenter extends Nette\Application\UI\Presenter
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

    public function renderFault()
    {


    }


    public function actionFault($id){

        $this['insertFaultForm']->setDefaults([
            'id_device' => $id
        ]);

    }

    public function renderInfo($id){
        $this->template->furniture = $this->database->table('furniture')->where('id_furniture', $id);
    }


    protected function createComponentInsertFaultForm(){

        $form = (new InsertFaultFormFactory()) -> create();
        $form->onSuccess[] = [$this, 'insertFurnitureFaultSucceeded'];
        return $form;

    }

    public function insertFurnitureFaultSucceeded($form, $values){

        $data=
            ['description' => $values->description ,
                'datum' => $values->datum,
                'email' => $values->email
                ];

        $error_id = $this->database->table('error')->insert($data)->id_error;

        $this->database->table('furniture')
            ->where('id_furniture', $values->id_device)
            ->update([
                'error_id' => $error_id
            ]);

        $this->redirect('Furniture:default');

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