<?php

namespace app\controllers;

/**
 * ResultsController implements the CRUD actions for Results model.
 */
class ResultsController extends AdminController
{
    public $modelClass = 'app\models\Results';
    public $searchModelClass = 'app\models\ResultsSearch';
}