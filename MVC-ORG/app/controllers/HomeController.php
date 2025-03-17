<?php
require_once BASE_PATH . '/app/models/User.php';

class HomeController {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new User();
    }
    
    public function index() {
        // Get data from model
        $users = $this->userModel->getAll();
        
        // Include view
        include BASE_PATH . '/app/views/home/index.php';
    }
    
    public function show() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        
        if ($id) {
            $user = $this->userModel->getById($id);
            include BASE_PATH . '/app/views/home/show.php';
        } else {
            header("Location: /");
        }
    }
}
