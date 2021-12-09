const connectUser = async () => {
    const form = document.forms["login"];
    if (!form) return;

    const result = await (await fetch("index.php?route=ajax/connectuser", { method: "POST", body: new FormData(form) })).json();

    // Player is logged
    if (result.success) {
        location.reload();
        return
    }

    // Player is not logged, then we display errors
    if (result.data.errors) {
        // For every errors fields
        for (const error of ["login", "password"]) {
            // If error exist in result
            const formElement = form.elements[error];
            const errorElement = document.getElementById(`form-login-error-${error}`);

            if (result.data.errors[error]) {
                // Add class error-field
                if (formElement)
                    formElement.classList.add("error-field");

                // We set the content of the tooltip
                if (errorElement) {
                    errorElement.innerHTML = `<i class="fas fa-question"></i>`;
                    errorElement.dataset.errortooltip = result.data.errors[error];
                }
            } else {
                // Remove the error
                // Remove class error-field
                if (formElement)
                    formElement.classList.remove("error-field");

                // Remove the content from the tooltip
                if (errorElement) {
                    errorElement.innerHTML = "";
                    errorElement.dataset.errortooltip = "";
                }
            }
        }
    }
}

const disconnectUser = async () => {
    const result = await (await fetch("index.php?route=ajax/disconnectuser")).json();

    // Player have disconnected, then success
    if (result.success)
        location.reload();
}
