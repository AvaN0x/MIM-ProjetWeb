// Remove a recipe from the favorites list and remove it from the DOM
const toggleFavRecette = async (id) => {
    const result = await (await fetch(`index.php?route=ajax/toggle_favorite/${id}`)).json();

    if (result.success && !result.data.added)
        document.querySelector(`#recette-card-${id}`).remove();
}