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
    $("textarea#descricao").on("keyup change reset", (e) => validar_texto(e.target, 4_000, /[^\w\sãõáéíóúÁÉÍÓÚçâôêÂÔ\-\.@&%$!\(\):,"\?]/g));
    
    $("input#preco").on("keyup change reset", (e) => validar_numero(e.target, 1.00, 1_000_000.00, 2));
    $("input#estoque").on("keyup change reset", (e) => validar_numero(e.target, 0, 500, 0));
    $("input#peso").on("keyup change reset", (e) => validar_numero(e.target, 1.0, 20_000.0, 1));

    $("a.remover").click((e) => confirm("Tem certeza que quer fazer isso?") ? null : e.preventDefault());

    $(".msg").slideDown(200);
    setTimeout(() => $(".msg").slideUp(200), 2500);

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

    function validar_texto(input, tamanho_max, chars=/[^a-zA-Z ãõáéíóúÁÉÍÓÚçâôêÂÔ]/g) {
        let text = $(input).val();
        let small = $(input).next("small");
        let valido = true;
        let invalidos = text.match(chars);
        
        if (/^ +$/.test(text)) {
            valido = false;
            small.text(`Somente espaços não é uma string válida!`);
        }
        if (invalidos) {
            valido = false;
            small.text(`Esse campo possui caracteres inválido! ${invalidos.join(" ")}`);
        }
        if (text.length > tamanho_max) {
            valido = false;
            small.text(`Os dados informados são muito grandes! ${text.length} > ${tamanho_max}`);
        } 

        small.toggle(!valido);
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
        regex_casas = new RegExp(`\\.\\d{${casas+1},}$`);
        
        if (!valor) return;

        if (isNaN(valor)) {
            valido = false;
            small.text("Número Inválido");
        }
        if (regex_casas.test(valor)) {
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
});