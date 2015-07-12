<?php

function traduz_prioridade($codigo) {
    $prioridade = '';
    switch ($codigo) {
        case 1:
            $prioridade = 'Baixa';
            break;
        case 2:
            $prioridade = 'Média';
            break;
        case 3:
            $prioridade = 'Alta';
            break;
    }
    return $prioridade;
}

function traduz_data_para_banco($data) {
    if ($data == '') {
        return '';
    }

    $dados = explode("/", $data);

    if (count($dados) != 3) {
        return $data;
    }

    $data_mysql = "{$dados[2]}-{$dados[1]}-{$dados[0]}";
    return $data_mysql;
}

function traduz_data_para_exibir($data) {
    if ($data == "" OR $data == "0000-00-00") {
        return "";
    }

    if (strlen($data) > 10) {
        $data = substr($data, 0, 10);
    }

    $dados = explode("-", $data);

    if (count($dados) != 3) {
        return $data;
    }

    $data_exibir = "{$dados[2]}/{$dados[1]}/{$dados[0]}";
    return $data_exibir;
}

function traduz_concluida($concluida) {
    if ($concluida == 1) {
        return 'Sim';
    }

    return 'Não';
}

function tem_post() {
    if (count($_POST) > 0) {
        return true;
    }

    return false;
}

function validar_data($data) {
    $padrao = '/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$/';
    $resultado = preg_match($padrao, $data);

    if (!$resultado) {
        return false;
    }

    $dados = explode('/', $data);
    $dia = $dados[0];
    $mes = $dados[1];
    $ano = $dados[2];

    $resultado = checkdate($mes, $dia, $ano);
    return $resultado;
}

function tratar_anexo($anexo) {
    $padrao = '/^.+(\.pdf|\.zip)$/';
    $resultado = preg_match($padrao, $anexo['name']);

    if (!$resultado) {
        return false;
    }

    move_uploaded_file($anexo['tmp_name'], "anexos/{$anexo['name']}");

    return true;
}

function enviar_email($tarefa, $anexos = array()) {
    require "bibliotecas/PHPMailer/class.phpmailer.php";

    $corpo = preparar_corpo_email($tarefa, $anexos);

    // Acessar o sistema de e-mails; Fazer a autenticação com usuário e senha; Usar a opção para escrever um e-mail;
    $email = new PHPMailer();
    $email->IsSMTP();
    $email->Host = "mx1.hostinger.com.br";
    $email->Port = 2525;
    $email->SMTPSecure = 'ssl';
    $email->SMTPDebug = 2;
    $email->SMTPAuth = true;
    $email->Username = "daniel@danieldnl.zz.mu";
    $email->Password = "inthos01";
    $email->From = "daniel@danieldnl.zz.mu";

    // Digitar o e-mail do destinatário;
    $email->addAddress(EMAIL_NOTIFICACAO);

    // Digitar o assunto do e-mail;
    $email->Subject = "Aviso de tarefa: {$tarefa['nome']}";

    // Escrever o corpo do e-mail;
    $email->msgHTML($corpo);

    // Adicionar os anexos quando necessário;
    foreach ($anexos as $anexo) {
        $email->addAttachment("anexos/{$anexo['arquivo']}");
    }

    // Usar a opção de enviar o e-mail.
    //$email->send();
    if (!$email->send()) {
        echo $email->ErrorInfo;
        echo "<script type='text/javascript'> alert('Erro ao enviar msg');</script>";
    } else {
        echo "<script type='text/javascript'> alert('Msg enviada!');</script>";
    }
}

function enviar_email2($tarefa, $anexos = array()) {
    $corpo = preparar_corpo_email($tarefa, $anexos);

    // O remetente deve ser um e-mail do seu domínio conforme determina a RFC 822.
    // O return-path deve ser ser o mesmo e-mail do remetente.
    $headers = "MIME-Version: 1.1\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
    $headers .= "From: daniel@danieldnl.zz.mu\r\n"; // remetente
    $headers .= "Return-Path: daniel@danieldnl.zz.mu\r\n"; // return-path
    $envio = mail(EMAIL_NOTIFICACAO, "Aviso de tarefa: {$tarefa['nome']}", $corpo, $headers);

    if ($envio) {
        echo "<script type='text/javascript'> alert('Msg enviada!');</script>";
    } else {
        echo "<script type='text/javascript'> alert('Erro ao enviar msg');</script>";
    }
}

function preparar_corpo_email($tarefa, $anexos) {
    // Aqui vamos pegar o conteúdo processado do template_email.php
    // Falar para o PHP que não é para enviar o processamento para o navegador:
    ob_start();
    include "template_email.php";

    // Guardar o conteúdo do arquivo em uma variável;
    $corpo = ob_get_contents();

    // Falar para o PHP que ele pode voltar a mandar conteúdos para o navegador.
    ob_end_clean();

    return $corpo;
}

?>