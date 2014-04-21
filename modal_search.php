<!-- Modal Pesquisa-->
<div class="modal fade" id="Modal_search" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <div class="icon"></div>
        <h4 class="modal-title" id="myModalLabel">Pesquisa</h4>
      </div>
      <div class="modal-body">
        <form class="form-inline" role="form" action="search.php" >
          <div class="form-group col-sm-12">
            <input type="text" class="form-control" id="search_bundle" name="search_bundle" placeholder="Procure aqui nome do bundle....">
          </div>
        </form>
        <h3 id="results-text">Resultados de: <b id="search-string"></b></h3>
        <ul id="results"></ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal Login-->
<div class="modal fade" id="Modal_login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Entrar na sua Conta</h4>
      </div>
      <div class="modal-body">
        <form class="form-inline" role="form" id="form_login">
          <div class="form-group">
            <label for="entrar_user">Nome de Utilizador</label>
            <input type="text" class="form-control clearable" id="entrar_user" name="entrar_user" required placeholder="Nome de Utilizador">
            <div id="msg_user_log" class="msg_register"></div>
          </div>
          <div class="form-group">
            <label for="entrar_password">Password</label>
            <input type="password" class="form-control clearable" id="entrar_password" name="entrar_password" required placeholder="Password">
            <div id="msg_pass_log" class="msg_register"></div>
          </div>
          <div class="checkbox">
            <label><input type="checkbox" name="entrar_save" value="on">Lembrar-me da próxima vez que cá vier!!</label>
          </div>
        </form>
        <div class="message">    
          <div id="message_login" style="display:none;"></div>
        </div>
      </div>
      <div class="modal-footer">
          <button type="submit" class="btn btn-default" id="bt_login">Entrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal Registar-->
<div class="modal fade" id="Modal_register" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="margin-top:0px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" id="close_register" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Registar-se</h4>
      </div>
      <div class="modal-body">
        <form class="form-inline" role="form" id="form_registar">
          <div class="form-group">
            <label for="registar_nome">Nome Completo* <small>para faturação</small> </label>
            <input type="text" class="form-control clearable" id="registar_nome" name="registar_nome" required placeholder="Nome Completo">
            <div id="msg_name"></div>
          </div>
          <div class="form-group">
            <label for="registar_user">Nome de Utilizador* <small>para login</small> </label>
            <input type="text" class="form-control clearable" id="registar_user" name="registar_user" required placeholder="Nome de Utilizador">
            <div id="msg_username" class="msg_register"></div>
            <br>
            <div id="msg_username_text"></div>
          </div>
          <div class="form-group">
            <label for="registar_email">Email*</label>
            <input type="email" class="form-control clearable" id="registar_email" name="registar_email" required placeholder="Email">
            <div id="msg_email" class="msg_register"></div>
            <br>
            <div id="msg_email_text"></div>
          </div>
          <div class="form-group">
            <label for="registar_password">Password*</label><span class="info_register">Min 6 Caracteres, numeros e digitos aceitaveis!</span>
            <input type="password" class="form-control clearable" id="registar_password" name="registar_password" required placeholder="Password">
            <div id="msg_password" class="msg_register"></div>
            <br>
            <div id="msg_password_text"></div>
          </div>
          <div class="form-group">
            <label for="registar_pass">Confirmar Password*</label>
            <input type="password" class="form-control clearable" id="registar_pass" name="registar_pass" required placeholder="Repita a Password">
            <div id="msg_password_2" class="msg_register"></div>
             <div id="msg_password_2_text"></div>
          </div>
          <div class="checkbox">
            <label>
              <input type="checkbox" required name="registar_agree" value="on">Eu aceito os <a href="/terms" target="_blank">Termos e condições de serviço</a> 
            </label>
            <br>
            <div id="msg_agree"></div>
            <br>
            <label><input type="checkbox" name="registar_notificar" value="on">Gostaria de ser informado de promoções existentes!!!</label>
          </div>
          <div class="message">    
            <div id="message_registar" style="display:none;"></div>
            <div id="message_registar_icon" style="display:none;"></div>
            <div id="message_registar_email" style="display:none;"></div>
          <div class="modal-footer">
            <button type="reset" class="btn btn-default" id="bt_reset_registar">Limpar dados</button>
            <button type="submit" class="btn btn-default" id="bt_registar">Registar-se</button>
          </div>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->