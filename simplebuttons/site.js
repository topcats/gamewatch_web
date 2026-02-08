
function siteinit() {
    $("div[data-action='docolour']").click(setAction);
}


function setAction() {
    var oButton = $(this);
    if (oButton) {
        var dataaction = oButton.data('colour');
        if (dataaction != "") {
            try {
                $.post("/simplebuttons/action.php", { "colour": dataaction, }, function (returndata, returnstatus) {
                    if (returndata != null) {
                        console.log("Smart action not good");
                        console.debug(returndata);
                    }
                }, 'json');
            } catch (ex) {
                console.log("setAction()", "Error", ex.message)
            }
        }
    }
}

