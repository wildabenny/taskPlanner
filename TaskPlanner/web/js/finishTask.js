$(function () {

    var finishButton = $("#finishButton");
    var finishDiv = $("#finishDiv");

    finishButton.on("click", function (event) {

        event.preventDefault();

        $.ajax({
            url: Routing.generate('app_task_finishtask'),
            method: "POST",
            data: "id=" + finishButton.attr("data-id"),
            success: function (response) {
                if (response.code == 100 && response.success) {
                    finishDiv.empty();
                    finishDiv.append("<p><strong>Task Is Finished</strong></p>");
                } else {
                    console.log("AJAX nie dziala");
                }
            },
            error: function () {
                console.log("AJAX Error");
            }
        })

    });

});
