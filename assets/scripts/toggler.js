// Barre qui s'étend
function unfold() {
    // searchIcon.classList.toggle('clicked')
    document.querySelector('.end-nav').classList.toggle('on')
    document.querySelector('#search-input').classList.toggle('on')
    document.querySelector('#search-bar').classList.toggle('clicked')
    document.querySelector('.search-btn').classList.toggle('clicked')

    // document.querySelector('#text-bar').classList.toggle('on')
    document.querySelector('#nav').classList.toggle('off')
}

// dynamic search
const searchInput = document.querySelector('#search-input')
const searchResult = document.querySelector('#suggestion-list')

let dataArray;
let reviewArray;
let userArray;
let reviewList= [];

async function getLanguages(){
    const res = await fetch("http://127.0.0.1:8001/api/languages?page=1")

    const { member } = await res.json()
    console.log(member)

    dataArray = orderList(member)
}

async function getReviews(){
    const resReview = await fetch("http://127.0.0.1:8001/api/reviews?page=1")

    const { member } = await resReview.json()
    console.log(member)

    reviewArray = member
    console.log(reviewArray)

}
async function getUsers(){
    const resUser = await fetch("http://127.0.0.1:8001/api/users?page=1")

    const { member } = await resUser.json()
    console.log(member)

    userArray = member
    console.log(userArray)

}

getLanguages();
getReviews();
getUsers();





function orderList(data) {
    const orderedData = data.sort((a,b) => {
        if (a.title.toLowerCase() < b.title.toLowerCase()) return -1; return 0;
    })

    return orderedData;
}

function displaySuggestion(languagesList) {
    languagesList.forEach(language => {
        const listItem = document.createElement("li");
        listItem.innerHTML = `<p>${language.title}</p>`
        searchResult.appendChild(listItem);
    });
}



async function displayReviews(reviewList) {
    console.log(reviewArray);

    for (let i = 0; i < reviewArray.length; i++) {
        async function getInfoReview(){
            const getInfos = await fetch(`http://127.0.0.1:8001${reviewArray[i].user}`)

            const userInfos = await getInfos.json()

            userData = userInfos
            console.log(userData.username);

            let userName = userData.firstname
            const reviewName = document.createElement("h4");
            reviewName.innerText = `${userName}`
            document.querySelector('.container-reviews').appendChild(reviewName);

            let comment = reviewArray[i].content
            let commentReview = document.createElement("p");
            commentReview.innerText = `${comment}`
            document.querySelector('.container-reviews').appendChild(commentReview);
        }
        getInfoReview()
        
    }
    
    // reviewArray.forEach(review => {
    //     // const reviewAvatar = document.createElement("img")
    //     // reviewAvatar.src = `${review.user}`
    //     // async function getInfoReview(){
    //     //     const getInfos = await fetch(`http://127.0.0.1:8001${review.user}`)

    //     //     const userInfos = await getInfos.json()

    //     //     userData = userInfos
    //     //     console.log(userData.username);
            
    //     // }
    //     // getInfoReview()
        
    //     // const reviewName = document.createElement("h4");
    //     // reviewName.innerText = `${review.user}`
    //     // document.querySelector('.container-reviews').appendChild(reviewName);
    // });
}

searchInput.addEventListener('input', filterData)

function filterData(e) {

    searchResult.innerHTML = "";

    const searchValue = e.target.value.toLowerCase();

    if (searchValue === "") {
        searchResult.innerHTML = ""; // Vider la liste si l'input est vide
        return; // Sortir de la fonction
    }

    if (searchResult.length < 1) {
        searchResult.classList.toggle('filled')
    }

    const filteredArr = dataArray.filter(el => el.title.toLowerCase().includes(searchValue));

    

    displaySuggestion(filteredArr)
    displayReviews()
}

// window.onload = displayReviews()





// Scroll to top
function toTop() {
    document.querySelector('.body').scrollTo({ top: 0, behavior: 'smooth' });
    console.log("test");
}

document.documentElement.scrollTop = 0;


