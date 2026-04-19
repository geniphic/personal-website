document.getElementById("search").addEventListener("keyup", function () {
    let text = this.value.trim();

    if (text.length < 1) {
        document.getElementById("search-results").innerHTML = "";
        return;
    }

    fetch("search_products.php?query=" + encodeURIComponent(text))
        .then(res => res.text())
        .then(data => {
            document.getElementById("search-results").innerHTML = data;
        });
});
