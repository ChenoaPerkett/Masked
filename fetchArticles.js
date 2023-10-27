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
                                <div>
                                <fieldset class="rating">
                         <input type="radio" id="star5" name="rating_${article.article_id}" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                         <input type="radio" id="star4" name="rating_${article.article_id}" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                         <input type="radio" id="star3" name="rating_${article.article_id}" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                         <input type="radio" id="star2" name="rating_${article.article_id}" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                         <input type="radio" id="star1" name="rating_${article.article_id}" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                         <input type="radio" class="reset-option" name="rating" value="reset" />
                     </fieldset>
                     <textarea class="form-control" rows="3" placeholder="Leave a review/comment" id="comment_${article.article_id}"></textarea>
                     <label for="reviewImage">Upload Image:</label>
                     <input type="file" class="form-control" name="reviewImage" id="reviewImage" accept="image/*" />
                     <button class="btn btn-dark" onclick="submitRatingAndReview(${article.article_id}, ${UserID})">Submit Rating & Review</button>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>`;

                $('#articles').append(cardHtml);
            });
        },
        error: function () {
            console.log('Error fetching articles');
        }
    });
}

function submitRatingAndReview(articleID, userID, rating, comment) {
    var reviewImage = $("#reviewImage")[0].files[0];
    var rating = $("input[name='rating_" + articleID + "']:checked").val();
    var comment = $("textarea[id='comment_" + articleID + "']").val();
    if (rating) {
        var formData = new FormData();
        formData.append('articleID', articleID);
        formData.append('userID', userID);
        formData.append('rating', rating);

        $.ajax({
            url: 'rating.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log('Rating and review submitted successfully.');
            },
            error: function () {
                console.log('Error submitting rating and review');
            }
        });
    }
    if (comment) {
        var formData = new FormData();
        formData.append('articleID', articleID);
        formData.append('userID', userID);
        formData.append('comment', comment);

        if (reviewImage) {
            formData.append('reviewImage', reviewImage);
        }

        $.ajax({
            url: 'review.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                // Handle success (e.g., show a confirmation message)
                console.log('Rating and review submitted successfully.');
            },
            error: function () {
                // Handle error (e.g., show an error message)
                console.log('Error submitting rating and review');
            }
        });
    }
}


function toggleArticles(articleType) {
    $('#localLink, #globalLink').removeClass('active');
    $('#' + articleType + 'Link').addClass('active');
    fetchArticles(UserID, articleType);
}


$(document).ready(function () {
    $('#localLink').addClass('active');
    fetchArticles(UserID, 'local');
});