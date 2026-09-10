/* ============================================================
   UTILITÁRIOS COMPARTILHADOS
   Usado por infoServico.js, agendamentoCli.js e consultasCli.js.
   Depende de: jQuery, Bootstrap 5 (bundle JS).
   Deve ser carregado ANTES do script de cada página.

   Concentra aqui o que antes estava duplicado (com pequenas
   divergências) em cada arquivo de página: leitura de parâmetro
   de URL, controle de modal via API nativa do Bootstrap 5,
   preenchimento de campos "data-campo" e o toggle de
   acessibilidade do skeleton de carregamento.
   ============================================================ */

(function ($, window) {
  "use strict";

  var ElmoUtilitarios = {

  
    obterParametroUrl: function (nome) {
      var parametros = new URLSearchParams(window.location.search);
      return parametros.get(nome);
    },

    obterInstanciaModal: function ($elementoModal, opcoes) {
      return bootstrap.Modal.getOrCreateInstance($elementoModal.get(0), opcoes);
    },

    exibirModal: function ($elementoModal, opcoes) {
      this.obterInstanciaModal($elementoModal, opcoes).show();
    },

    esconderModal: function ($elementoModal) {
      var instancia = bootstrap.Modal.getInstance($elementoModal.get(0));
      if (instancia) {
        instancia.hide();
      }
    },


    preencherCampos: function ($camposDinamicos, dados) {
      $camposDinamicos.each(function () {
        var $elemento = $(this);
        var nomeCampo = $elemento.data("campo");

        if (!(nomeCampo in dados)) {
          return;
        }

        if (this.tagName === "IMG") {
          $elemento.attr("src", dados[nomeCampo]);

          var nomeCampoAlt = $elemento.data("campo-alt");
          if (nomeCampoAlt && dados[nomeCampoAlt]) {
            $elemento.attr("alt", dados[nomeCampoAlt]);
          }
          return;
        }

        if (this.tagName === "INPUT") {
          $elemento.val(dados[nomeCampo]);
          return;
        }

        $elemento.text(dados[nomeCampo]);
      });
    },

    alternarEsqueletoAcessivel: function ($camposDinamicos, ativo) {
      if (ativo) {
        $camposDinamicos.attr("aria-hidden", "true");
      } else {
        $camposDinamicos.removeAttr("aria-hidden");
      }
    }
  };

  window.ElmoUtilitarios = ElmoUtilitarios;

})(jQuery, window);
