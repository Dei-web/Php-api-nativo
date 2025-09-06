
<?php


require __DIR__ . '/../../enrute.php';
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

class DatabaseConecction
{
    public $connection;
    private $host;
    private $user;
    private $pass;
    private $db;

    public function __construct()
    {
        $this->host = $_ENV['DB_HOST'];
        $this->user = $_ENV['POSTGRES_USER'];
        $this->pass = $_ENV['POSTGRES_PASSWORD'];
        $this->db   = $_ENV['POSTGRES_DB'];

        try {
            $this->connection = new PDO(
                "pgsql:host={$this->host};dbname={$this->db};port=5432",
                $this->user,
                $this->pass
            );

            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("❌ Error de conexión: " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
