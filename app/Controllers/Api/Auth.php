<?php

namespace App\Controllers\Api;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Auth extends ResourceController
{
    public function login() {
        try {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            // Validation basique
            if (empty($email) || empty($password)) {
                return $this->respond(['message' => 'Email et mot de passe requis'], 400);
            }
            // Rechercher l'utilisateur
            $userModel = model('UserModel');
            $user = $userModel->findByEmail($email);

            if (!$user || !$user->verifyPassword($password)) {
                return $this->respond(['message' => 'Identifiants incorrects'], 401);
            }

            if (!$user->isActive()) {
                return $this->respond(['message' => 'Compte désactivé'], 401);
            }

            helper('token');
            return $this->respond([
                'token'   => generateToken($user->id),
                'id_user' => $user->id
            ]);

        } catch (\Exception $e) {
            return $this->respond(['message' => $e->getMessage()], 500);
        }
    }
}
