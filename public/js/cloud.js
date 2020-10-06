function addAtFirst(containerId, field) {
    let container = $(containerId);
    $(container).prepend(field);
    console.log(field);
}

function checkInputArray(inputName) {
    var input = document.getElementsByName(inputName);
    var allFilled = true;

    for (var i = 0; i < input.length; i++) {
        if (input[i].value == '') {
            allFilled = false;
            break;
        }
    }

    return allFilled;
}

function deleteElements(elementIds, button){
    elementIds.forEach(id => {
        var element = document.getElementById(id);
        if(element){ element.remove(); }
    });
    if(button){button.remove();}
}