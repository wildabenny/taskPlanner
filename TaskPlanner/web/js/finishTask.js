$(function () {
    var button = $("#button1");

    button.on("click", function () {
        var lista = $(this).closest("li");
        console.log("działa");
        $(this).closest('p').html('<strong>Task Is Finished</strong>');
        console.log(lista.data());

    });
});
