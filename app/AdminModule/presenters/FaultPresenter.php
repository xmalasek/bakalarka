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

        $this->template->eletric = $this->database->table('eletric')->where('id_error NOT',null);
        $this->template->furniture = $this->database->table('furniture')->where('id_error NOT',null);
        $this->template->interest = $this->database->table('interest')->where('id_error NOT',null);
        $this->template->waste = $this->database->table('waste')->where('id_error NOT',null);

       $this->template->eletric=$this->database->table('eletric')
           ->select('error.*')
           ->select('eletric.*')
           ->where('error.id_error = eletric.error_id');
    }

    public function renderInfo($errorId){


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



    public function handleDelete($eletricId){

        $this->database->table('eletric')
            ->where('id_eletric', $eletricId) // must be called before update()
            ->update([
                'error_id' => NULL
            ]);

        //$this->database->table('error')->where('id_error', $errorId)->delete();
        $this->flashMessage('Zařízení bylo úspěšně odstraněno.', 'success');


    }

}