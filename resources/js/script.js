const add_guest = document.getElementById("add-participants-btn");
const additional_guest = document.getElementById("additional-participants");

function addGuest() {
    const nb_guests = additional_guest.children.length + 1;
    if (nb_guests > 5) {
        alert("Vous ne pouvez pas ajouter plus de 5 participants.");
        addGuester.disabled = true;
        return;
    }

    const name = document.createElement("input");
    name.type = "text";
    name.name = "participant_name_1";
    name.placeholder = "Nom Prénom";
    name.classList.add(
        "p-2",
        "border",
        "border-gray-300",
        "rounded-lg",
        "w-full",
        "max-w-md",
    );

    const dietary = document.createElement("input");
    dietary.type = "text";
    dietary.name = "participant_dietary_1";
    dietary.placeholder = "Préférences alimentaires";
    dietary.classList.add(
        "p-2",
        "border",
        "border-gray-300",
        "rounded-lg",
        "w-full",
        "max-w-md",
    );

    const guest_profile = document.createElement("div");

    const flex = document.createElement("div");
    flex.classList.add("flex", "gap-4", "items-center", "mb-4");

    const title = document.createElement("div");
    title.classList.add(
        "text-lg",
        "font-semibold",
        "text-heading",
        "text-center",
    );

    guest_profile.appendChild(title);
    guest_profile.appendChild(flex);
    title.innerText = `Participant ${nb_guests} :`;
    flex.appendChild(name);
    flex.appendChild(dietary);
    additional_guest.appendChild(guest_profile);
}

add_guest.addEventListener("click", addGuest);
