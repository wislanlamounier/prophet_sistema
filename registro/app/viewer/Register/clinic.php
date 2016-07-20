<div class="row">

    <div class="col-md-6">
        <h2 class="font-bold">Quase lá!</h2>

        <p>
            Para completar o cadastro no sistema, insira algumas informações sobre você e sua clínica.
        </p>
        
        <p>
            Aceitamos pessoas físicas e jurídicas. Informe o documento pertinente à clinica: CNPJ se jurídica, CPF se física.
        </p>
        
        <small>
            Estas são informações básicas. Ao final do cadastro, você terá a opção de completar as informações.
        </small>
        

    </div>
    <div class="col-md-6">
        <div class="ibox-content">
            <form class="m-t" method="post" role="form" action="register/clinic">
                <div class="form-group">
                    <input type="text" name="name" class="form-control" placeholder="Nome da clínica" required="">
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="E-mail de contato" required="">
                </div>
                <div class="form-group">
                    <input type="text" name="document" class="form-control" placeholder="CPF/CNPJ" required="">
                </div>
                <hr>
                <div class="form-group">
                    <input type="number" name="cro" class="form-control" placeholder="Seu CRO" required="">
                </div>
                <div class="form-group">
                    <input type="text" name="phone" class="form-control mask-phone" placeholder="Telefone de contato" required="">
                </div>
                <hr>
                <div class="form-group">
                    <label for="size" class="control-label">Informe-nos um pouco sobre seu local de trabalho</label><br>
                    <input type="radio" selected name="size" value="Consultorio sozinho"> Tenho consultório sozinho <br>
                    <input type="radio" name="size" value="Consultorio c colegas"> Divido consultório com mais colegas <br>
                    <input type="radio" name="size" value="Clinica"> Tenho uma clínica
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">
                    Continuar
                    <i class="fa fa-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>
</div>