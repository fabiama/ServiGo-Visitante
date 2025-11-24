<?php

    require __DIR__ . '/../../../config.php';
    require __DIR__ . '/../../../db.php';   
 
    header('Content-Type: application/json');


// Solo si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['pass'] ?? '');
    $tipo   = trim($_POST['tipo']    ?? '');

    $idRol    = filter_input(INPUT_POST, 'tipo', FILTER_VALIDATE_INT);


    $regexNombre = '/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]{4,40}$/';
    $regexPass   = '/^(?=.*[°|!"#$%&\/()=?\''.'¡¿´¨+{}\[\]_\-:.,;><]).{6,}$/';


    if ($nombre === '' || !preg_match($regexNombre, $nombre)) {
        echo json_encode(["status" => "error", "message" => "Nombre Requerido."]);
        exit();
    }
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["status" => "error", "message" => "Email Requerido."]);
        exit();
    }
   if ($password === '') {
         echo json_encode(["status" => "error", "message" => "Contraseña: mínimo 6 caracteres y un símbolo."]);
        exit();
      
    }
    if ($tipo === '') {
    echo json_encode(["status" => "error", "message" => "Tipo de usuario no válido."]);
    exit;
    }


    if (!$idRol) {
        echo json_encode(['status' => 'error', 'message' => 'Rol inválido.']);
        exit;   
    }

    $sqlRol = "SELECT id FROM roles WHERE id = :id";
    $stmtRol = $pdo->prepare($sqlRol);
    $stmtRol->execute(['id' => $idRol]);
    if (!$stmtRol->fetch()) {
        echo json_encode(['status' => 'error', 'message' => 'Rol no encontrado.']);
        exit;
    }

    $sqlDup = "SELECT id FROM usuarios WHERE email = :email";
    $stmtDup = $pdo->prepare($sqlDup);
    $stmtDup->execute(['email' => $email]);
    if ($stmtDup->fetch()) {
        http_response_code(409);
        echo json_encode(['status' => 'error', 'message' => 'El email ya está registrado.']);
        exit;
    }

    $hash = password_hash($password, PASSWORD_BCRYPT);
    $sqlIns = "INSERT INTO usuarios (nombre, email, password_hash, rol_id, activo)
            VALUES (:nombre, :email, :password_hash, :rol_id, 1)";
    $stmtIns = $pdo->prepare($sqlIns);
    $stmtIns->execute([
        ':nombre'        => $nombre,
        ':email'         => $email,
        ':password_hash' => $hash,
        ':rol_id'        => $idRol
    ]);

    echo json_encode(['status' => 'success', 'message' => 'Usuario registrado.']);
}
?>