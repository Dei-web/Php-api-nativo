
<?php
require __DIR__ . '/../enrute.php';
require_once SRC_PATH.  'domain/Users.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtService
{
    private string $secret;
    private string $algo = 'HS256';
    private int $ttl; // segundos

    public function __construct(string $secret, int $ttl = 3600)
    {
        $this->secret = $secret;
        $this->ttl = $ttl;
    }

    public function generateToken(User $user): string
    {
        $now = time();
        $payload = [
            'iss' => 'your-app',
            'sub' => $user->Get_id(),
            'email' => $user->Get_email(),
            'role' => $user->Get_role(),
            'iat' => $now,
            'exp' => $now + $this->ttl,
        ];

        return JWT::encode($payload, $this->secret, $this->algo);
    }

    public function verifyToken(string $jwt): array
    {
        $decoded = JWT::decode($jwt, new Key($this->secret, $this->algo));
        // lo convertimos a array
        return json_decode(json_encode($decoded), true);
    }
}
