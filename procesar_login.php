<?php
session_start();
require_once "conexion.php";

// Limpiar errores de login anteriores
unset($_SESSION['login_error']);

// Verificar si se recibieron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email']) && isset($_POST['password'])) {
    
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Preparar la consulta para evitar inyección SQL
    $sql = "SELECT id_usuario, nombre, email, password FROM usuarios WHERE email = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $param_email);
        $param_email = $email;
        
        if ($stmt->execute()) {
            $stmt->store_result();
            
            // Verificar si el usuario existe
            if ($stmt->num_rows == 1) {
                $stmt->bind_result($id, $nombre, $email_db, $hashed_password);
                if ($stmt->fetch()) {
                    // Verificar la contraseña
                    if (password_verify($password, $hashed_password)) {
                        // Contraseña correcta, iniciar sesión
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["nombre"] = $nombre;
                        $_SESSION["email"] = $email_db;
                        
                        // Redirigir al index
                        header("location: index.php");
                        exit;
                    } else {
                        // Contraseña incorrecta
                        $_SESSION['login_error'] = "La contraseña que ingresaste no es válida.";
                    }
                }
            } else {
                // El usuario no existe
                $_SESSION['login_error'] = "No se encontró ninguna cuenta con ese correo electrónico.";
            }
        } else {
            $_SESSION['login_error'] = "¡Ups! Algo salió mal. Por favor, inténtalo de nuevo más tarde.";
        }
        
        $stmt->close();
    }
    
    $conn->close();
} else {
    // No se enviaron los datos correctamente
    $_SESSION['login_error'] = "Por favor, ingresa tu correo y contraseña.";
}

// Si hubo un error, redirigir de vuelta al login
header("location: login.php");
exit;
?>
