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
$posicao = (int)$_POST['posicao'];

// Validação
if (!array_key_exists($laboratorio, $reservas) || $posicao < 0 || $posicao >= 15) {
    header('Location: index.php?erro=3');
    exit;
}

// Cancela a reserva
$reservas[$laboratorio][$posicao] = '';

// Salva no arquivo
file_put_contents($data_file, json_encode($reservas));

// Redireciona de volta
header('Location: index.php?sucesso=2');
exit;
?>