<?php
// Carrega os dados do arquivo JSON
$data_file = 'data.json';
$reservas = [];

if (file_exists($data_file)) {
    $reservas = json_decode(file_get_contents($data_file), true);
}

// Define a estrutura padrão se o arquivo não existir ou estiver vazio
if (empty($reservas)) {
    $reservas = [
        'info' => array_fill(0, 15, ''),
        'matematica' => array_fill(0, 15, ''),
        'desenho' => array_fill(0, 15, '')
    ];
    file_put_contents($data_file, json_encode($reservas));
}

// Horários das aulas
$horarios = [
    'Manhã' => ['07:00-07:45', '07:45-08:30', '08:30-09:15', '09:15-10:00', '10:00-10:45'],
    'Tarde' => ['13:00-13:45', '13:45-14:30', '14:30-15:15', '15:15-16:00', '16:00-16:45'],
    'Noite' => ['18:30-19:15', '19:15-20:00', '20:00-20:45', '20:45-21:30', '21:30-22:15']
];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Reserva de Laboratórios</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Sistema de Reserva de Laboratórios</h1>
        
        <div class="reserva-form">
            <h2>Fazer Reserva</h2>
            <form method="POST" action="reservar.php">
                <div class="form-group">
                    <label for="laboratorio">Laboratório:</label>
                    <select id="laboratorio" name="laboratorio" required>
                        <option value="info">Informática</option>
                        <option value="matematica">Matemática</option>
                        <option value="desenho">Desenho Técnico</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="turno">Turno:</label>
                    <select id="turno" name="turno" required>
                        <option value="0">Manhã</option>
                        <option value="1">Tarde</option>
                        <option value="2">Noite</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="aula">Aula:</label>
                    <select id="aula" name="aula" required>
                        <option value="0">1ª Aula</option>
                        <option value="1">2ª Aula</option>
                        <option value="2">3ª Aula</option>
                        <option value="3">4ª Aula</option>
                        <option value="4">5ª Aula</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="professor">Professor:</label>
                    <input type="text" id="professor" name="professor" required placeholder="Digite seu nome">
                </div>
                
                <button type="submit">Reservar</button>
            </form>
        </div>
        
        <h2>Quadro de Reservas</h2>
        
        <?php foreach ($reservas as $lab => $aulas): ?>
            <h3>Laboratório de <?= ucfirst($lab == 'info' ? 'Informática' : ($lab == 'matematica' ? 'Matemática' : 'Desenho Técnico')) ?></h3>
            <table>
                <tr>
                    <th>Turno</th>
                    <th>1ª Aula</th>
                    <th>2ª Aula</th>
                    <th>3ª Aula</th>
                    <th>4ª Aula</th>
                    <th>5ª Aula</th>
                </tr>
                
                <?php foreach (['Manhã', 'Tarde', 'Noite'] as $idx => $turno): ?>
                    <tr>
                        <td class="turno-header"><?= $turno ?></td>
                        <?php for ($i = 0; $i < 5; $i++): 
                            $pos = $idx * 5 + $i;
                            $professor = $aulas[$pos];
                        ?>
                            <td class="<?= !empty($professor) ? 'reservado' : '' ?>">
                                <?= htmlspecialchars($professor) ?>
                                <?php if (!empty($professor)): ?>
                                    <form method="POST" action="cancelar.php" class="cancelar-form">
                                        <input type="hidden" name="laboratorio" value="<?= $lab ?>">
                                        <input type="hidden" name="posicao" value="<?= $pos ?>">
                                        <button type="submit" class="cancelar-btn">X</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        <?php endfor; ?>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endforeach; ?>
    </div>
</body>
</html>