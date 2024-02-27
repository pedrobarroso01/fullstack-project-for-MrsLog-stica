document.addEventListener('DOMContentLoaded', function () {
    var modalButtons = document.querySelectorAll('button.open-modal');
    var modal = document.getElementById("modal");
    var fade = document.getElementById("fade");

    modalButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var ticketId = button.getAttribute('data-ticket-id');
            abrirModal(ticketId);
        });
    });

    function abrirModal(ticketId) {
        modal.classList.add("show");
        fade.classList.add("show");

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.querySelector(".modal-body").innerHTML = xhr.responseText;
            }
        };
        xhr.open("GET", "detalhes_ticket.php?id=" + ticketId, true);
        xhr.send();
    }

    document.getElementById("close-modal").addEventListener('click', function () {
        modal.classList.remove("show");
        fade.classList.remove("show");
    });

    window.onclick = function (event) {
        if (event.target == fade) {
            modal.classList.remove("show");
            fade.classList.remove("show");
        }
    };

    // Adicione essas linhas para fechar o modal se o usuário recarregar a página
    window.addEventListener('beforeunload', function () {
        modal.classList.remove("show");
        fade.classList.remove("show");
    });
});
