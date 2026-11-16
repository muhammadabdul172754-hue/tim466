
document.documentElement.classList.add("js-enabled");

document.addEventListener("DOMContentLoaded", function () {

    const header = document.getElementById("header");
    const menuToggle = document.getElementById("menuToggle");
    const navMenu = document.getElementById("navMenu");
    const backToTop = document.getElementById("backToTop");
    const year = document.getElementById("currentYear");

    // Tahun otomatis
    if (year) {
        year.textContent = new Date().getFullYear();
    }

    // Efek navbar
    function updateScroll() {
        const position = window.scrollY;

        if (header) {
            header.classList.toggle("scrolled", position > 20);
        }

        if (backToTop) {
            backToTop.classList.toggle("show", position > 350);
        }
    }

    window.addEventListener("scroll", updateScroll);
    updateScroll();

    // Menu mobile
    if (menuToggle && navMenu) {

        menuToggle.addEventListener("click", function () {

            const opened = navMenu.classList.toggle("active");

            menuToggle.setAttribute(
                "aria-expanded",
                String(opened)
            );

            const icon = menuToggle.querySelector("i");

            if (icon) {
                icon.className = opened
                    ? "bi bi-x-lg"
                    : "bi bi-list";
            }
        });

        navMenu.querySelectorAll("a").forEach(function (link) {

            link.addEventListener("click", function () {

                navMenu.classList.remove("active");

                menuToggle.setAttribute(
                    "aria-expanded",
                    "false"
                );

                const icon = menuToggle.querySelector("i");

                if (icon) {
                    icon.className = "bi bi-list";
                }
            });
        });
    }

    // Animasi scroll
    const revealItems = document.querySelectorAll(".reveal");

    if ("IntersectionObserver" in window) {

        const observer = new IntersectionObserver(
            function (entries, observer) {

                entries.forEach(function (entry) {

                    if (entry.isIntersecting) {

                        entry.target.classList.add("show");

                        observer.unobserve(entry.target);
                    }
                });

            },
            {
                threshold: 0.12
            }
        );

        revealItems.forEach(function (item) {
            observer.observe(item);
        });

    } else {

        revealItems.forEach(function (item) {
            item.classList.add("show");
        });
    }

    // Navigasi aktif
    const navLinks = document.querySelectorAll(
        ".nav-link:not(.nav-contact)"
    );

    const sections = document.querySelectorAll(
        "main section[id]"
    );

    if ("IntersectionObserver" in window) {

        const sectionObserver = new IntersectionObserver(
            function (entries) {

                entries.forEach(function (entry) {

                    if (!entry.isIntersecting) return;

                    navLinks.forEach(function (link) {

                        link.classList.toggle(
                            "active",
                            link.getAttribute("href") ===
                            "#" + entry.target.id
                        );
                    });
                });
            },
            {
                rootMargin: "-35% 0px -55% 0px"
            }
        );

        sections.forEach(function (section) {
            sectionObserver.observe(section);
        });
    }

    // Tombol kembali ke atas
    if (backToTop) {

        backToTop.addEventListener("click", function () {

            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        });
    }

});
