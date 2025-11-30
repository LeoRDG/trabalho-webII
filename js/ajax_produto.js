$(window).on("load", () => {
    $(".produto").on("click", function (e) { 
        if ($(e.target).is('a') ) return;
        carregar_produto(this);
    });
});


/**
 * Ao clicar em um produto, 
 * carrega o mesmo endpoint do botao para editar o produto
 * mas sem o form e com os inputs desabilitados
 * @param {*} produto A div do produto.
 */
function carregar_produto(produto) {
    let url = $(produto).children(".detalhes").attr("href");
    let div = $(produto).next();
    div.slideToggle(300, "swing");

    url = (url.replace("editar_produto", "../include/produto_template"))
    if (div.children().length == 0) div.load(url+"&modo=view", () => {
        // Desabilita todos os inputs, quando terminar de carregar
        div.find("input, textarea").each(function () { 
            $(this).prop("disabled", true);
        });
    });

}
