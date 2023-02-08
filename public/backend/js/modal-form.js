$(document).ready(function() {
    //alert("hello");

    checkFormStatusValue();

    $("#create-form-btn").on("click", function() {
        clearFormData();
        clearValidationErrors();
        showCreateForm();
    })

    $(".edit-form-btn").on("click", function() {
        //console.log($(this).data("id"));
        clearFormData();
        clearValidationErrors();
        console.log($(this).data("id"));
        setHiddenID($(this).data("id"));
        showEditForm($(this).data("id"), false);
    })
});