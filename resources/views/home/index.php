<?php ?>
<?= import('_layouts/menus/header'); ?>
<ol>
    <li>Criar função para sempre que um arquivo for criado/upload/deletado, acessar a tabela settings e atualizar o storage_usage no formato (x.y GB/TB...),
        além disso, validar sempre se a soma dos arquivos enviados será maior que o storage_limit, para retornar msg ao usuario</li>
    <li>Ao criar a pasta de onde os arquivos ficarão armazenados, deve-se criar a pasta fora da public</li>
    <hr>
    <li>Quando o projeto terminar, copie o arquivo default.json e renomeio para english.json o arquivo copiado.</li>
</ol>