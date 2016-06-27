$(function () {

    var buttons = $(".btn");

    buttons.on("click", function (event) {
        event.preventDefault();
        console.log($(this).parent($("#list-groupItem")).val());
    });

});
