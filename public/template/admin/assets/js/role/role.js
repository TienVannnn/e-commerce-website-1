// $(".checkbox-parent").click(function() {
//   $(this).parents('.module-parent').find('.checkbox-childrent').prop('checked', $(this).prop('checked'));
// });

// cách 2
$(".checkbox-parent").click((event) => {
    $(event.target)
        .parents(".module-parent")
        .find(".checkbox-childrent")
        .prop("checked", $(event.target).prop("checked"));
});

$(".check-all").click(function () {
    $(this)
        .parents(".card-body")
        .find(".checkbox-childrent")
        .prop("checked", $(this).prop("checked"));
});
