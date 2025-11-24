$(window).on("load", () => {
    $(".produto").on("click", function () { carregar_produto(this) });
});

function carregar_produto(produto) {
    let url = $(produto).children(".detalhes").attr("href");
    let div = $(produto).next();
    div.slideToggle(300, "swing");

    if (div.children().length == 0) div.load(url+"&apenas_detalhes");

    div.find("input textarea").each(function () { 
        $(this).prop("disabled", true);
    });
}
