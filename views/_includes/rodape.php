<?php if ( ! defined('ABSPATH')) exit; ?>

            <script type="text/javascript">
                
                $(document).ready(function () {

                // Modais Bootstrap
                
                $('.launch-modal-alert').click(function(){
                    $('#alertaModal').modal({
                        keyboard: true,
                        backdrop: 'static'
                    });
                }); 
                
                $('.launch-modal').click(function(){ // Modal com botão fechar.
                    $('#sigcadModal').modal({
                        keyboard: true,
                        backdrop: 'static'
                    });                 
                });
                
                $('.launch-modal-detalhar').click(function(){ // Modal com botão fechar.
                    $('#sigcadModalDetalhar').modal({
                        keyboard: true,
                        backdrop: 'static'
                    });                 
                });
                
                $('#myTab a').click(function (e) {
                  e.preventDefault()
                  $(this).tab('show')
                }) ;                
                
                $('.launch-modalsemBotao').click(function(){ // Modal sem botão fechar.
                    $('#sigcadModalsemBotao').modal({
                        keyboard: false,
                        backdrop: 'static'
                    });             
                });         
                
                //Fim Modais Bootstrap        
                    
                    }); 

            </script>
 
                <div class="modal-sigcad">
                    <!-- Button HTML (to Trigger Modal) -->
                    <input style="display:none ; " type="button" id="alerta-sigcad-sem-botao" class="btn btn-lg btn-primary launch-modalsemBotao" value="botão Modal">
                    <!-- Modal HTML -->
                    <div id="sigcadModalsemBotao" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 id='div_titulo' class="modal-title">Pesquisando....</h4>
                                </div>
                                <div class="modal-body">
                                    <div id='div_resultado_sem_botao' class="alert alert-default" role="alert">...</div>
                                </div>
                                <div class="modal-footer" >
                                    <div class="row text-center">
                                        <button style="display:none;" id='fechar-modal' type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                    </div>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="modal-sigcad">
                    <!-- Button HTML (to Trigger Modal) -->
                    <input style="display:none ; " type="button" id="alerta-sigcad" class="btn btn-lg btn-primary launch-modal" value="botão Modal">
                    <!-- Modal HTML -->
                    <div id="sigcadModal" class="modal fade">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title"></h4>
                                </div>
                                <div class="modal-body">
                                    <div id='div_resultado' class="alert alert-default" role="alert">...</div>
                                </div>
                                <div class="modal-footer" >
                                    <div class="row text-center">
                                        <button type="button" id="fechar-modal-resultado" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                    </div>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-sigcad-detalhar">
                    <!-- Button HTML (to Trigger Modal) -->
                    <input style="display:none ; " type="button" id="alerta-sigcad-detalhar" class="btn btn-lg btn-primary launch-modal-detalhar" value="botão Modal">
                    <!-- Modal HTML -->
                    <div id="sigcadModalDetalhar" class="modal fade">
                        <div class="modal-dialog modal-lg ">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title"></h4>
                                </div>
                                <div class="modal-body">
                                    <div id='div_detalhar' class="alert alert-default" role="alert">...</div>
                                </div>
                                <div class="modal-footer" >
                                    <div class="row text-center">
                                        <button type="button"  id="fechar-modal-detalhar" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                    </div>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-sigcad-pr">
                    <!-- Button HTML (to Trigger Modal) -->
                    <input style="display:none ; " type="button" id="alerta-sigcad-pr" class="btn btn-lg btn-primary launch-modal-alert" value="botão Modal">
                    <!-- Modal HTML -->
                    <div id="alertaModal" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title">Alerta!</h4>
                                </div>
                                <div class="modal-body">
                                    <div  id='alert' class="alert alert-danger" role="alert">Preencha os campos necessários e clique em pesquisar.</div>
                                </div>
                                <div class="modal-footer" >
                                    <div class="row text-center">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                    </div>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
               <div id="rodape">
                    <label>Versão 1.3.1  - ©2016 -  Ministério do Desenvolvimento Social.</label>
                </div>

	</div><!-- /.container-fluid -->

</div> <!-- .main-page (header.php) -->

</body>
</html>
