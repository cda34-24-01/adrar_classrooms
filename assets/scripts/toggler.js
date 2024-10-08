
// const iconPlus = document.querySelector('#icon_plus');
// const iconbar = document.querySelector('#icon_bar');
// const moreIcons = document.querySelector('#more-icons');
// const icons = document.querySelectorAll('.icons');
// const bar1 = document.querySelector('#bar_one');
// const bar2 = document.querySelector('#bar_two');
// const burger = document.querySelector('#burger');
// const registered = document.querySelector('#registered');
// const rBg = document.querySelector('#r-bg');
// const background = document.querySelector('.background');


// const searchBar = document.querySelector('.search-bar');
// const search = document.querySelector('.search');
// const textBar = document.querySelector('#hover-toggle');

// const searchIcon = document.querySelector('#search-toggler');
// const searchBar = document.querySelector('#search-bar');
// const navList = document.querySelector('#nav');
// const navLink = document.querySelectorAll('a');

// const textBar = document.querySelector('#text-bar');
// const fullBar = document.querySelector('.end-nav');
// const btnUp = document.querySelector('.btn-up');
// const rootElement = document.querySelector('.body');





// let focused = false;

// searchIcon.addEventListener('click', () => {
//     // searchIcon.classList.toggle('clicked')
//     fullBar.classList.toggle('on')
//     searchBar.classList.toggle('clicked')
//     textBar.classList.toggle('on')
//     navList.classList.toggle('off')
// })
function unfold() {
    // searchIcon.classList.toggle('clicked')
    document.querySelector('.end-nav').classList.toggle('on')
    document.querySelector('#search-bar').classList.toggle('clicked')
    document.querySelector('#text-bar').classList.toggle('on')
    document.querySelector('#nav').classList.toggle('off')
}


function toTop() {
    document.querySelector('.body').scrollTo({ top: 0, behavior: 'smooth' });
    console.log("test");
}

// navLink.forEach(l => {
//     // this.classList.toggle('selected')
//     console.log('test');
    
// });

// searchBar.addEventListener('mouseover', () => {
//     searchBar.classList.add('unfolded')
//     textBar.classList.add('unfolded')
//     searchIcon.classList.add('unfolded')
// })

// searchBar.addEventListener("mouseleave", () => {
//     if (!focused) {
//         searchBar.classList.remove('unfolded')
//         textBar.classList.remove('unfolded')
//         mapTarget.classList.remove('unfolded')
//     }
// });



document.documentElement.scrollTop = 0;



// searchBar.addEventListener('click', () => {
//     focused = true;
//     return;
// })

// search.addEventListener('focusout', () => {
//     searchBar.classList.remove('unfolded')
//     textBar.classList.remove('unfolded')
//     mapTarget.classList.remove('unfolded')
//     focused = false;
// })


// let deployed = false;  

// iconPlus.addEventListener('click', () => {
//     bar1.classList.toggle('rotated')
//     bar2.classList.toggle('rotated2')
//     moreIcons.classList.toggle('visible')
//     console.log(icons.length)

//     deploy();
//     // for (i = 0; i < icons.length; i++) {
//     //     setTimeout(deploy,5000)
//     // }
// })

// burger.addEventListener('click', () => {
//     console.log('test')
// })

// // function deploy() {
// //     for (i=0; i<12; i++) {
// //         let iconUnit = document.createElement('img');
// //         iconUnit.src = `./assets/imgs/icons/more/${[i]}.svg`;
// //         iconUnit.classList.add('icons');
// //         iconbar.appendChild(iconUnit);
// //     }
// // }

// function deploy() {
//     icons.forEach(icon => {
//         setInterval(icon.classList.toggle('visible'), 2000)
//     });
// }