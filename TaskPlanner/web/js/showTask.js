$(function () {


    var taskDiv = $("#taskDiv");
    var buttonHide = $("<button type='button' class='btn btn-warning'>Hide Task</button>");
    var buttonShow = $("<button type='button' class='btn btn-info'>Show Task</button>");
    var listElement = $(".list-group-item");
    listElement.append(buttonShow);
    var buttons = $(".btn");

    listElement.on("click", buttonShow, function (event) {
        event.stopImmediatePropagation();
        event.preventDefault();
        var liItem = $(this).closest("li");
        //button.toggleClass("btn btn-warning");
        //var liElement = button.parent("li");
        console.log(liItem);
        console.log(liItem.attr("data-id"));
        $.ajax({
            url: Routing.generate('app_task_searchtask'),
            method: "POST",
            data: "id=" + liItem.attr("data-id"),
            dataType: 'html',
            success: function (result, request) {
                var parsedData = JSON.parse(result);
                console.log(parsedData);
                if (parsedData.status === 'success') {
                    console.log('udalo sie');
                    //liElement.append(taskDiv);
                    //taskDiv.empty();
                    taskDiv.html(parsedData.data);
                    taskDiv.prepend(buttonHide);
                    //liItem.slideToggle(500);
                    buttonHide.on("click", function (event) {
                        //event.stopImmediatePropagation();
                        taskDiv.slideToggle(500);
                        //liItem.slideToggle(500);
                    });
                } else {
                    console.log("Cos nie tak:(");
                }
            }
        })
    });
});
