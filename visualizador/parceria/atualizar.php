<div class="col-md-12">
        <form action="<?php echo BASE_URL; ?>/parceria/atualizarFim/<?php echo $dtoParceria->getCdnParceria(); ?>" method="post">
            <div class="row">
                <div class="col-md-6 col-lg-3 form-group">
                    <label class="control-label" for="nomParceria">Nome</label>
                    <input required class="form-control" name="nomParceria" type="text" value="<?php echo $dtoParceria->getNomParceria(); ?>">
                </div>
                <div class="col-md-6 col-lg-3 form-group">
                    <label class="control-label" for="indPaciente">Indicação de paciente?</label>
                    <Br>
                    <input required name="indPaciente" value="1" type="radio" <?php echo $dtoParceria->getIndPaciente() ? 'checked' : ''; ?>> Sim
                    <input required name="indPaciente" value="0" type="radio" <?php echo !$dtoParceria->getIndPaciente() ? 'checked' : ''; ?>> Não
                    <br>
                    <br>
                </div>
                <div class="col-md-6 col-lg-3" id="paciente">
                    <?php echo $selectPaciente; ?>
                </div>
                <div class="col-md-6 col-lg-3" id="funcionario">
                    <?php echo $selectUsuario; ?>
                </div>
                <div class="col-md-6 col-lg-3 form-group">
                    <label class="control-label" for="strEndereco">Endereço</label>
                    <input class="form-control" name="strEndereco" type="text" value="<?php echo $dtoParceria->getStrEndereco(); ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-3 form-group">
                    <label class="control-label" for="nomCidade">Cidade</label>
                    <input class="form-control" name="nomCidade" type="text" value="<?php echo $dtoParceria->getNomCidade(); ?>">
                </div>
                <div class="col-md-6 col-lg-3 form-group">
                    <label class="control-label" for="codCep">CEP</label>
                    <input class="form-control mask-cep" name="codCep" type="text" value="<?php echo $dtoParceria->getCodCep(); ?>">
                </div>
                <div class="col-md-6 col-lg-3 form-group">
                    <label class="control-label" for="codUf">Estado</label>
                    <select class="form-control" name="codUf">
                        <option <?php echo strtolower($dtoParceria->getCodUf() == 'ac') ? 'selected' : ''; ?> value="ac">Acre</option>
                        <option <?php echo strtolower($dtoParceria->getCodUf() == 'al') ? 'selected' : ''; ?> value="al">Alagoas</option>
                        <option <?php echo strtolower($dtoParceria->getCodUf() == 'ap') ? 'selected' : ''; ?> value="ap">Amapá</option>
                        <option <?php echo strtolower($dtoParceria->getCodUf() == 'am') ? 'selected' : ''; ?> value="am">Amazonas</option>
                        <option <?php echo strtolower($dtoParceria->getCodUf() == 'ba') ? 'selected' : ''; ?> value="ba">Bahia</option>
                        <option <?php echo strtolower($dtoParceria->getCodUf() == 'ce') ? 'selected' : ''; ?> value="ce">Ceará</option>
                        <option <?php echo strtolower($dtoParceria->getCodUf() == 'df') ? 'selected' : ''; ?> value="df">Distrito Federal</option>
                        <option <?php echo strtolower($dtoParceria->getCodUf() == 'es') ? 'selected' : ''; ?> value="es">Espirito Santo</option>
                        <option <?php echo strtolower($dtoParceria->getCodUf() == 'go') ? 'selected' : ''; ?> value="go">Goiás</option>
                        <option <?php echo strtolower($dtoParceria->getCodUf() == 'ma') ? 'selected' : ''; ?> value="ma">Maranhão</option>
                        <option <?php echo strtolower($dtoParceria->getCodUf() == 'ms') ? 'selected' : ''; ?> value="ms">Mato Grosso do Sul</option>
                        <option <?php echo strtolower($dtoParceria->getCodUf() == 'mt') ? 'selected' : ''; ?> value="mt">Mato Grosso</option>
                        <option <?php echo strtolower($dtoParceria->getCodUf() == 'mg') ? 'selected' : ''; ?> value="mg">Minas Gerais</option>
                        <option <?php echo strtolower($dtoParceria->getCodUf() == 'pa') ? 'selected' : ''; ?> value="pa">Pará</option>
                        <option <?php echo strtolower($dtoParceria->getCodUf() == 'pb') ? 'selected' : ''; ?> value="pb">Paraíba</option>
                        <option <?php echo strtolower($dtoParceria->getCodUf() == 'pr') ? 'selected' : ''; ?> value="pr">Paraná</option>
                        <option <?php echo strtolower($dtoParceria->getCodUf() == 'pe') ? 'selected' : ''; ?> value="pe">Pernambuco</option>
                        <option <?php echo strtolower($dtoParceria->getCodUf() == 'pi') ? 'selected' : ''; ?> value="pi">Piauí</option>
                        <option <?php echo strtolower($dtoParceria->getCodUf() == 'rj') ? 'selected' : ''; ?> value="rj">Rio de Janeiro</option>
                        <option <?php echo strtolower($dtoParceria->getCodUf() == 'rn') ? 'selected' : ''; ?> value="rn">Rio Grande do Norte</option>
                        <option <?php echo strtolower($dtoParceria->getCodUf() == 'rs') ? 'selected' : ''; ?> value="rs">Rio Grande do Sul</option>
                        <option <?php echo strtolower($dtoParceria->getCodUf() == 'ro') ? 'selected' : ''; ?> value="ro">Rondônia</option>
                        <option <?php echo strtolower($dtoParceria->getCodUf() == 'rr') ? 'selected' : ''; ?> value="rr">Roraima</option>
                        <option <?php echo strtolower($dtoParceria->getCodUf() == 'sc') ? 'selected' : ''; ?> value="sc">Santa Catarina</option>
                        <option <?php echo strtolower($dtoParceria->getCodUf() == 'sp') ? 'selected' : ''; ?> value="sp">São Paulo</option>
                        <option <?php echo strtolower($dtoParceria->getCodUf() == 'se') ? 'selected' : ''; ?> value="se">Sergipe</option>
                        <option <?php echo strtolower($dtoParceria->getCodUf() == 'to') ? 'selected' : ''; ?> value="to">Tocantins</option>
                    </select>
                </div>
                <div class="col-md-6 col-lg-3 form-group">
                    <label class="control-label" for="indFisica">Pessoa física?</label>
                    <br>
                    <input <?php echo $dtoParceria->getIndFisica() ? 'checked' : ''; ?> name="indFisica" type="checkbox">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-3 form-group">
                    <label class="control-label" for="codCpfCnpj">CPF/CNPJ</label>
                    <input class="form-control mask-cpfcnpj" name="codCpfCnpj" type="text" value="<?php echo $dtoParceria->getCodCpfCnpj(); ?>">
                </div>
                <div class="col-md-6 col-lg-3 form-group">
                    <label class="control-label" for="codIe">Inscrição Estadual</label>
                    <input class="form-control" name="codIe" type="text" value="<?php echo $dtoParceria->getCodIe(); ?>">
                </div>
                <div class="col-md-6 col-lg-3 form-group">
                    <label class="control-label" for="numTelefone1">Número telefone 1</label>
                    <input class="form-control" name="numTelefone1" type="text"  value="<?php echo $dtoParceria->getNumTelefone1(); ?>">
                </div>
                <div class="col-md-6 col-lg-3 form-group">
                    <label class="control-label" for="numTelefone2">Número telefone 2</label>
                    <input class="form-control" name="numTelefone2" type="text"  value="<?php echo $dtoParceria->getNumTelefone2(); ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-3 form-group">
                    <label class="control-label" for="strEmail">E-mail</label>
                    <input class="form-control" name="strEmail" type="email" value="<?php echo $dtoParceria->getStrEmail(); ?>">
                </div>
                <div class="col-md-6 col-lg-3 form-group">
                    <label class="control-label" for="nomRepresentante">Nome representante</label>
                    <input class="form-control" name="nomRepresentante" type="text" value="<?php echo $dtoParceria->getNomRepresentante(); ?>">
                </div>
                <div class="col-md-6 col-lg-3 form-group">
                    <label class="control-label" for="numRepresentanteTelefone">Telefone representante</label>
                    <input class="form-control" name="numRepresentanteTelefone" type="text" value="<?php echo $dtoParceria->getNumRepresentanteTelefone(); ?>">
                </div>
                <div class="col-md-6 col-lg-3 form-group">
                    <label class="control-label" for="strRepresentanteEmail">E-mail representante</label>
                    <input class="form-control" name="strRepresentanteEmail" type="email" value="<?php echo $dtoParceria->getStrRepresentanteEmail(); ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-3 form-group">
                    <label class="control-label" for="datContrato">Data do contrato</label>
                    <input class="form-control mask-date" name="datContrato" type="date" value="<?php echo $dtoParceria->getDatContrato(); ?>">
                </div>
                <div class="col-md-6 col-lg-3 form-group">
                    <label class="control-label" for="numContrato">Número do contrato</label>
                    <input class="form-control" name="numContrato" type="text" value="<?php echo $dtoParceria->getNumContrato(); ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-12 form-group">
                    <label class="control-label" for="desParceria">Observações</label>
                    <textarea class="form-control" name="desParceria"><?php echo $dtoParceria->getDesParceria(); ?></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                    <button type="submit" class="btn btn-block btn-lg btn-primary">
                        Editar
                    </button>
                </div>
            </div>
        </form>
    </div>

</div>
