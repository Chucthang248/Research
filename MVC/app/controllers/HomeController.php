<?php
namespace App\Controllers;

use Core\Controller;
use Core\Request;

class HomeController extends Controller {
    public function index(Request $request) {
        $model = $this->model('HomeModel');
        $data = $model->getData();
        $this->view('home', $data);
    }
}
