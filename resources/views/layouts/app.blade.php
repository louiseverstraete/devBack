<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Dev</title>
    <script src="resources/js/script.js"></script>
</head>
<body>
    <header class="bg-blue-950 text-white p-4 flex items-center justify-between">
        <h1 class="text-3xl font-bold">Event Manager</h1>
        <nav>
            <a href="{{ route('events.index') }}" class="text-white hover:text-gray-300">Home</a>
            <a href="http://127.0.0.1:8000/admin/login" class="ml-4 text-blue-950 hover:bg-blue-100 bg-white p-2">Espace privé</a>
        </nav>
    </header>
    <main class="container mx-auto p-4">
        @yield('content')
    </main>
    <script>
        const add_guest = document.getElementById("add-participants-btn");
const additional_guest = document.getElementById("additional-participants");

function updateTitles() {
    const profiles = additional_guest.children;
    for (let i = 0; i < profiles.length; i++) {
        profiles[i].querySelector("div").innerText = `Participant ${i + 1} :`;
    }
}

function addGuest() {
    const nb_guests = additional_guest.children.length + 1;

    if (nb_guests > 5) {
        alert("Vous ne pouvez pas ajouter plus de 5 participants.");
        add_guest.disabled = true;
        return;
    }

    const name = document.createElement("input");
    name.type = "text";
    name.name = "guest_name[]";
    name.placeholder = "Nom Prénom";
    name.classList.add("p-2", "border", "border-gray-300", "rounded-lg", "w-full", "max-w-md");

    const dietary = document.createElement("input");
    dietary.type = "text";
    dietary.name = "guest_dietary[]";
    dietary.placeholder = "Préférences alimentaires";
    dietary.classList.add("p-2", "border", "border-gray-300", "rounded-lg", "w-full", "max-w-md");

    const delete_btn = document.createElement("button");
    delete_btn.type = "button";
    delete_btn.classList.add(
        "text-white", "rounded-xl", "bg-red-600", "border", "border-transparent",
        "hover:bg-red-500", "font-medium", "text-sm", "px-1.5", "focus:outline-none"
    );
    delete_btn.innerHTML = "&times;";
    delete_btn.addEventListener("click", () => {
        additional_guest.removeChild(guest_profile);
        updateTitles(); // ← renumérotation après suppression
        if (additional_guest.children.length < 5) {
            add_guest.disabled = false;
        }
    });

    const guest_profile = document.createElement("div");
    const flex = document.createElement("div");
    flex.classList.add("flex", "gap-4", "items-center", "mb-4");

    const title = document.createElement("div");
    title.classList.add("text-lg", "font-semibold", "text-heading", "text-center");
    title.innerText = `Participant ${nb_guests} :`;

    guest_profile.appendChild(title);
    guest_profile.appendChild(flex);
    flex.appendChild(name);
    flex.appendChild(dietary);
    flex.appendChild(delete_btn);
    additional_guest.appendChild(guest_profile);
}

add_guest.addEventListener("click", addGuest);
</script>
</body>
</html>