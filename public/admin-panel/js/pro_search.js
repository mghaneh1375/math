$(document).ready(function () {
    $("#toggleProSearchBtn").on("click", function () {
        if ($(this).attr("data-status") == "close") {
            $(this)
                .removeClass("glyphicon-chevron-down")
                .addClass("glyphicon-chevron-up")
                .attr("data-status", "open");
            $("#pro_search").removeClass("hidden");
        } else {
            $(this)
                .addClass("glyphicon-chevron-down")
                .removeClass("glyphicon-chevron-up")
                .attr("data-status", "close");
            $("#pro_search").addClass("hidden");
        }
    });
});
