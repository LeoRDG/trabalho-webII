$(window).on("load", () => {
    const EVENTS = "input"
    // Validacao dos inputs
    $("#nome").on(EVENTS, (e) => validar_texto(e.target, 60, /[^\w ãõáéíóúÁÉÍÓÚçâôêÂÔ]/g));
    $("#marca").on(EVENTS, (e) => validar_texto(e.target, 20));
    $("#categoria").on(EVENTS, (e) => validar_texto(e.target, 30));
    $("#descricao").on(EVENTS, (e) => validar_texto(e.target, 4_000, /[^\w\sãõáéíóúÁÉÍÓÚçâôêÂÔ\-\.@&%$!\(\):,"\?]/g));
    $(".preco, #preco").on(EVENTS, (e) => validar_numero(e.target, 1.00, 100_000.00, 2));
    $("#estoque").on(EVENTS, (e) => validar_numero(e.target, 0, 5000, 0));
    $("#peso").on(EVENTS, (e) => validar_numero(e.target, 0.1, 50, 1));
    $('#vencimento').on(EVENTS, (e) => validar_vencimento(e.target)); // Data valida se for entre daqui 30 dias e 3 anos
    $('input[type="radio"]').on("change", (e) => validar_required_radio(e.target));

    $("#vencimento").mask("00/00/0000");

    // Validacao ao dar submit em um form
    $("#enviar").on("click", (e) => submit(e));

    // Confirmacao ao clicar em um link que exige confirmacao
    $(".remover").on("click", (e) => confirm("Tem certeza que quer fazer isso?") ? null : e.preventDefault());

    // Limpa os erros quando clicar em reset
    $("form").on("reset", () => {
        $("input, textarea, fieldset").removeClass("erro");
        $("small.erro").hide();
    });

    // Mostrando e Escondendo mensagem de erro/sucesso
    $(".msg").slideDown(200);
    setTimeout(() => $(".msg").slideUp(200), 5000);
});


/**
 * Formata uma data para pt br
 * @param {Date} data Um objeto Date 
 * @returns {string} Uma string formatada no formato brasileiro
 */
function formatar_date(data) {
    let dia = String(data.getDate()).padStart(2, "0");
    let mes = String(data.getMonth() + 1).padStart(2, "0");
    let ano = String(data.getFullYear()).padStart(2, "0");
    return `${dia}/${mes}/${ano}`;
}


/**
 * Executa um array de validações e aplica o resultado ao input
 * @param {object} input O elemento input
 * @param {Array} validacoes Array de objetos {valido: boolean, mensagem: string}
 */
function validar(input, validacoes) {
    let small = $(input).next("small");
    let valido = true;

    for (let v of validacoes) {
        if (v.valido) continue;
        valido = false;
        small.text(v.mensagem);
        break;
    }

    small.toggle(!valido);
    $(input).toggleClass("erro", !valido);
}


/**
 * Intercepta o submit do form, verifica se os requireds foram preenchidos.
 * Se qualquer input/textarea tiver a classe erro, não envia o form.
 * A validaçao dos tipos é feita em tempo real, entao nao é preciso validar aqui.
 * @param {object} evento O evento (click no botao submit).
 */
function submit(evento) {
    validar_required()
    let erros = $("input.erro, textarea.erro");
    if (erros.length > 0) {
        // scrolla até o primeiro erro
        $('html').animate({
            scrollTop: erros.first().offset().top - 100
        }, 500);
        evento.preventDefault();
    }
}


/**
 * Valida os inputs de texto
 * @param {object} input input ou textarea.
 * @param {number} tamanho_max O tamanho máximo de caracteres permitidos. O mesmo usado em VARCHAR no banco.
 * @param {object} chars Um regex pattern com o "inverso" dos caracteres permitidos. Se o regex retornar qualquer match, é uma string inválida.
 */
function validar_texto(input, tamanho_max, chars = /[^a-zA-Z ãõáéíóúÁÉÍÓÚçâôêÂÔ]/g) {
    let valor = $(input).val();

    let validacoes = [
        { valido: !/^ +$/.test(valor), 
          mensagem: "Somente espaços não é uma string válida!" },

        { valido: !valor.match(chars), 
          mensagem: `Esse campo possui caracteres inválido! ${valor.match(chars)?.join(" ") || ""}` },
          
        { valido: valor.length <= tamanho_max, 
          mensagem: `Os dados informados são muito grandes! ${valor.length} > ${tamanho_max}` }]

    validar(input, validacoes);
}


/**
 * Valida os inputs que devem ser representados como numeros, nao necessariamente apenas input[type="number"]
 * @param {object} input O input
 * @param {number} min O número minimo permitido.
 * @param {number} max O numero maximo permitido.
 * @param {number} casas O numero maximo de casas permitidas. 0 = int / 0+ = float
 */
function validar_numero(input, min, max, casas) {
    let valor = $(input).val();
    let regex_casas = new RegExp(`\\.\\d{${casas + 1},}$`);
    let valor_num = (casas > 0) ? parseFloat(valor) : parseInt(valor);
    let formato_br = (num) => Intl.NumberFormat("pt-BR").format(num);

    let validacoes = [
        { valido: !isNaN(valor), 
          mensagem: "Número Inválido" },

        { valido: !regex_casas.test(valor), 
          mensagem: casas > 0 ? `Esse campo numérico só suporta ${casas} casas decimais!` : "Esse campo não suporta casas decimais!" },

        { valido: valor.length == 0 || (valor_num >= min && valor_num <= max), 
          mensagem: `O número deve ser entre ${formato_br(min)} e ${formato_br(max)}` }
    ]

    validar(input, validacoes);
}


/**
 * Valida a data de vencimento do produto
 * @param {object} input O input
 */
function validar_vencimento(input) {
    let valor = $(input).val();
    let bp = valor.length == 0; // Bypass para quando o campo estiver vazio, deve ser valido pois o banco aceito null, sem isso vai dar sempre invalido

    let [dia, mes, ano] = valor.split("/").map(Number);
    let agora = new Date();
    let data = new Date(ano, mes - 1, dia);
    let data_min = new Date(agora.getTime() + 30 * 86400000);
    let data_max = new Date(agora.getTime() + 3 * 365 * 86400000);

    let validacoes = [
        { valido: bp || dia >= 1 && dia <= 31, mensagem: `${dia} não é um dia válido` },
        { valido: bp || mes >= 1 && mes <= 12, mensagem: `${mes} não é um mês válido` },
        { valido: bp || !!ano,                 mensagem: "Informe um ano!" },
        { valido: bp || data.getDate() == dia, mensagem: "Dia inválido para esse mês" },
        { valido: bp || data > agora,          mensagem: "O produto deve não estar vencido" },
        { valido: bp || data > data_min,       mensagem: `O vencimento mínimo é de 30 dias. Informe uma data após: ${formatar_date(data_min)}` },
        { valido: bp || data < data_max,       mensagem: `O vencimento máximo é de 3 anos. Informe uma data até: ${formatar_date(data_max)}` },
    ];

    validar(input, validacoes);
}


/**
 * Verifica se os inputs required foram preenchidos.
 */
function validar_required() {
    $("[required]").each(function () {
        if ($(this).prop("type") === "radio") {
            validar_required_radio(this);
            return;
        }
        validar(this, [{ valido: !!$(this).val(), mensagem: "O campo nao pode ser nulo!" }]);
    });
}


/**
 * Verifica se esse radio esta selecionado
 * @param {object} input O input
 */
function validar_required_radio(input) {
    // Procura todos os inputs com o mesmo nome
    // e verifica se um deles esta selecionado
    let name = $(input).prop("name");
    let valido = $(`input[name="${name}"]:checked`).length === 1;
    let small = $(`small.${name}`);
    
    small.toggle(!valido);
    if (!valido) small.text("Escolha uma opcao!");
    $(`fieldset.${name}`).toggleClass("erro", !valido);
}
