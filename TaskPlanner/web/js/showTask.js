$(function () {

    var buttons = $(".btn");

    buttons.on("click", function (event) {
        event.preventDefault();
        var liElement = $(this).closest("li");
        console.log(liElement.attr("data-id"));
    });

});
