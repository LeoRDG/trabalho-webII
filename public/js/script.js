$(window).on("load", () => {
    let btn_edit = $("#edit");
    let inputs = $("input, textarea");

    btn_edit.click(toggle_inputs);
    inputs.on("keyup change reset", (e) => validar_input(e.target));

    function toggle_inputs() {
        inputs.each(function (){
            $(this).prop("disabled", !$(this).prop("disabled")) ;
        });
    }
    
    function validar_input(input){
        console.log(input);
    }

});