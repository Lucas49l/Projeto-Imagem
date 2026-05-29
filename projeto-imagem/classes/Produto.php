<?php
class Produto{
    private $pdo;

    public function __construct() {
        $dns = "mysql:host=localhost;dbname=loja";
        $user = "root";
        $pass = "";
        try {
            $this->pdo = new PDO($dns, $user, $pass);
            echo "conexão relizada com sucesso!";
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }

    public function enviarProduto ($nome, $descricao, $foto = array()) {
        $sql = 'INSERT INTO produto (nome, descricao) VALUES (:n, :d)';
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':n', $nome);
        $stmt->bindValue(':d', $descricao);

        $result = $stmt->execute();

        if ($result) {
            $id_produto = $this->pdo->lastInsertId();
            echo "$id_produto"; // lastInsertId() busca o último id inserido na tabela
        //inserir imagens na tabela com o id do produto inserido anteriormente
            if (count($foto) > 0) {
                for ($i = 0; $i < count($foto); $i++) {
                    $foto_nome = $foto[$i];
                    $sql = 'INSERT INTO imagem(nome_imagem, id_produto) VALUES(:n, :p)';
                    $stmt = $this->pdo->prepare($sql);

                    $stmt->bindValue(':n', $foto_nome);
                    $stmt->bindValue(':p', $id_produto);
                    echo "imagem inserida: $foto_nome";
                    return $stmt->execute();
                }
            }
        }else{
            echo "Erro ao cadastrar produto";
        }
    }

    public function buscarProdutos() {
        $sql = 'SELECT * FROM produto';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return $stmt->fetch();
        }else{
            return Array();
        }
    }

    public function buscarProduto($id) {
        $sql = 'SELECT * FROM produto WHERE id_produto = :i';
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->bindValue(':i', $id);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            return $stmt->fetch();
        }else{
            return Array();
        }
    }

    public function buscarImagem($id){
        $sql = 'SELECT * FROM imagem WHERE id_produto = :i';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':i', $id);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return $stmt->fetch();
        }else{
            return Array();
        }
    }

    public function buscarProdutoImagem($id){
        $sql = 'SELECT pr.nome, pr.descricao, group_concat(im.nome_imagem) AS imagem
                FROM produto AS pr
                JOIN imagem AS im
                    ON pr.id_produto = im.id_produto
                WHERE pr.id_produto = :i
                GROUP BY pr.nome';

        $stmt = $this->pdo->execute($sql);
        $stmt->bindValue(':i', $id);
        $result = $stmt->fatchAll();
        return $result;
    }
}