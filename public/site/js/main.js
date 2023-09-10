/*
 * Author M. Atoar Rahman
 * Date: 07/03/2022
 * Time: 11:40 AM
*/

$(document).ready(function(){
    /*----------------------------------
        Menu
    -----------------------------------*/



    /*----------------------------------
        Banner owlCarousel
    -----------------------------------*/
    $('#carouselSlide').owlCarousel({
        loop: true,
        autoplay:true,
        margin: 0,
        smartSpeed: 1000,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: true,
                dots: false,
                loop: true,
                margin: 0
            }
        }
    })

    /*----------------------------------
        Count Down Timer
    -----------------------------------*/
    let countDownBox	= document.querySelector(".allTime");
    let daysBox			= document.querySelector(".days");
    let hrsBox			= document.querySelector(".hrs");
    let minBox			= document.querySelector(".min");
    let secBox			= document.querySelector(".sec");
    let countDownDate	= new Date("Nov 06, 2022 18:00:00").getTime();
    // COUNT DOWN FUNCTION
    let x = setInterval(function() {

        // GET DATE
        let now = new Date().getTime();

        // TIME BETWEEN NOW AND DATE
        let distance = countDownDate - now;

        // CALCULATION TIME
        let days 	= Math.floor(distance / (1000 * 60 * 60 * 24));
        let hours 	= Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        let minutes	= Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        let seconds	= Math.floor((distance % (1000 * 60)) / 1000);

        daysBox.innerHTML	= days + "<span>Days</span>";
        hrsBox.innerHTML 	= hours + "<span>Hours</span>";
        minBox.innerHTML 	= minutes + "<span>Minutes</span>";
        secBox.innerHTML 	= seconds + "<span>Seconds</span>";

        // IF FINISH
        if (distance < 0) {
            clearInterval(x);
            countDownBox.innerHTML = "¡FELICIDADES!";
        }
    }, 1000);

    /*----------------------------------
        Tabs
    -----------------------------------*/


    /*----------------------------------

    -----------------------------------*/

});

