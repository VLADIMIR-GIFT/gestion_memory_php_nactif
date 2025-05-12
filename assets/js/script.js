document.addEventListener("DOMContentLoaded", function () {
    const envoyerDemandeBtn = document.querySelector("#envoyerDemande");

    if (envoyerDemandeBtn) {
        envoyerDemandeBtn.addEventListener("click", function () {
            const cibleId = document.querySelector("#etudiantCibleId").value;

            fetch("../controllers/BinomeController.php?action=demande", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ cible_id: cibleId }),
            })
            .then((response) => response.json())
            .then((data) => {
                alert(data.message);
            })
            .catch((error) => {
                console.error("Erreur:", error);
                alert("Une erreur est survenue.");
            });
        });
    }
});
