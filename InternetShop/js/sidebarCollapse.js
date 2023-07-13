function openNav() {
    document.getElementById("sidebar").style.width = "200px";
    document.getElementById("main").style.marginLeft = "200px";
    let wrapper = document.querySelector("body");
    wrapper.classList.add("shadow-background");
}

function closeNav() {
    document.getElementById("sidebar").style.width = "0";
    document.getElementById("main").style.marginLeft = "0";
    let wrapper = document.querySelector("body");
    wrapper.classList.remove("shadow-background");
}

document.getElementById("sidebarCollapse").addEventListener("click", function() {
    openNav();
});

document.getElementById("closeSidebar").addEventListener("click", function() {
    closeNav();
});