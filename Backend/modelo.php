<?php
class tokenDao{



function createToken($username) {
    $token = base64_encode(json_encode(['username' => $username, 'exp' => time() +
    10]));
    $signature = hash_hmac('sha256', $token, $secretKey);
    return $token . '.' . $signature; // Formato: token.signature
    }


}

function verifyToken($token) {
    list($encodedPayload, $signature) = explode('.', $token);
    // Verificar la firma
    if (hash_hmac('sha256', $encodedPayload, $secretKey) !== $signature) {
    return null; // Token inválido
    }
    $payload = json_decode(base64_decode($encodedPayload), true);
// Verificar si el token ha expirado
if ($payload['exp'] < time()) {
    return null; // Token expirado
    }
    return $payload; // Token válido
    }
    // Verificar el token
    $decoded = verifyToken(str_replace('Bearer ', '', $token));
    if ($decoded) {
    echo json_encode(['message' => 'Acceso permitido', 'username' =>
    $decoded['username']]);
    } else {
    http_response_code(401);
    echo json_encode(['error' => 'Token inválido']);
    }
    } else {
    http_response_code(404);
    echo json_encode(['error' => 'Ruta no encontrada']);
    }