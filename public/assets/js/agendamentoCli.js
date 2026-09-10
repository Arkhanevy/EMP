/* ============================================================
   PÁGINA: agendamentoCli (Agendamento)
   Depende de: jQuery, Bootstrap 5 (bundle JS), ElmoUtilitarios
   (ver /assets/js/utilitarios.js — deve ser carregado antes deste arquivo)

   Responsabilidades deste arquivo:
   - Buscar no backend PHP (via AJAX): valor, profissional,
     localizações disponíveis e dias/horários indisponíveis.
   - Construir o calendário customizado (navegação de mês,
     dias indisponíveis, seleção de dia).
   - Construir os dropdowns customizados de Localização e Horário.
   - Validar o formulário ao confirmar o agendamento.
   - Verificar se o usuário está logado antes de enviar o
     agendamento; se não estiver, exibir o modal correspondente.
   - Ao concluir com sucesso, redirecionar para infoServico com
     "?agendado=1" (ver infoServico.js).
   ============================================================ */

(function ($, Utilitarios) {
  "use strict";

  var NOMES_MES = [
    "JAN", "FEV", "MAR", "ABR", "MAI", "JUN",
    "JUL", "AGO", "SET", "OUT", "NOV", "DEZ"
  ];

  var NOMES_MES_COMPLETO = [
    "janeiro", "fevereiro", "março", "abril", "maio", "junho",
    "julho", "agosto", "setembro", "outubro", "novembro", "dezembro"
  ];

  var NOMES_DIA_SEMANA = [
    "domingo", "segunda-feira", "terça-feira", "quarta-feira",
    "quinta-feira", "sexta-feira", "sábado"
  ];

  var moduloAgendamentoCli = {

    configuracao: {
      urlObterDadosAgendamento: "/backend/obterDadosAgendamento.php",
      urlObterDiasIndisponiveis: "/backend/obterDiasIndisponiveis.php",
      urlObterHorariosDisponiveis: "/backend/obterHorariosDisponiveis.php",
      urlVerificarLogin: "/backend/verificarLogin.php",
      urlCriarAgendamento: "/backend/criarAgendamento.php",
      urlInfoServico: "../infoServico/index.html",
      urlLogin: "/login/index.html",
      urlCadastro: "/cadastro/index.html"
    },

    estado: {
      idServico: null,
      dataExibida: new Date(),
      diasIndisponiveis: [],
      diaSelecionado: null,
      localizacaoSelecionada: null,
      horarioSelecionado: null
    },

    elementos: {},

    iniciar: function () {
      this.cachearElementos();
      this.estado.idServico = Utilitarios.obterParametroUrl("servico");
      this.elementos.$inputIdServico.val(this.estado.idServico || "");

      this.registrarEventos();
      this.buscarDadosAgendamento();
    },

    cachearElementos: function () {
      this.elementos.$form = $("#formularioAgendamento");
      this.elementos.$alerta = $("#alertaValidacao");
      this.elementos.$inputIdServico = $("#inputIdServico");
      this.elementos.$camposDinamicos = $("[data-campo]");

      this.elementos.$botaoVoltar = $("#botaoVoltar");
      this.elementos.$botaoCancelar = $("#botaoCancelarAgendamento");
      this.elementos.$botaoConfirmar = $("#botaoConfirmarAgendamento");

      this.elementos.$dropdownLocalizacao = $("#dropdownLocalizacao");
      this.elementos.$botaoLocalizacao = $("#botaoDropdownLocalizacao");
      this.elementos.$textoLocalizacao = $("#textoLocalizacaoSelecionada");
      this.elementos.$listaLocalizacoes = $("#listaLocalizacoes");
      this.elementos.$inputLocalizacao = $("#inputLocalizacaoSelecionada");

      this.elementos.$calendario = $("#calendarioAgendamento");
      this.elementos.$tituloMesAno = $("#calendarioTitulo");
      this.elementos.$botaoMesAnterior = $("#botaoMesAnterior");
      this.elementos.$botaoProximoMes = $("#botaoProximoMes");
      this.elementos.$grade = $("#calendarioGrade");
      this.elementos.$inputDia = $("#inputDiaSelecionado");

      this.elementos.$dropdownHorario = $("#dropdownHorario");
      this.elementos.$botaoHorario = $("#botaoDropdownHorario");
      this.elementos.$textoHorario = $("#textoHorarioSelecionado");
      this.elementos.$listaHorarios = $("#listaHorarios");
      this.elementos.$inputHorario = $("#inputHorarioSelecionado");

      this.elementos.$modalErro = $("#modalServicoNaoEncontrado");
      this.elementos.$botaoTentarNovamente = $("#botaoTentarNovamente");

      this.elementos.$modalNaoLogado = $("#modalNaoLogado");
      this.elementos.$botaoRealizarLogin = $("#botaoRealizarLogin");
    },

    registrarEventos: function () {
      var self = this;

      this.elementos.$botaoVoltar.on("click", function () {
        self.cancelarAgendamento();
      });

      this.elementos.$botaoCancelar.on("click", function () {
        self.cancelarAgendamento();
      });

      this.elementos.$form.on("submit", function (evento) {
        evento.preventDefault();
        self.tentarConfirmarAgendamento();
      });

      this.elementos.$botaoMesAnterior.on("click", function () {
        self.navegarMes(-1);
      });

      this.elementos.$botaoProximoMes.on("click", function () {
        self.navegarMes(1);
      });

      this.elementos.$botaoLocalizacao.on("click", function (evento) {
        evento.stopPropagation();
        self.alternarDropdown(
          self.elementos.$dropdownLocalizacao,
          self.elementos.$inputLocalizacao
        );
      });

      this.elementos.$botaoHorario.on("click", function (evento) {
        evento.stopPropagation();
        if ($(this).is(":disabled")) {
          return;
        }
        self.alternarDropdown(
          self.elementos.$dropdownHorario,
          self.elementos.$inputHorario
        );
      });

      $(document).on("click", function (evento) {
        if (!$(evento.target).closest(".dropdownCustomizado").length) {
          self.fecharTodosDropdowns();
        }
      });

      $(document).on("keydown", function (evento) {
        if (evento.key !== "Escape") {
          return;
        }
        var $dropdownAberto = $(".dropdownCustomizado").filter(function () {
          return !$(this).find(".dropdownCustomizadoLista").attr("hidden");
        });
        self.fecharTodosDropdowns();
        $dropdownAberto.find(".dropdownCustomizadoBotao").trigger("focus");
      });

      this.elementos.$grade.on(
        "click",
        ".diaCalendario:not(.diaIndisponivel):not(.diaVazio)",
        function () {
          self.selecionarDia($(this).data("data"));
        }
      );

      this.elementos.$listaLocalizacoes.on(
        "click",
        ".dropdownCustomizadoItem",
        function () {
          self.selecionarLocalizacao(
            $(this).data("valor"),
            $(this).data("texto")
          );
        }
      );

      this.elementos.$listaHorarios.on(
        "click",
        ".dropdownCustomizadoItem",
        function () {
          self.selecionarHorario(
            $(this).data("valor"),
            $(this).data("texto")
          );
        }
      );

      this.registrarNavegacaoTecladoLista(
        this.elementos.$listaLocalizacoes
      );

      this.registrarNavegacaoTecladoLista(
        this.elementos.$listaHorarios
      );

      this.elementos.$modalErro.on("shown.bs.modal", function () {
        self.elementos.$botaoTentarNovamente.trigger("focus");
      });

      this.elementos.$botaoTentarNovamente.on("click", function () {
        self.buscarDadosAgendamento();
      });

      this.elementos.$botaoRealizarLogin.on("click", function () {
        window.location.href =
          self.configuracao.urlLogin +
          "?redirecionar=" +
          encodeURIComponent(window.location.href);
      });
    },

    cancelarAgendamento: function () {
      var url = this.configuracao.urlInfoServico;
      if (this.estado.idServico) {
        url += "?id=" + encodeURIComponent(this.estado.idServico);
      }
      window.location.href = url;
    },

    buscarDadosAgendamento: function () {
      var self = this;

      Utilitarios.esconderModal(this.elementos.$modalErro);
      this.elementos.$form
        .removeClass("estadoErro")
        .addClass("estadoCarregando");

      Utilitarios.alternarEsqueletoAcessivel(
        this.elementos.$camposDinamicos,
        true
      );

      $.ajax({
        url: this.configuracao.urlObterDadosAgendamento,
        method: "GET",
        dataType: "json",
        data: { id: this.estado.idServico }
      })
        .done(function (resposta) {
          if (!resposta || !resposta.sucesso || !resposta.dados) {
            self.tratarFalhaCarregamento();
            return;
          }

          Utilitarios.preencherCampos(
            self.elementos.$camposDinamicos,
            resposta.dados
          );

          Utilitarios.alternarEsqueletoAcessivel(
            self.elementos.$camposDinamicos,
            false
          );

          self.renderizarLocalizacoes(
            resposta.dados.localizacoes || []
          );

          self.buscarDiasIndisponiveis(self.estado.dataExibida);
        })
        .fail(function () {
          self.tratarFalhaCarregamento();
        });
    },

    tratarFalhaCarregamento: function () {
      this.elementos.$form
        .removeClass("estadoCarregando")
        .addClass("estadoErro");

      Utilitarios.alternarEsqueletoAcessivel(
        this.elementos.$camposDinamicos,
        true
      );

      this.exibirModalErro();
    },

    renderizarLocalizacoes: function (localizacoes) {
      var self = this;
      this.elementos.$listaLocalizacoes.empty();

      localizacoes.forEach(function (local) {
        var $item = $(
          '<li role="presentation"><button type="button" class="dropdownCustomizadoItem" role="option"></button></li>'
        );

        $item
          .find("button")
          .attr("data-valor", local.id)
          .attr("data-texto", local.nome)
          .text(local.nome)
          .append(
            '<span class="material-symbols-outlined" aria-hidden="true">manage_search</span>'
          );

        self.elementos.$listaLocalizacoes.append($item);
      });
    },

    selecionarLocalizacao: function (id, nome) {
      this.estado.localizacaoSelecionada = id;
      this.elementos.$inputLocalizacao.val(id);
      this.elementos.$textoLocalizacao.text(nome);
      this.fecharDropdown(this.elementos.$dropdownLocalizacao);
      this.removerErroCampo(this.elementos.$botaoLocalizacao);
      this.elementos.$botaoLocalizacao.trigger("focus");
    },

    navegarMes: function (deltaMeses) {
      this.estado.dataExibida.setMonth(
        this.estado.dataExibida.getMonth() + deltaMeses
      );

      this.estado.diaSelecionado = null;
      this.elementos.$inputDia.val("");
      this.resetarHorario();
      this.buscarDiasIndisponiveis(this.estado.dataExibida);
    },

    buscarDiasIndisponiveis: function (data) {
      var self = this;

      $.ajax({
        url: this.configuracao.urlObterDiasIndisponiveis,
        method: "GET",
        dataType: "json",
        data: {
          id: this.estado.idServico,
          mes: data.getMonth() + 1,
          ano: data.getFullYear()
        }
      })
        .done(function (resposta) {
          if (!resposta || !resposta.sucesso) {
            self.tratarFalhaCarregamento();
            return;
          }

          self.estado.diasIndisponiveis =
            resposta.dados.diasIndisponiveis || [];

          self.elementos.$form.removeClass(
            "estadoCarregando estadoErro"
          );

          self.renderizarCalendario(data);
        })
        .fail(function () {
          self.tratarFalhaCarregamento();
        });
    },

    renderizarCalendario: function (data) {
      var ano = data.getFullYear();
      var mes = data.getMonth();
      var primeiroDiaSemana = new Date(ano, mes, 1).getDay();
      var totalDias = new Date(ano, mes + 1, 0).getDate();

      this.elementos.$tituloMesAno.text(
        NOMES_MES[mes] + " " + ano
      );

      this.elementos.$grade.empty();

      for (var i = 0; i < primeiroDiaSemana; i++) {
        this.elementos.$grade.append(
          '<button type="button" class="diaCalendario diaVazio" disabled aria-hidden="true" tabindex="-1"></button>'
        );
      }

      for (var dia = 1; dia <= totalDias; dia++) {
        var dataChave = this.formatarDataChave(ano, mes, dia);
        var indisponivel =
          this.estado.diasIndisponiveis.indexOf(dataChave) !== -1;

        var selecionado =
          dataChave === this.estado.diaSelecionado;

        var nomeDiaSemana =
          NOMES_DIA_SEMANA[
          new Date(ano, mes, dia).getDay()
          ];

        var rotulo =
          nomeDiaSemana +
          ", " +
          dia +
          " de " +
          NOMES_MES_COMPLETO[mes];

        if (indisponivel) {
          rotulo += " — indisponível";
        }

        var $botaoDia = $(
          '<button type="button" class="diaCalendario"></button>'
        )
          .text(dia)
          .attr("data-data", dataChave)
          .attr("aria-label", rotulo)
          .attr(
            "aria-pressed",
            selecionado ? "true" : "false"
          );

        if (indisponivel) {
          $botaoDia
            .addClass("diaIndisponivel")
            .prop("disabled", true);

          $botaoDia.attr("aria-disabled", "true");
        }

        if (selecionado) {
          $botaoDia.addClass("diaSelecionado");
        }

        this.elementos.$grade.append($botaoDia);
      }
    },

    formatarDataChave: function (ano, mesIndiceZero, dia) {
      var mesFormatado = String(mesIndiceZero + 1).padStart(2, "0");
      var diaFormatado = String(dia).padStart(2, "0");

      return ano + "-" + mesFormatado + "-" + diaFormatado;
    },

    selecionarDia: function (dataChave) {
      this.estado.diaSelecionado = dataChave;
      this.elementos.$inputDia.val(dataChave);
      this.removerErroCampo(this.elementos.$calendario);

      this.elementos.$grade
        .find(".diaCalendario")
        .each(function () {
          var $dia = $(this);
          var ehEsseDia =
            $dia.data("data") === dataChave;

          $dia.toggleClass("diaSelecionado", ehEsseDia);

          $dia.attr(
            "aria-pressed",
            ehEsseDia ? "true" : "false"
          );
        });

      this.resetarHorario();
      this.buscarHorariosDisponiveis(dataChave);
    },

    resetarHorario: function () {
      this.estado.horarioSelecionado = null;
      this.elementos.$inputHorario.val("");
      this.elementos.$textoHorario.text("Selecione horário");
      this.elementos.$listaHorarios.empty();
      this.elementos.$botaoHorario.prop("disabled", true);
      this.fecharDropdown(this.elementos.$dropdownHorario);
    },

    buscarHorariosDisponiveis: function (dataChave) {
      var self = this;

      $.ajax({
        url: this.configuracao.urlObterHorariosDisponiveis,
        method: "GET",
        dataType: "json",
        data: {
          id: this.estado.idServico,
          data: dataChave
        }
      })
        .done(function (resposta) {
          if (!resposta || !resposta.sucesso) {
            self.tratarFalhaCarregamento();
            return;
          }

          self.renderizarHorarios(
            resposta.dados.horarios || []
          );

          self.elementos.$botaoHorario.prop(
            "disabled",
            false
          );
        })
        .fail(function () {
          self.tratarFalhaCarregamento();
        });
    },

    renderizarHorarios: function (horarios) {
      var self = this;
      this.elementos.$listaHorarios.empty();

      horarios.forEach(function (horario) {
        var $item = $(
          '<li role="presentation"><button type="button" class="dropdownCustomizadoItem" role="option"></button></li>'
        );

        $item
          .find("button")
          .attr("data-valor", horario.valor)
          .attr("data-texto", horario.texto)
          .text(horario.texto);

        self.elementos.$listaHorarios.append($item);
      });
    },

    selecionarHorario: function (valor, texto) {
      this.estado.horarioSelecionado = valor;
      this.elementos.$inputHorario.val(valor);
      this.elementos.$textoHorario.text(texto);
      this.fecharDropdown(this.elementos.$dropdownHorario);
      this.removerErroCampo(this.elementos.$botaoHorario);
      this.elementos.$botaoHorario.trigger("focus");
    },

    alternarDropdown: function ($dropdown, $inputOculto) {
      var $lista =
        $dropdown.find(".dropdownCustomizadoLista");

      var estaAberta = !$lista.attr("hidden");

      this.fecharTodosDropdowns();

      if (!estaAberta) {
        this.abrirDropdown($dropdown, $inputOculto);
      }
    },

    abrirDropdown: function ($dropdown, $inputOculto) {
      $dropdown
        .find(".dropdownCustomizadoLista")
        .removeAttr("hidden");

      $dropdown
        .find(".dropdownCustomizadoBotao")
        .attr("aria-expanded", "true");

      var $itens =
        $dropdown.find(".dropdownCustomizadoItem");

      if (!$itens.length) {
        return;
      }

      var valorAtual =
        $inputOculto ? $inputOculto.val() : null;

      var $itemSelecionado = $itens.filter(function () {
        return $(this).data("valor") === valorAtual;
      });

      (
        $itemSelecionado.length
          ? $itemSelecionado
          : $itens.first()
      ).trigger("focus");
    },

    fecharDropdown: function ($dropdown) {
      $dropdown
        .find(".dropdownCustomizadoLista")
        .attr("hidden", "hidden");

      $dropdown
        .find(".dropdownCustomizadoBotao")
        .attr("aria-expanded", "false");
    },

    fecharTodosDropdowns: function () {
      this.fecharDropdown(
        this.elementos.$dropdownLocalizacao
      );

      this.fecharDropdown(
        this.elementos.$dropdownHorario
      );
    },

    registrarNavegacaoTecladoLista: function ($lista) {
      $lista.on(
        "keydown",
        ".dropdownCustomizadoItem",
        function (evento) {
          var $itens =
            $lista.find(".dropdownCustomizadoItem");

          var indiceAtual = $itens.index(this);
          var proximoIndice = null;

          switch (evento.key) {
            case "ArrowDown":
              proximoIndice =
                (indiceAtual + 1) % $itens.length;
              break;

            case "ArrowUp":
              proximoIndice =
                (indiceAtual - 1 + $itens.length) %
                $itens.length;
              break;

            case "Home":
              proximoIndice = 0;
              break;

            case "End":
              proximoIndice = $itens.length - 1;
              break;

            default:
              return;
          }

          evento.preventDefault();
          $itens.eq(proximoIndice).trigger("focus");
        }
      );
    },

    marcarCampoComErro: function ($elemento) {
      $elemento.addClass("campoComErro");
    },

    removerErroCampo: function ($elemento) {
      $elemento.removeClass("campoComErro");
    },

    exibirAlertaValidacao: function (mensagem) {
      this.elementos.$alerta
        .text(
          mensagem ||
          "Você precisa preencher todos os dados!"
        )
        .removeAttr("hidden");
    },

    esconderAlertaValidacao: function () {
      this.elementos.$alerta.attr("hidden", "hidden");
    },

    tentarConfirmarAgendamento: function () {
      var self = this;
      var camposValidos = true;
      var $primeiroInvalido = null;

      if (!this.estado.localizacaoSelecionada) {
        this.marcarCampoComErro(
          this.elementos.$botaoLocalizacao
        );

        $primeiroInvalido =
          $primeiroInvalido ||
          this.elementos.$botaoLocalizacao;

        camposValidos = false;
      }

      if (!this.estado.diaSelecionado) {
        this.marcarCampoComErro(
          this.elementos.$calendario
        );

        $primeiroInvalido =
          $primeiroInvalido ||
          this.elementos.$calendario;

        camposValidos = false;
      }

      if (!this.estado.horarioSelecionado) {
        this.marcarCampoComErro(
          this.elementos.$botaoHorario
        );

        $primeiroInvalido =
          $primeiroInvalido ||
          this.elementos.$botaoHorario;

        camposValidos = false;
      }

      if (!camposValidos) {
        this.exibirAlertaValidacao();

        if ($primeiroInvalido) {
          $primeiroInvalido.trigger("focus");
        }

        return;
      }

      this.esconderAlertaValidacao();
      this.verificarLoginEEnviar();
    },

    verificarLoginEEnviar: function () {
      var self = this;

      $.ajax({
        url: this.configuracao.urlVerificarLogin,
        method: "GET",
        dataType: "json"
      })
        .done(function (resposta) {
          if (resposta && resposta.logado) {
            self.enviarAgendamento();
          } else {
            self.exibirModalNaoLogado();
          }
        })
        .fail(function () {
          self.exibirModalNaoLogado();
        });
    },

    enviarAgendamento: function () {
      var self = this;

      this.elementos.$botaoConfirmar.prop(
        "disabled",
        true
      );

      $.ajax({
        url: this.configuracao.urlCriarAgendamento,
        method: "POST",
        dataType: "json",
        data: this.elementos.$form.serialize()
      })
        .done(function (resposta) {
          if (resposta && resposta.sucesso) {
            self.irParaInfoServicoComSucesso();
            return;
          }

          self.exibirAlertaValidacao(
            "Não foi possível concluir o agendamento. Tente novamente."
          );
        })
        .fail(function () {
          self.exibirAlertaValidacao(
            "Não foi possível concluir o agendamento. Tente novamente."
          );
        })
        .always(function () {
          self.elementos.$botaoConfirmar.prop(
            "disabled",
            false
          );
        });
    },

    irParaInfoServicoComSucesso: function () {
      var url =
        this.configuracao.urlInfoServico +
        "?agendado=1";

      if (this.estado.idServico) {
        url +=
          "&id=" +
          encodeURIComponent(this.estado.idServico);
      }

      window.location.href = url;
    },

    exibirModalErro: function () {
      Utilitarios.exibirModal(
        this.elementos.$modalErro,
        {
          backdrop: "static",
          keyboard: false
        }
      );
    },

    exibirModalNaoLogado: function () {
      Utilitarios.exibirModal(
        this.elementos.$modalNaoLogado
      );
    }
  };

  $(function () {
    moduloAgendamentoCli.iniciar();
  });

})(jQuery, window.ElmoUtilitarios);
