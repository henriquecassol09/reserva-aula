<?php
// Verifica se o método é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// Carrega os dados existentes
$data_file = 'data.json';
$reservas = json_decode(file_get_contents($data_file), true);

// Processa os dados do formulário
$laboratorio = $_POST['laboratorio'];
$turno = (int)$_POST['turno'];
$aula = (int)$_POST['aula'];
$professor = trim($_POST['professor']);

// Calcula a posição no array
$posicao = $turno * 5 + $aula;

// Validação
if (empty($professor) || !array_key_exists($laboratorio, $reservas) || $posicao < 0 || $posicao >= 15) {
    header('Location: index.php?erro=1');
    exit;
}

// Verifica se já está reservado
if (!empty($reservas[$laboratorio][$posicao])) {
    header('Location: index.php?erro=2');
    exit;
}

// Faz a reserva
$reservas[$laboratorio][$posicao] = $professor;

// Salva no arquivo
file_put_contents($data_file, json_encode($reservas));

// Redireciona de volta
header('Location: index.php?sucesso=1');
exit;
?>