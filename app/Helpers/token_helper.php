<?php

function generateToken($user_id) {
    $token = bin2hex(random_bytes(32)); //Crée un token sécurisé
    $apiTokenModel = model('ApiTokenModel');
    $apiTokenModel->insert([
        'user_id' => $user_id,
        'token' => $token,
        'created_at' => date('Y-m-d H:i:s')
    ]);
    return $token;
}

function validateToken($token) {
    $apiTokenModel = model('ApiTokenModel');
    $tokenData = $apiTokenModel->where('token', $token)->first();
    if($tokenData) {
        return true;
    }
    return false;
}