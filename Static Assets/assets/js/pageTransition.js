document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll("a").forEach(link => {
        link.addEventListener("click", function (event) {
            event.preventDefault();

            document.body.classList.add("fade-out");

            const targetUrl = this.href;
            setTimeout(() => {
                window.location.href = targetUrl;
            }, 500); 
        });
    });
});
