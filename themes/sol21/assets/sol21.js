

var instances_sidenav;
document.addEventListener("DOMContentLoaded", function () {
    function main() {
        M.AutoInit();
        createBtnMore();
        eventsMainItem();
    }

    var swiper = new Swiper(".swiper-container", {
        slidesPerView: 4,
        spaceBetween: 0,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });


    function topPage() {
        console.log("SCROLL TOP = 0");
        scroll({
            top: 0,
            behavior: "smooth"
        });
    }

    function eventsMainItem() {
        var menu_item = document.getElementsByClassName('menu-item');

        for (var i = 0; i <= menu_item.length - 1; i++) {
            menu_item[i].firstChild.classList.add('sidenav-close');
        }
    }

    function createBtnMore() {
        var sol_info = document.getElementsByClassName('sol-info');
        var info_gradient = document.getElementsByClassName('info-gradient');

        for (var i = 0; i <= sol_info.length - 1; i++) {
            sol_info[i].id = "sol-info-" + i;
            info_gradient[i].id = "info-gradient-" + i;
        }
    }

    function viewMore(id) {
        var sol_info = document.getElementById('sol-info-' + id);
        var info_gradient = document.getElementById('info-gradient-' + id);

        console.log("element: " + sol_info.innerHTML);
        sol_info.classList.add('sol-info-more');
        info_gradient.classList.remove('info-gradient');
        info_gradient.classList.add('info-gradient-more');

        var elem_icon_remove = document.getElementsByClassName('elem-icon-remove');
        elem_icon_remove[id].classList.remove('icon-remove-90deg');

        var btn_more = document.getElementsByClassName('btn-more');
        btn_more[id].removeAttribute("onclick");
        btn_more[id].setAttribute('onclick', 'hideInfo(' + id + ')');
    }

    function hideInfo(id) {
        var sol_info = document.getElementById('sol-info-' + id);
        var info_gradient = document.getElementById('info-gradient-' + id);

        sol_info.classList.remove('sol-info-more');
        info_gradient.classList.remove('info-gradient-more');
        info_gradient.classList.add('info-gradient');

        var elem_icon_remove = document.getElementsByClassName('elem-icon-remove');
        elem_icon_remove[id].classList.add('icon-remove-90deg');

        var btn_more = document.getElementsByClassName('btn-more');
        btn_more[id].removeAttribute("onclick");
        btn_more[id].setAttribute('onclick', 'viewMore(' + id + ')');
    }



    main();
});
