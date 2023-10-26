function fetchArticles(UserID, articleType) {
    var url;
    if (articleType === 'global') {
        url = 'fetch_articles.php'; // Global articles URL
    } else {
        url = 'fetch_local_articles.php?user=' + UserID; // Local articles URL
    }
    $.ajax({
        url: url, // The URL of the server-side PHP script
        method: 'GET',
        dataType: 'json', // Expect JSON response
        success: function (data) {
            $('#articles').empty();
            // Iterate through articles and append them to the "articles" div
            $.each(data, function (index, article) {
                // Create a Bootstrap card for each article
                var cardHtml = `
                    <div class="card mb-3">
                        <div class="row g-0 p-4">
                            <div id="articleImage" class="col-md-4">
                                <img src="${article.image}" alt="Article Image">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">${article.title}</h5>
                                    <p class="card-text">${article.description}</p>
                                    <p class="card-text"><small class="text-muted">Author: ${article.author}</small></p>
                                    <p class="card-text"><small class="text-muted">Date: ${article.date}</small> </p>
                                    <label class="ui-bookmark">
                                    <input type="checkbox">
                                    <div class="bookmark">
                                      <svg viewBox="0 0 32 32">
                                        <g>
                                          <path d="M27 4v27a1 1 0 0 1-1.625.781L16 24.281l-9.375 7.5A1 1 0 0 1 5 31V4a4 4 0 0 1 4-4h14a4 4 0 0 1 4 4z"></path>
                                        </g>
                                      </svg>
                                    </div>
                                  </label>
                                </div>
                            </div>
                        </div>
                    </div>`;

                // Append the card HTML to the "articles" div
                $('#articles').append(cardHtml);
            });
        },
        error: function () {
            console.log('Error fetching articles');
        }
    });
}

// Function to toggle between "Local" and "Global" articles
function toggleArticles(articleType) {
    $('#localLink, #globalLink').removeClass('active'); // Remove active class from both links
    $('#' + articleType + 'Link').addClass('active'); // Add active class to the clicked link
    fetchArticles(UserID, articleType); // Fetch articles based on the type
}

// Call the fetchArticles function to load articles on page load
$(document).ready(function () {
    $('#localLink').addClass('active'); // Add active class to the "Local" link
    fetchArticles(UserID, 'local'); // Load local articles initially // Use the JavaScript variable
});