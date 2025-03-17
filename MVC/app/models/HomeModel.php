<?php
namespace App\Models;

use Core\Model;

class HomeModel extends Model {
    public function getData() {
        return ['message' => 'Welcome to PHP MVC RESTful API'];
    }
}
