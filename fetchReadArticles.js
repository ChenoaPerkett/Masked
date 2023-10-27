$(document).ready(function () {
    fetchArticles(profileUserID); // Use the JavaScript variable
});

function fetchArticles(userID) {
    $.ajax({
        url: 'fetch_read_articles.php?user=' + userID, // The URL of the server-side PHP script
        method: 'GET',
        dataType: 'json', // Expect JSON response
        success: function (data) {
            // Iterate through articles and append them to the "articles" div
            $.each(data, function (index, article) {
                // Create a Bootstrap card for each article
                var cardHtml = `
                <div class="card mb-3">
                <div class="row g-0 p-4">
                    <div id="articleImage" class="col-md-4">
                    <a href="article_page.php?articleID=${article.article_id}" class="col-md-4">
                        <img src="${article.image}" alt="Article Image">
                    </a>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <input type="hidden" class="article-id" value="${article.article_id}">
                            <input type="hidden" class="user-id" value="${article.user_id}">
                            <h5 class="card-title">${article.title}</h5>
                            <p class="card-text">${article.description}</p>
                            <p class="card-text"><small class="text-muted">Author: <a href="profile.php?user=${article.user_id}">${article.author}</a></small>            Category: ${article.catorgory}</p>
                            <p class="card-text"><small class="text-muted">Date: ${article.date}</small> </p>
                        </div>
                    </div>`;

                // Append the card HTML to the "articles" div
                $('#ReadRatings').append(cardHtml);
            });
        },
        error: function () {
            console.log('Error fetching articles');
        }
    });
}

// Call the fetchArticles function to load articles on page load
