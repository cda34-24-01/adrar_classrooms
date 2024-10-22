
document.addEventListener('DOMContentLoaded', function () {
    const reviews = document.querySelectorAll('.review');
    const nextButton = document.getElementById('nextR');
    const prevButton = document.getElementById('prevR');
    let currentReview = 0; 

    function showReview(index) {
        reviews.forEach((review, i) => {
            review.style.display = (i === index) ? 'flex' : 'none';
        });
    }

    nextButton.addEventListener('click', function () {
        currentReview = (currentReview + 1) % reviews.length;
        showReview(currentReview);
        console.log('click');
        
    });

    prevButton.addEventListener('click', function () {
        currentReview = (currentReview - 1 + reviews.length) % reviews.length;
        showReview(currentReview);
        console.log('click');
    });

    showReview(currentReview); 
});
