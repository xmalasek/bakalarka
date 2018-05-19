<?php

namespace AdminModule;

use Nette;


class FaultPresenter extends BasePresenter
{
    private $database;
    public function __construct(Nette\Database\Context $database)
    {
        parent::__construct();
        $this->database = $database;
    }

    public function renderDefault()
    {
        $this->template->eletric = $this->database->table('eletric')->where('error_id_error NOT',null);
        $this->template->furniture = $this->database->table('furniture')->where('error_id_error NOT',null);
        $this->template->interest = $this->database->table('interest')->where('error_id_error NOT',null);
        $this->template->waste = $this->database->table('waste')->where('error_id_error NOT',null);
    }

    public function renderShow()
    {

        $this->template->eletric = $this->database->table('eletric')->where('error_id NOT',null);
        $this->template->furniture = $this->database->table('furniture')->where('error_id NOT',null);
        $this->template->waste = $this->database->table('waste')->where('error_id NOT',null);

       $this->template->eletric=$this->database->table('eletric')
           ->select('error.*')
           ->select('eletric.*')
           ->where('error.id_error = eletric.error_id');

        $this->template->furniture=$this->database->table('furniture')
            ->select('error.*')
            ->select('furniture.*')
            ->where('error.id_error = furniture.error_id');

        $this->template->waste=$this->database->table('waste')
            ->select('error.*')
            ->select('waste.*')
            ->where('error.id_error = waste.error_id');
    }

    public function renderInfoEle($errorId){
        $error = $this->template->eletric=$this->database->table('eletric')
            ->select('error.*')
            ->select('eletric.*')
            ->where('error.id_error', $errorId);
        if (!$error) {
            $this->error('Příspěvek nebyl nalezen');
        }else{
            $this->template->eletric = $error;
        }
    }

    public function renderInfoFur($errorId){
        $error = $this->template->furniture=$this->database->table('furniture')
            ->select('error.*')
            ->select('furniture.*')
            ->where('error.id_error', $errorId);
        if (!$error) {
            $this->error('Příspěvek nebyl nalezen');
        }else{
            $this->template->furniture = $error;
        }
    }

    public function renderInfoWas($errorId){
        $error = $this->template->waste=$this->database->table('waste')
            ->select('error.*')
            ->select('waste.*')
            ->where('error.id_error', $errorId);
        if (!$error) {
            $this->error('Příspěvek nebyl nalezen');
        }else{
            $this->template->waste = $error;
        }
    }

    public function handleDeleteEletric($eletricId){

        $this->database->table('eletric')
            ->where('id_eletric', $eletricId) // must be called before update()
            ->update([
                'error_id' => NULL
            ]);
        $this->flashMessage('Zařízení bylo úspěšně odstraněno.', 'success');
    }

    public function handleDeleteFurniture($furnitureId){

        $this->database->table('furniture')
            ->where('id_furniture', $furnitureId) // must be called before update()
            ->update([
                'error_id' => NULL
            ]);
        $this->flashMessage('Zařízení bylo úspěšně odstraněno.', 'success');
    }

    public function handleDeleteWaste($wasteId){

        $this->database->table('waste')
            ->where('id_waste', $wasteId) // must be called before update()
            ->update([
                'error_id' => NULL
            ]);
        $this->flashMessage('Zařízení bylo úspěšně odstraněno.', 'success');
    }

}