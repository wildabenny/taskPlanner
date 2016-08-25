$(function () {

    var finishButton = $("#finishButton")

    finishButton.on("click", function (event) {

        event.preventDefault();

        $.ajax({
            url: Routing.generate('app_task_finishtask'),
            method: "POST",
            data: "id=" + finishButton.attr("data-id"),
            success: function (response) {
                if (response.code == 100 && response.success) {
                    console.log("AJAX dziala")
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
