<?php
class Book {
    private $pdo;
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function all() {
        $stmt = $this->pdo->query("SELECT * FROM Livro ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM Livro WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create(array $data) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO Livro (titulo, autor, genero, data_lancamento, estoque) VALUES (?, ?, ?, ?, ?)"
        );
        return $stmt->execute([
            $data['titulo'],
            $data['autor'],
            $data['genero'],
            $data['data_lancamento'] ?: null,
            (int)$data['estoque']
        ]);
    }

    public function update($id, array $data) {
        $stmt = $this->pdo->prepare(
            "UPDATE Livro SET titulo = ?, autor = ?, genero = ?, data_lancamento = ?, estoque = ? WHERE id = ?"
        );
        return $stmt->execute([
            $data['titulo'],
            $data['autor'],
            $data['genero'],
            $data['data_lancamento'] ?: null,
            (int)$data['estoque'],
            (int)$id
        ]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM Livro WHERE id = ?");
        return $stmt->execute([(int)$id]);
    }
}
