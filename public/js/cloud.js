function addAtFirst(containerId, field) {
    let container = $(containerId);
    $(container).prepend(field);
    console.log(field);
}

function addAtLast(containerId, field) {
    let container = $(containerId);
    $(container).append(field);
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
    if(button){button.parentNode.parentNode.remove();}
}

function deleteElement(button, niveis = 1){
    var parent = button.parentNode;
    for( i = 1; i < niveis; i++){
        parent = parent.parentNode;
    }
    if(parent){parent.remove();}
}

function addButtonDelete(parentId, button){
    var element = $(parentId);
    element.innerHTML = element.innerHTML+button;
}