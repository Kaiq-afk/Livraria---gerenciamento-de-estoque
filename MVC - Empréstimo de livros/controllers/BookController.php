<?php

require_once __DIR__ . '/../models/Book.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class BookController
{
    /** @var Book */
    private $bookModel;

    /**
     * BookController constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->bookModel = new Book($pdo);
    }

    /**
     * Redireciona e encerra a execução.
     * @param string $url
     */
    private function redirect(string $url = 'index.php'): void
    {
        header('Location: ' . $url);
        exit;
    }

    /**
     * Mostra a lista de livros.
     */
    public function index(): void
    {
        $books = $this->bookModel->all();
        require __DIR__ . '/../views/books/index.php';
    }

    /**
     * Exibe formulário vazio para criar um novo livro.
     */
    public function create(): void
    {
        $book = null;
        require __DIR__ . '/../views/books/form.php';
    }

    /**
     * Recebe POST para criar registro.
     */
    public function store(): void
    {
        $titulo = trim($_POST['titulo'] ?? '');
        $autor = trim($_POST['autor'] ?? '');
        $genero = trim($_POST['genero'] ?? '');
        $data = $_POST['data_lancamento'] ?? null;
        $estoque = isset($_POST['estoque']) ? (int)$_POST['estoque'] : 0;

        if ($titulo === '' || $autor === '' || $genero === '') {
            $_SESSION['error'] = "Preencha título, autor e gênero.";
            $this->redirect('index.php?action=create');
        }

        try {
            $this->bookModel->create([
                'titulo' => $titulo,
                'autor' => $autor,
                'genero' => $genero,
                'data_lancamento' => $data ?: null,
                'estoque' => $estoque
            ]);
            $_SESSION['success'] = "Livro criado com sucesso.";
        } catch (Exception $e) {
            // Em produção não exponha $e->getMessage() ao usuário - logue-o.
            $_SESSION['error'] = "Erro ao criar livro. Tente novamente.";
        }

        $this->redirect('index.php');
    }

    /**
     * Exibe formulário com dados do livro para edição.
     */
    public function edit(): void
    {
        $id = intval($_GET['id'] ?? 0);
        if ($id <= 0) {
            $_SESSION['error'] = "ID inválido.";
            $this->redirect('index.php');
        }

        // find() deve retornar array|null; tratamos null explicitamente
        $book = $this->bookModel->find($id);
        if ($book === null) {
            $_SESSION['error'] = "Livro não encontrado.";
            $this->redirect('index.php');
        }

        require __DIR__ . '/../views/books/form.php';
    }

    /**
     * Recebe POST para atualizar registro existente.
     */
    public function update(): void
    {
        $id = intval($_POST['id'] ?? 0);
        if ($id <= 0) {
            $_SESSION['error'] = "ID inválido.";
            $this->redirect('index.php');
        }

        $titulo = trim($_POST['titulo'] ?? '');
        $autor = trim($_POST['autor'] ?? '');
        $genero = trim($_POST['genero'] ?? '');
        $data = $_POST['data_lancamento'] ?? null;
        $estoque = isset($_POST['estoque']) ? (int)$_POST['estoque'] : 0;

        if ($titulo === '' || $autor === '' || $genero === '') {
            $_SESSION['error'] = "Preencha título, autor e gênero.";
            $this->redirect("index.php?action=edit&id={$id}");
        }

        // Verifica se o livro existe antes de atualizar (opcional, mas útil)
        $existing = $this->bookModel->find($id);
        if ($existing === null) {
            $_SESSION['error'] = "Livro não encontrado.";
            $this->redirect('index.php');
        }

        try {
            $this->bookModel->update($id, [
                'titulo' => $titulo,
                'autor' => $autor,
                'genero' => $genero,
                'data_lancamento' => $data ?: null,
                'estoque' => $estoque
            ]);
            $_SESSION['success'] = "Livro atualizado com sucesso.";
        } catch (Exception $e) {
            $_SESSION['error'] = "Erro ao atualizar livro. Tente novamente.";
        }

        $this->redirect('index.php');
    }

    /**
     * Exclui um livro pelo ID.
     */
    public function delete(): void
    {
        $id = intval($_GET['id'] ?? 0);
        if ($id <= 0) {
            $_SESSION['error'] = "ID inválido.";
            $this->redirect('index.php');
        }

        // Verifica existência antes de deletar (opcional)
        $existing = $this->bookModel->find($id);
        if ($existing === null) {
            $_SESSION['error'] = "Livro não encontrado.";
            $this->redirect('index.php');
        }

        try {
            $this->bookModel->delete($id);
            $_SESSION['success'] = "Livro excluído com sucesso.";
        } catch (Exception $e) {
            $_SESSION['error'] = "Erro ao excluir livro. Tente novamente.";
        }

        $this->redirect('index.php');
    }
}
