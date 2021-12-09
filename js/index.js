const connectUser = async () => {
    const form = document.forms["login"];
    if (!form) return;

    const result = await (await fetch("index.php?route=ajax/connectuser", { method: "POST", body: new FormData(form) })).json();
    if (result.success) {
        location.reload();
        return
    }

    if (result.data.errors) {
        for (const error in result.data.errors) {
            const formElement = form.elements[error];
            if (formElement)
                formElement.classList.add("error-field");

            const errorElement = document.getElementById(`form-login-error-${error}`);
            if (errorElement) {
                errorElement.innerHTML = `<i class="fas fa-question"></i>`;
                errorElement.dataset.errortooltip = result.data.errors[error];
            }
        }
    }
}

const disconnectUser = async () => {
    const result = await (await fetch("index.php?route=ajax/disconnectuser")).json();
    if (result.success)
        location.reload();
}
