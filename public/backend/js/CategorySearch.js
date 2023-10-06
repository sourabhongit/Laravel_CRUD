$(document).ready(function () {
    var CategoriesContainer = $(".categories-container");
    var RestoreCategoriesContainer = $(".categories-container").html();
    var csrfToken = $('meta[name="csrf-token"]').attr("content");
    var searchInput = $("#search");

    searchInput.keyup(function () {
        CategoriesContainer.empty();
        var name = searchInput.val();
        var route = searchInput.data("route");
        if (name === "") {
            CategoriesContainer.html(RestoreCategoriesContainer);
        } else {
            $.ajax({
                type: "POST",
                url: route,
                data: {
                    CategoryName: name,
                    _token: csrfToken,
                },
                success: function (response) {
                    $.each(response.categories, function (index, category) {
                        var categoryCard = `
                            <div class="card" style="width: 15rem; height: 26rem; background-color: #121212;">
                                <div style="text-align: center">
                                    <img class="card-img-top" src="${response.baseURL}/images/categories/${category.photo}" alt="Card image cap">
                                </div>
                                <div class="card-body" style="background-color: #383838">
                                    <h5 class="card-title text-white mb-2"><strong>${category.name}</strong></h5>
                                    <p class="card-text text-white">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                    <a href="${response.baseURL}/guest/category/${category.id}" class="btn btn-primary">Check Items</a>
                                </div>
                            </div>`;
                        CategoriesContainer.append(categoryCard);
                    });
                },
                error: function (error) {
                    console.log("Search Error: " + error);
                },
            });
        }
    });
});
