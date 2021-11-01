// Toggle a recipe from the favorite list and edit the heart style
const toggleFavRecette = async (id) => {
    const result = await (await fetch(`index.php?route=ajax/toggle_favorite/${id}`)).json();

    if (result.success) {
        const fav = document.querySelector(`#recette-card-${id} .recette-card-fav > a > i`);
        if (fav) {
            fav.classList.toggle('fas');
            fav.classList.toggle('far');
        }
    }
}