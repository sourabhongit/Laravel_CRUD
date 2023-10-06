$(document).ready(function () {
    var ItemsContainer = $(".items-container");
    var RestoreItemsContainer = $(".items-container").html();
    var csrfToken = $('meta[name="csrf-token"]').attr("content");
    var searchInput = $("#search");

    searchInput.keyup(function () {
        ItemsContainer.empty();
        var name = searchInput.val();
        var route = searchInput.data("route");
        if (name === "") {
            ItemsContainer.html(RestoreItemsContainer);
        } else {
            $.ajax({
                type: "POST",
                url: route,
                data: {
                    ItemName: name,
                    _token: csrfToken,
                },
                success: function (response) {
                    $.each(response.items, function (index, item) {
                        var itemCard = `
                            <div class="card" style="width: 15rem; height: 26rem; background-color: #121212;">
                                <div style="text-align: center">
                                    <img class="card-img-top" src="${response.baseURL}/images/items/${item.photo}" alt="Card image cap">
                                </div>
                                <div class="card-body" style="background-color: #383838">
                                    <h5 class="card-title text-white mb-2"><strong>${item.name}</strong></h5>
                                    <h6 class="text-white mb-2" style="clear:both;">
                                        <strong>${item.price}</strong>
                                    </h6>
                                    <p class="card-text text-white">${item.description}</p>
                                    <a href="#" class="btn btn-primary">Buy Now</a>
                                </div>
                            </div>`;
                        ItemsContainer.append(itemCard);
                    });
                },
                error: function (error) {
                    console.log("Item Search Error: " + error);
                },
            });
        }
    });
});
