<?php

namespace FrontModule;

use Nette;


class FurniturePresenter extends Nette\Application\UI\Presenter
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