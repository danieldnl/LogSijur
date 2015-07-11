<?php include_once 'classes/Usuario.php'; ?>

<div class="container">
    <div class="col-md-6 starter-template">
        <form action="" method="post">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="dtInicio">De</label>
                    <input type="text" class="form-control date" id="dtInicio" name="dtInicio" placeholder="Data de inicio" value="<?php echo (isset($_POST['dtInicio'])) ? $_POST['dtInicio'] : ''; ?>"  required>
                </div>
                <div class="form-group col-md-6">
                    <label for="dtFim">Até</label>
                    <input type="text" class="form-control date" id="dtFim" name="dtFim" placeholder="Data fim" value="<?php echo (isset($_POST['dtFim'])) ? $_POST['dtFim'] : ''; ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label for="Expediente">Expediente</label>
                        <input type="text" class="form-control expediente" id="expediente" name="expediente" placeholder="Expediente" value="<?php echo (isset($_POST['expediente'])) ? $_POST['expediente'] : ''; ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="usuario">Usuário</label>
                        <select id="usuario" class="form-control" name="usuario">
                            <option value="0">---</option>
                            <?php
                            $usr = new usuario();
                            $usuarios = $usr->listarUsuarios();

                            foreach ($usuarios as $usuario) {
                                if (isset($_POST['usuario']) && $_POST['usuario'] == $usuario->no_userid) {
                                    echo "<option value=\"$usuario->no_userid\" selected>$usuario->nome</option>";
                                } else {
                                    echo "<option value=\"$usuario->no_userid\">$usuario->nome</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Consultar</button>
        </form>
    </div>
</div>
