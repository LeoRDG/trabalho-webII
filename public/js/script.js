$(window).on("load", () => {
    let btn_edit = $("#edit");
    let btn_submit = $("#enviar");
    let inputs = $("input, textarea");

    btn_edit.click(toggle_inputs);

    btn_submit.click((e) => submit(e));
    $("form").on("submit", (e) => submit(e));

    $("input#nome").on("keyup change reset", (e) => validar_texto(e.target, 100));
    $("input#marca").on("keyup change reset", (e) => validar_texto(e.target, 40));
    $("input#categoria").on("keyup change reset", (e) => validar_texto(e.target, 40));
    $("textarea#descricao").on("keyup change reset", (e) => validar_texto(e.target, 4_000));
    
    $("input#preco").on("keyup change reset", (e) => validar_numero(e.target, 1, 1_000_000, 2));
    $("input#estoque").on("keyup change reset", (e) => validar_numero(e.target, 0, 500, 0));
    $("input#peso").on("keyup change reset", (e) => validar_numero(e.target, 1, 20_000, 1));

    $("a.remover").click((e) => confirm("Tem certeza que quer fazer isso?") ? null : e.preventDefault());

    function toggle_inputs() {
        inputs.not(".static").each(function (){
            $(this).prop("disabled", !$(this).prop("disabled")) ;
        });
    }

    function submit(evento) {
        validar_required()
        if ( $("input.erro, textarea.erro").length > 0 ) {
            evento.preventDefault();
        }

    }

    function validar_texto(input, tamanho_max) {
        let tamanho = $(input).val().length;
        let valido = tamanho <= tamanho_max;
        let small = $(input).next("small");
        small.toggle(!valido);
        if (!valido) small.text(`Os dados informados são muito grandes! ${tamanho} > ${tamanho_max}`);
        $(input).toggleClass("erro", !valido);
    }

    function validar_required() {
        $("[required]").each(function () {
            
            // Se o input for do tipo radio...
            if ($(this).prop("type") === "radio") {
                let small = $(this).nextAll("small").first();
                let name = $(this).prop("name");
                let valido = $(`input[name="${name}"]:checked`).length > 0;    // Procura por todos os checked radios com o mesmo nome se achar algum, é valido
                small.toggle(!valido)
                if (!valido) small.text("O campo nao pode ser nulo!");
                $(`fieldset.${name}`).toggleClass("erro", !valido);
                return;
            }
            
            let small = $(this).next("small");
            let valido = ($(this).val()) ? true : false;
            small.toggle(!valido);
            if (!valido) small.text("O campo nao pode ser nulo!");
            $(this).toggleClass("erro", !valido);
        });
    }

    function validar_numero(input, min, max, casas) {
        let valor = $(input).val();
        let small = $(input).next("small");
        let valido = true;
        
        if (isNaN(valor)) {
            valido = false;
            small.text("Número Inválido");
        }
        else {
            valor = (casas > 0) ? parseFloat(valor).toFixed(casas) : parseInt(valor);
            valido = (valor >= min && valor <= max);
            small.text(`O número deve ser entre ${Intl.NumberFormat("pt-BR").format(min)} e ${Intl.NumberFormat("pt-BR").format(max)}`);
        }
        
        small.toggle(!valido);
        $(input).toggleClass("erro", !valido);
    }
});