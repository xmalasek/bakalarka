<?php

namespace AdminModule;

use Nette;


class FurniturePresenter extends BasePresenter
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     *
     */
    public function renderDefault()
    {

    }



    public function handleInsertUser()
    {

        $this->foo = 'pokus';

        if ($this->isAjax()){

            $this->invalidateControl('pokus');


        }

    }


}