<?php
declare(strict_types = 1);
class Database
{

    private PDO $pdo;
    public function __construct()
    {
        $dbPath = __DIR__ . '/db/shortner_db.db';
        $this->pdo = new PDO('sqlite:' . $dbPath);
    }
    public function insertLink($link, $shortCode): ?int
    {
        $expireDay = date("Y-m-d", strtotime("+30 days"));
        $stmt = $this->pdo->prepare("INSERT INTO urls (long_url, short_code, expires_at) VALUES (?, ?, ?)");
        $stmt->execute([$link, $shortCode, $expireDay]);
        return (int) $this->pdo->lastInsertId();
    }

    public function getLink($shortCode): ?string {
        $stmt = $this->pdo->prepare("SELECT * FROM urls WHERE short_code = ?");
        $stmt->execute([$shortCode]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['long_url'];
    }

    public function incrementHit($id) {
        $stmt = $this->pdo->prepare("UPDATE urls SET hit_count = hit_count + 1 WHERE ig = ?");
        $stmt->execute([$id]);
    }



}
