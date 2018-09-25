'use strict';

const deletedIngredients = [];
const $ingredients = $('ul#ingredients');

function addJavaScriptButtons() {
    addAddButtonToForm();
    addDeleteButtonsToExistingRows();
    addUndoDeleteButton();
}

function addAddButtonToForm() {
    const $addButton = $(' <button type="button"></button>')
        .addClass('recipe-form__add-ingredient-button')
        .text('Add Ingredient')
        .on('click', addNewIngredient);
    $ingredients.after($addButton);
}

function addDeleteButton($li) {
    const $button = $('<button type="button"></button>')
        .addClass('recipe-form__delete-ingredient-button')
        .text('Delete Ingredient');
    $li.append($button);
}

function addUndoDeleteButton() {
    const $undoButton = $(' <button type="button"></button>')
        .addClass('recipe-form__undo-delete-ingredient-button')
        .text('Undo Last Delete')
        .on('click', undoLastDelete);
    $ingredients.after($undoButton);
    updateUndoButtonState();
}

function updateUndoButtonState() {
    const $undoButton = $('.recipe-form__undo-delete-ingredient-button');
    const disabled = (deletedIngredients.length <= 0);
    $undoButton.attr('disabled', disabled);
}

function addNewIngredient(event) {
    const $list = $('#ingredients');
    const nextId = $list.data('count') + 1;

    const prototype = $list.data('prototype');
    const newInputMarkup = prototype.replace(/__name__/g, nextId);
    const $newInputRow = $('<li></li>').append(newInputMarkup);

    addDeleteButton($newInputRow);

    $list.append($newInputRow);

    $newInputRow.find('select').select2entity();

    $list.data('count', nextId);
}

function deleteIngredient(event) {
    const el = $(this);
    const $li = el.parents('li');

    deletedIngredients.push($li);
    $li.detach();

    updateUndoButtonState();
}

function delegateDeleteButtonClicks() {
    $ingredients.on('click', 'button.recipe-form__delete-ingredient-button', deleteIngredient);
}

function addDeleteButtonsToExistingRows() {
    $ingredients.find('li').each(function (i) {
        addDeleteButton($(this));
    });
}

function undoLastDelete() {
    $ingredients.append(deletedIngredients.pop());
    updateUndoButtonState();
}

$(function () {
    addJavaScriptButtons();
    delegateDeleteButtonClicks();
});