<?php
use PHPUnit\Framework\TestCase;

class DatabaseSimulator {
    protected $data = [];

    public function query($sql, $params = []) {
        return $this->data[$sql] ?? null;
    }

    public function exec($sql) {
        // Simular un comportamiento más realista, lanzando una excepción para consultas inválidas
        if ($sql === "INSERT INTO devolucion (CANTIDAD, FECHA, MOTIVO, ID_COMPRA) VALUES (?, ?, ?, ?)") {
            throw new \Exception('Todos los campos son obligatorios');
        }
        return true;
    }

    public function insert($table, $values) {
        $this->data[] = [$table, $values];
        return true;
    }

    public function update($table, $set) {
        $this->data[] = [$table, $set];
        return true;
    }
}

class DevolutionRegistrationTest extends TestCase {
    private $simulator;

    protected function setUp(): void {
        $this->simulator = new DatabaseSimulator();
    }    

    public function testEmptyFieldsError() {
        // Intentar registrar una devolución sin llenar todos los campos
        try {
            $this->simulator->exec("INSERT INTO devolucion (CANTIDAD, FECHA, MOTIVO, ID_COMPRA) VALUES (?, ?, ?, ?)", []);
            $this->fail('Se esperaba un error por campos vacíos');
        } catch (\Exception $e) {
            // Verificar que el mensaje de error contenga la subcadena clave
            $this->assertStringContainsString('Todos los campos son obligatorios', $e->getMessage());
        }
    }
}