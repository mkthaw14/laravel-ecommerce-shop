$(document).ready(function() {

    $(".delete-btn").on("click", function(e) {
        e.preventDefault();
        console.log("hello");
        setTargetForm(this);
        alertUser();
    })

    $("#confirm-delete-btn").on("click", function() {
        submitTargetForm(this);
    })
});

function alertUser()
{
    //console.log($("#confirm-delete-btn").data("target"));
    $("#delete-modal").modal("show");
}

function setTargetForm(element)
{
    let el = $(element).closest("form");
    //console.log(el);

    console.log($(el).attr("id"));
    //console.log($("#confirm-delete-btn").data("target"));
    //$("#confirm-delete-btn").attr("data-target", $(el).attr("id"));
    $("#confirm-delete-btn").data("target", $(el).attr("id"));
}

function submitTargetForm(element)
{
    let form = $(element).data("target");
    console.log("target " + form);
    $("#" + form).submit();
}