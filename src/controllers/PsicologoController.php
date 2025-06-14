<?php

class PsicologoController
{
    private $pdo; // ✅ adiciona a propriedade

    public function __construct($pdo)
    {
        $this->pdo = $pdo; // ✅ armazena o objeto PDO
    }

    public function perfil()
    {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'psicologo') {
            header('Location: /?rota=login');
            exit;
        }

        $usuario_id = $_SESSION['usuario']['id'];

        $stmt = $this->pdo->prepare("SELECT * FROM psicologos WHERE usuario_id = ?");
        $stmt->execute([$usuario_id]);
        $dados = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];

        include __DIR__ . '/../views/psicologo/perfil.php';
    }
    public function editarPerfil()
    {
        $usuarioId = $_SESSION['usuario']['id'];
    
        $stmt = $this->pdo->prepare("SELECT * FROM psicologos WHERE usuario_id = ?");
        $stmt->execute([$usuarioId]);
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);
    
        include __DIR__ . '/../views/psicologo/perfil.php';
    }
    public function atualizarPerfil()
    {
        /*if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'psicologo') {
            header('Location: /?rota=login');
            exit;
        }*/
        error_log('ID do usuário na sessão: ' . ($_SESSION['usuario']['id'] ?? 'nenhum'));

        if (!isset($_SESSION['usuario'])) {
            header('Location: /login');
            exit;
        }

        $usuario_id = $_SESSION['usuario']['id'];

        /*$foto = null;
        if (!empty($_FILES['foto']['name'])) {
            $nomeFoto = uniqid() . '-' . $_FILES['foto']['name'];
            $destino = __DIR__ . '/../../public/Uploads/PerfilPicture/' . $nomeFoto;
            move_uploaded_file($_FILES['foto']['tmp_name'], $destino);
            $foto = $nomeFoto;
        }*/

        if (!empty($_FILES['foto']['name'])) {
            // Buscar foto anterior
            $stmtFoto = $this->pdo->prepare("SELECT foto_perfil FROM psicologos WHERE usuario_id = ?");
            $stmtFoto->execute([$usuario_id]);
            $fotoAntiga = $stmtFoto->fetchColumn();
        
            // Apagar foto anterior se existir
            if ($fotoAntiga) {
                $caminhoAntigo = __DIR__ . '/../public/Uploads/PerfilPicture/' . $fotoAntiga;
                if (file_exists($caminhoAntigo)) {
                    unlink($caminhoAntigo);
                }
            }
        
            // Salvar nova foto
            $nomeFoto = uniqid() . '-' . $_FILES['foto']['name'];
            $destino = __DIR__ . '/../public/Uploads/PerfilPicture/' . $nomeFoto;
            move_uploaded_file($_FILES['foto']['tmp_name'], $destino);
            $foto = $nomeFoto;
        }
        
        $foto = null;
        if (!empty($_FILES['foto']['name'])) {
            $nomeFoto = uniqid() . '-' . $_FILES['foto']['name'];
            $destino = __DIR__ . '/../../public/Uploads/PerfilPicture/' . $nomeFoto;
            move_uploaded_file($_FILES['foto']['tmp_name'], $destino);
            $foto = $nomeFoto;
        }

        $dados = [
            'crp' => $_POST['crp'],
            'cpf' => $_POST['cpf'],
            'telefone' => $_POST['telefone'],
            'especialidades' => $_POST['especialidades'],
            'endereco' => $_POST['endereco'],
            'complemento' => $_POST['complemento'],
            'cep' => $_POST['cep'],
            'cidade' => $_POST['cidade'],
            'estado' => $_POST['estado'],
            'bio' => $_POST['bio'],
            'foto_perfil' => $foto,
        ];

        $stmt = $this->pdo->prepare("SELECT id FROM psicologos WHERE usuario_id = ?");
        $stmt->execute([$usuario_id]);

        if ($stmt->rowCount() > 0) {
            if ($foto) {
                $sql = "UPDATE psicologos SET crp=?, cpf=?, telefone=?, especialidades=?, endereco=?, complemento=?, cep=?, cidade=?, estado=?, bio=?, foto_perfil=? WHERE usuario_id=?";
                $params = [
                    $_POST['crp'],
                    $_POST['cpf'],
                    $_POST['telefone'],
                    $_POST['especialidades'],
                    $_POST['endereco'],
                    $_POST['complemento'],
                    $_POST['cep'],
                    $_POST['cidade'],
                    $_POST['estado'],
                    $_POST['bio'],
                    $foto,
                    $usuario_id
                ];
            } else {
                $sql = "UPDATE psicologos SET crp=?, cpf=?, telefone=?, especialidades=?, endereco=?, complemento=?, cep=?, cidade=?, estado=?, bio=? WHERE usuario_id=?";
                $params = [
                    $_POST['crp'],
                    $_POST['cpf'],
                    $_POST['telefone'],
                    $_POST['especialidades'],
                    $_POST['endereco'],
                    $_POST['complemento'],
                    $_POST['cep'],
                    $_POST['cidade'],
                    $_POST['estado'],
                    $_POST['bio'],
                    $usuario_id
                ];
            }
            
        } else {
            $sql = "INSERT INTO psicologos (crp, cpf, telefone, especialidades, endereco, complemento, cep, cidade, estado, bio, foto_perfil, usuario_id) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $params = array_merge(array_values($dados), [$usuario_id]);
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        $_SESSION['mensagem'] = 'Perfil atualizado com sucesso!';
        
        header('Location: /perfil');
        exit;
    }

    public function verPerfil($id)
    {
        $stmt = $this->pdo->prepare("SELECT u.id as usuario_id, u.nome, p.especialidades, p.bio, p.foto_perfil 
                                    FROM psicologos p
                                    JOIN usuarios u ON u.id = p.usuario_id
                                    WHERE p.usuario_id = ?");
        $stmt->execute([$id]);
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$dados) {
            echo "Psicólogo não encontrado.";
            exit;
        }

        // Pega usuário logado
        $usuarioLogado = $_SESSION['usuario'] ?? null;
        $jaSeguindo = false;

        if ($usuarioLogado && $usuarioLogado['id'] !== $dados['usuario_id']) {
            $stmtSeguindo = $this->pdo->prepare("SELECT 1 FROM seguidores WHERE seguidor_id = ? AND seguido_id = ?");
            $stmtSeguindo->execute([$usuarioLogado['id'], $dados['usuario_id']]);
            $jaSeguindo = $stmtSeguindo->fetchColumn();
        }

        include __DIR__ . '/../views/psicologo/exibir_perfil.php';
    }


    public function listarPsicologos()
    {
        $stmt = $this->pdo->query("SELECT u.id, u.nome, p.foto_perfil FROM usuarios u 
                                JOIN psicologos p ON u.id = p.usuario_id 
                                WHERE u.tipo = 'psicologo'");

        $psicologos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        include __DIR__ . '/../views/psicologo/lista_psicologos.php';
    }



}
