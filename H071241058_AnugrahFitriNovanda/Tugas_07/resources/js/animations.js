console.log("File animations.js berhasil terhubung! Siap untuk anime.js!");

window.onload = function() {
    const preloader = document.getElementById('preloader');
    const body = document.querySelector('body');
    
    if (preloader) {
        preloader.classList.add('loaded');
        
        body.classList.remove('body-loading');
    }
};

document.addEventListener('DOMContentLoaded', () => {

    if (document.querySelector('.hero-title')) {
        
        anime.timeline({
            easing: 'easeOutExpo',
        })
        .add({
            targets: '.hero-title .letter',
            translateY: [100, 0],
            opacity: [0, 1],
            duration: 1500,
            delay: anime.stagger(100) 
        })
        .add({
            targets: '.hero-subtitle, .hero-cta',
            translateY: [30, 0],
            opacity: [0, 1],
            duration: 1000,
            delay: anime.stagger(200), 
            offset: '-=800'
        });
    }

    const scrollElements = document.querySelectorAll('.anim-scroll-fade');
    
    if (scrollElements.length > 0) {
        const elementInView = (el, dividend = 1) => {
            const elementTop = el.getBoundingClientRect().top;
            return (
                elementTop <= (window.innerHeight || document.documentElement.clientHeight) / dividend
            );
        };

        const displayScrollElement = (el) => {
            el.classList.add('is-visible');
        };

        const handleScrollAnimation = () => {
            scrollElements.forEach((el) => {
                if (elementInView(el, 1.25)) {
                    displayScrollElement(el);
                }
            });
        };

        handleScrollAnimation();
        window.addEventListener('scroll', handleScrollAnimation);
    }
    

    const pageTitles = document.querySelectorAll('.anim-judul');

    if (pageTitles.length > 0) {
        pageTitles.forEach(title => {
            const originalText = title.textContent;
            title.innerHTML = ''; 

            originalText.split('').forEach(char => {
                if (char === ' ') {
                    title.innerHTML += ' ';
                } else {
                    const span = document.createElement('span');
                    span.className = 'anim-judul-huruf'; 
                    span.textContent = char;
                    title.appendChild(span);
                }
            });


        const titleObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    anime({
                        targets: entry.target.querySelectorAll('.anim-judul-huruf'), 
                        translateY: ['1.1em', 0], 
                        opacity: [0, 1],
                        duration: 800,
                        easing: 'easeOutExpo',
                        delay: anime.stagger(50) 
                    });
                    titleObserver.unobserve(entry.target); 
                }
            });
        }, { threshold: 0.1 }); 

        titleObserver.observe(title);
    });
}

    const grid = document.querySelector('.wisata-grid'); // Kita awasi containernya

if (grid) {
    const gridObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {

                anime({
                    targets: '.wisata-grid .anim-card', 
                    translateY: [40, 0],
                    opacity: [0, 1],
                    duration: 800,
                    easing: 'easeOutExpo',
                    delay: anime.stagger(200) 
                });
                
                gridObserver.unobserve(entry.target); 
            }
        });
    }, { threshold: 0.1 }); 

    gridObserver.observe(grid); 
}

});

const masonryGrid = document.querySelector('.masonry-grid');

if (masonryGrid) {
    const masonryObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                anime({
                    targets: '.masonry-grid .masonry-item',
                    translateY: [40, 0],
                    opacity: [0, 1],
                    duration: 800,
                    easing: 'easeOutExpo',

                    delay: anime.stagger(100) 
                });
                
                masonryObserver.unobserve(entry.target); 
            }
        });
    }, { threshold: 0.1 }); 

    masonryObserver.observe(masonryGrid); 
}

const timelineItems = document.querySelectorAll('.anim-timeline-item');

if (timelineItems.length > 0) {
    const timelineObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const item = entry.target;
                
                const isOdd = Array.from(timelineItems).indexOf(item) % 2 === 0;
                
                anime({
                    targets: item,
                    translateX: isOdd ? [50, 0] : [-50, 0], 
                    opacity: [0, 1],
                    duration: 800,
                    easing: 'easeOutExpo'
                });
                
                timelineObserver.unobserve(item); 
            }
        });
    }, { threshold: 0.2 }); 

    timelineItems.forEach(item => {
        timelineObserver.observe(item); 
    });
}

const hamburgerBtn = document.getElementById('hamburger-btn');
const mobileMenu = document.getElementById('mobile-menu');
const body = document.querySelector('body');

if (hamburgerBtn && mobileMenu) {
    hamburgerBtn.addEventListener('click', () => {
        hamburgerBtn.classList.toggle('is-active');
        mobileMenu.classList.toggle('is-active');
        
        body.classList.toggle('body-loading'); 


        if (mobileMenu.classList.contains('is-active')) {
            anime({
                targets: '.mobile-nav-link',
                translateY: [20, 0],
                opacity: [0, 1],
                duration: 600,
                easing: 'easeOutExpo',
                delay: anime.stagger(100, {start: 300}) 
            });
        } else {
             anime({
                targets: '.mobile-nav-link',
                translateY: [0, 20],
                opacity: [1, 0],
                duration: 100, 
                easing: 'easeOutExpo'
            });
        }
    });
}

const scrollTopBtn = document.getElementById('scrollTopBtn');

if (scrollTopBtn) {
    const handleScrollBtn = () => {
        if (window.scrollY > 400) {
            scrollTopBtn.classList.add('is-visible');
        } else {
            scrollTopBtn.classList.remove('is-visible');
        }
    };

    const scrollToTop = (event) => {
        event.preventDefault(); 
        
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    };

    window.addEventListener('scroll', handleScrollBtn);
    scrollTopBtn.addEventListener('click', scrollToTop);
}
