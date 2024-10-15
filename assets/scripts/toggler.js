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


async function getLanguages(){
    const res = await fetch("http://127.0.0.1:8001/api/languages?page=1")

    const { member } = await res.json()
    console.log(member)

    dataArray = orderList(member)
}



getLanguages();


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

}

// window.onload = displayReviews()





// Scroll to top
function toTop() {
    document.querySelector('.body').scrollTo({ top: 0, behavior: 'smooth' });
    console.log("test");
}

document.documentElement.scrollTop = 0;


