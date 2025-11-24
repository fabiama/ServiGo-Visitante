<?php
    
    $config = include __DIR__ . '/../config.php';
    $BASE = $config['app']['base_url'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar Sesión - ServiGo</title>
  <link rel="stylesheet" href="<?= $BASE ?>/assets/css/login.css">
  <script defer src="<?= $BASE ?>/assets/js/visitante/login.js"></script>
</head>
<body>
<?php require __DIR__ . '/../includes/header.php'; ?>
<?php require __DIR__ . '/../includes/navbar.php'; ?>
  
    <section class="section-container container d-flex justify-content-center align-items-center mt-5">
            <div class="container section-container w-100 ">
                <div id="CardLogin" class="card">
                    <div class="card-body">
                        <div class="container"><h3>⚡ ServiGo</h3><div>
                        <h5 class="card-title text-center mb-4">Iniciar Sesión</h5>
                        <form action="log.php" method="POST" id="formulario">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    placeholder="Ingresa tu email"  minlength="5" maxlength="80" required>
                                <div id="DivEmail" class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" placeholder="Ingresa tu contraseña" name="password" minlength="6" maxlength="32" required>
                                <div id="Divpass" class="invalid-feedback"></div>
                            </div>
                            <div class="boton">
                                <input type="submit" value="Iniciar Sesión" class="btn iniciar-sesion" name="boton" id="boton">
                            </div>
                        </form>
                        <div class="text-center mt-3">
                            <a class="enlace" href="CambiarPass.php" >¿Olvidaste tu contraseña?</a>
                        </div>
                        <div class="text-center mt-2">
                            <p>¿No tenés una cuenta? <a class="enlace" href="./registro.php">Registrate</a></p>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</body>
</html>

