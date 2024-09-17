<?php
use PHPUnit\Framework\TestCase;

// Clase de Abstracción de la Base de Datos
class DatabaseAccess {
    protected $conn;

    public function __construct($connection) {
        $this->conn = $connection;
    }

    public function getUserByEmailAndPassword($email, $password) {
        // Simulación de la consulta a la base de datos para este ejemplo
        return $email === 'valid@example.com' && $password === 'password123';
    }
}

// Función de Inicio de Sesión Refactorizada
function loginUser(array $credentials, DatabaseAccess $dbAccess): bool {
    return $dbAccess->getUserByEmailAndPassword($credentials['email'], $credentials['password']);
}

// Clase de Prueba
class LoginTest extends TestCase
{
    public function testValidCredentials()
    {
        $mockDbAccess = $this->getMockBuilder(DatabaseAccess::class)
                             ->disableOriginalConstructor()
                             ->getMock();

        $mockDbAccess->expects($this->once())
                     ->method('getUserByEmailAndPassword')
                     ->with('valid@example.com', 'password123')
                     ->willReturn(true);

        $isValid = loginUser(['email' => 'valid@example.com', 'password' => 'password123'], $mockDbAccess);

        $this->assertTrue($isValid, 'El inicio de sesión con credenciales válidas debería ser exitoso.');
    }

    public function testInvalidCredentials()
    {
        $mockDbAccess = $this->getMockBuilder(DatabaseAccess::class)
                             ->disableOriginalConstructor()
                             ->getMock();

        $mockDbAccess->expects($this->once())
                     ->method('getUserByEmailAndPassword')
                     ->with('invalid@example.com', 'wrongpassword')
                     ->willReturn(false);

        $isValid = loginUser(['email' => 'invalid@example.com', 'password' => 'wrongpassword'], $mockDbAccess);

        $this->assertFalse($isValid, 'El inicio de sesión con credenciales inválidas debería fallar.');
    }
}

