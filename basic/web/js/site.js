//  listener for Remove btns
//  changes form's action so there's no need for N(=10) number of modals
$(".table-actions-remove-btn", ".table-actions").click(function (e) {
    let action = $(this).attr("data-action");
    $("form", "#RemoveModal").attr("action", action);
});