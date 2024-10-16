// let reviewArray;
// let userArray;
// let reviewList= [];

// async function getReviews(){
//     const resReview = await fetch("http://127.0.0.1:8001/api/reviews?page=1")

//     const { member } = await resReview.json()
//     console.log(member)

//     reviewArray = member
//     console.log(reviewArray)
//     console.log(reviewArray.length);

// } 
// async function getUsers(){
//     const resUser = await fetch("http://127.0.0.1:8001/api/users?page=1")

//     const { member } = await resUser.json()
//     console.log(member)

//     userArray = member
//     console.log(userArray)

// }




// getReviews();
// getUsers();

// console.log(userArray.length);

// function displayReviews() {
// const reviews = reviewArray
// console.log(userArray.length);

//     for (let i = 0; i < reviews.length; i++) {
//         const userReview = reviewArray[i].user;
//         console.log(userReview);
        
//         //  function getInfoReview(){
//         //     const getInfos = fetch(`http://127.0.0.1:8001${reviewArray[i].user}`)

//         //     const userInfos = getInfos.json()

//         //     userData = userInfos
//         //     console.log(userData.username);

//         //     let userName = userData.firstname
//         //     const reviewName = document.createElement("h4");
//         //     reviewName.innerText = `${userName}`
//         //     // document.querySelector('.container-reviews').appendChild(reviewName);

//         //     let comment = reviewArray[i].content
//         //     const commentReview = document.createElement("p");
//         //     commentReview.innerText = `${comment}`

//         //     let review = document.createElement('div')
//         //     review.setAttribute('id', `${i}`)
//         //     review.appendChild(reviewName)
//         //     review.appendChild(commentReview)
//         //     document.querySelector('.container-reviews').appendChild(review);
//         // }
//         // getInfoReview()
        
//     }

    

//     // document.querySelector('#prevR').addEventListener('click', scrollToPrevSection);
//     // document.querySelector('#nextR').addEventListener('click', scrollToNextSection);

//     // function scrollToNextSection() {
//     //     let currentSection = document.querySelector('.container-reviews div').closest('div');
//     //     let nextSection = currentSection.nextElementSibling;

      
//     //     if (nextSection) {
//     //       nextSection.scrollIntoView();
//     //       currentSection = nextSection
//     //     }
        
//     //   }
//     // function scrollToPrevSection() {
//     //     const currentSection = document.querySelector('.container-reviews div').closest('div');
//     //     const prevSection = currentSection.previousElementSibling;

      
//     //     if (prevSection) {
//     //         prevSection.scrollIntoView();
//     //       }
        
//     //   }



      
    
//     // reviewArray.forEach(review => {
//     //     // const reviewAvatar = document.createElement("img")
//     //     // reviewAvatar.src = `${review.user}`
//     //     // async function getInfoReview(){
//     //     //     const getInfos = await fetch(`http://127.0.0.1:8001${review.user}`)

//     //     //     const userInfos = await getInfos.json()

//     //     //     userData = userInfos
//     //     //     console.log(userData.username);
            
//     //     // }
//     //     // getInfoReview()
        
//     //     // const reviewName = document.createElement("h4");
//     //     // reviewName.innerText = `${review.user}`
//     //     // document.querySelector('.container-reviews').appendChild(reviewName);
//     // });
// }

// displayReviews();

document.addEventListener('DOMContentLoaded', function () {
    const reviews = document.querySelectorAll('.review'); // Sélectionne tous les avis
    const nextButton = document.getElementById('nextR');
    const prevButton = document.getElementById('prevR');
    let currentReview = 0; // Indice de l'avis actuel

    function showReview(index) {
        reviews.forEach((review, i) => {
            review.style.display = (i === index) ? 'flex' : 'none'; // Affiche l'avis courant et cache les autres
        });
    }

    nextButton.addEventListener('click', function () {
        currentReview = (currentReview + 1) % reviews.length; // Passer à l'avis suivant
        showReview(currentReview);
        console.log('click');
        
    });

    prevButton.addEventListener('click', function () {
        currentReview = (currentReview - 1 + reviews.length) % reviews.length; // Revenir à l'avis précédent
        showReview(currentReview);
        console.log('click');
    });

    showReview(currentReview); // Affiche le premier avis par défaut
});
