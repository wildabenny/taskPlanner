$(function () {
    var button = $("#button1");

    button.on("click", function () {
        console.log("działa");
        $(this).closest('p').html('<strong>Task Is Finished</strong>');

    });
});
