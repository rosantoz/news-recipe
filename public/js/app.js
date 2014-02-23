$(document).ready(function () {

    var toggleLoading = function () {
        $("#loading").toggle();
    };

    var toggleForm = function () {
        $("#uploadFormSection").toggle();
    }

    var toggleResult = function () {
        $("#result").toggle();
        $("#recommendation").html('');
    }

    /* $("#find-what-to-cook").on('click', function () {
     toggleLoading();
     toggleForm();

     $.ajax('recipeFinder.php', {
     type   : 'POST',
     data   : {
     items  : $("#items").val(),
     recipes: $("#recipes").val()
     },
     success: function (response) {
     toggleLoading();
     toggleResult();
     $("#result").show();
     $("#recomendation").prepend('<span><strong>' + response + '</strong></span>');
     },
     error  : function (jqXHR, textStatus) {
     toggleLoading();
     toggleResult();
     $("#recomendation").find("span").find("strong").text("Something went wrong! Sorry!");
     console.log(jqXHR);
     console.log(textStatus);
     }
     });
     });*/

    $("#tryAgain").on('click', function () {
        toggleResult();
        toggleForm();
    });

    $("#find-what-to-cook").on('click', function () {
        if ($("#items").val() == '') {
            alert('Select the file containing the items in the fridge');
            return false;
        }
        if ($("#recipes").val() == '') {
            alert('Select the file containing the recipes');
            return false;
        }

        toggleLoading();
        toggleForm();

        $("#uploadForm").submit();
    });

    $('#uploadForm').ajaxForm({
            url      : 'recipeFinder.php',
            clearForm: true,
            success  : function (response) {
                console.log(response);
                toggleLoading();
                toggleResult();
                $("#result").show();
                $("#recommendation").prepend('<span><strong>' + response + '</strong></span>');
            },
            error    : function () {
                toggleLoading();
                toggleResult();
                $("#recomendation").find("span").find("strong").text("Something went wrong! Sorry!");
            }
        }
    );

});