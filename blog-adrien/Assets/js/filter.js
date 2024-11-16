document.addEventListener("DOMContentLoaded", function () {
    const filterSelect = document.getElementById("filter-country");
    const articles = document.querySelectorAll(".article");

    filterSelect.addEventListener("change", function () {
        const selectedCountry = this.value.toLowerCase();

        articles.forEach(article => {
            const articleCountry = article.getAttribute("data-country").toLowerCase();

            if (selectedCountry === "" || articleCountry === selectedCountry) {
                article.style.display = "block";
            } else {
                article.style.display = "none";
            }
        });
    });
});
