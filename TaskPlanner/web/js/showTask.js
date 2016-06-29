$(function () {


    var taskDiv = $("#taskDiv");
    var buttonShow = $("<button type='button' class='btn btn-info'>Show Task</button>");
    var listElement = $(".list-group-item");
    listElement.append(buttonShow);

    listElement.on("click", buttonShow, function (event) {
        event.stopImmediatePropagation();
        event.preventDefault();
        var liItem = $(this).closest("li");
        $.ajax({
            url: Routing.generate('app_task_searchtask'),
            method: "POST",
            data: "id=" + liItem.attr("data-id"),
            dataType: 'html',
            success: function (result, request) {
                var parsedData = JSON.parse(result);
                console.log(parsedData);
                if (parsedData.status === 'success') {
                    taskDiv.empty();
                    taskDiv.html(parsedData.data);
                } else {
                    console.log("Cos nie tak:(");
                }
            }
        })
    });
});
