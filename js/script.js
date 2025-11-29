$(window).on("load", () => {
    // Validacao dos inputs
    $("#nome").on("keyup change reset", (e) => validar_texto(e.target, 60, /[^\w ãõáéíóúÁÉÍÓÚçâôêÂÔ]/g));
    $("#marca").on("keyup change reset", (e) => validar_texto(e.target, 20));
    $("#categoria").on("keyup change reset", (e) => validar_texto(e.target, 30));
    $("#descricao").on("keyup change reset", (e) => validar_texto(e.target, 4_000, /[^\w\sãõáéíóúÁÉÍÓÚçâôêÂÔ\-\.@&%$!\(\):,"\?]/g));
    $(".preco, #preco").on("keyup change reset", (e) => validar_numero(e.target, 1.00, 100_000.00, 2));
    $("#estoque").on("keyup change reset", (e) => validar_numero(e.target, 0, 5000, 0));
    $("#peso").on("keyup change reset", (e) => validar_numero(e.target, 0.1, 50, 1));
    $('input[type="radio"]').on("change", (e) => validar_required_radio(e.target));

    // Validacao ao dar submit em um form
    $("#enviar").click((e) => submit(e));

    // Confirmacao ao clicar em um link que exige confirmacao
    $(".remover").click((e) => confirm("Tem certeza que quer fazer isso?") ? null : e.preventDefault());

    // Mostrando e Escondendo mensagem de erro/sucesso
    $(".msg").slideDown(200);
    setTimeout(() => $(".msg").slideUp(200), 5000);
});


/**
 * Intercepta o submit do form, verifica se os requireds foram preenchidos.
 * Se qualquer input/textarea tiver a classe erro, não envia o form.
 * A validaçao dos tipos é feita em tempo real, entao nao é preciso validar aqui.
 * @param {object} evento O evento (click no botao submit).
 */
function submit(evento) {
    console.log(typeof(evento))
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
    let text = $(input).val();
    let small = $(input).next("small");
    let valido = true;
    let invalidos = text.match(chars);

    // Verifica se foram digitados apenas espaços em branco
    if (/^ +$/.test(text)) {
        valido = false;
        small.text(`Somente espaços não é uma string válida!`);
    }
    // Verifica se contém caracteres nao permitidos
    else if (invalidos) {
        valido = false;
        small.text(`Esse campo possui caracteres inválido! ${invalidos.join(" ")}`);
    }
    // Verifica se contém mais characters do que o permitido
    else if (text.length > tamanho_max) {
        valido = false;
        small.text(`Os dados informados são muito grandes! ${text.length} > ${tamanho_max}`);
    }

    small.toggle(!valido);
    $(input).toggleClass("erro", !valido);
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
    let small = $(input).next("small");
    let valido = true;
    let regex_casas = new RegExp(`\\.\\d{${casas + 1},}$`);

    if (!valor) return;

    // Verifica se é um numero
    else if (isNaN(valor)) {
        valido = false;
        small.text("Número Inválido");
    }
    // Usa regex para verificar quantas casas decimais o numero possui
    else if (regex_casas.test(valor)) {
        valido = false;
        if (casas > 0) small.text(`Esse campo numérico só suporta ${casas} casas decimais!`)
        else small.text("Esse campo não suporta casas decimais!")
    }
    else {
        valor = (casas > 0) ? parseFloat(valor).toFixed(casas) : parseInt(valor);
        valido = (valor >= min && valor <= max);
        small.text(`O número deve ser entre ${Intl.NumberFormat("pt-BR").format(min)} e ${Intl.NumberFormat("pt-BR").format(max)}`);
    }

    small.toggle(!valido);
    $(input).toggleClass("erro", !valido);
}


/**
 * Verifica se os inputs required foram preenchidos.
 */
function validar_required() {
    $("[required]").each(function () {

        // Se o input for do tipo radio...
        if ($(this).prop("type") === "radio") {
            validar_required_radio(this);
            return;
        }

        let small = $(this).next("small");
        let valido = ($(this).val()) ? true : false;
        if (!valido) small.text("O campo nao pode ser nulo!");
        small.toggle(!valido);
        $(this).toggleClass("erro", !valido);
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
    let small = $("small."+name);
    let valido = $(`input[name="${name}"]:checked`).length === 1;
    small.toggle(!valido)
    if (!valido) small.text("Escolha uma opcao!");
    $(`fieldset.${name}`).toggleClass("erro", !valido);
}
