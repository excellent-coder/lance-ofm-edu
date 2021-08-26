const config = {
  rootMargin: '0px 0px 50px 0px',
  threshold: 0
};
var prevScrollpos = window.pageYOffset;

let observer = new IntersectionObserver(function (entries, self) {
    entries.forEach(entry => {
        if(entry.isIntersecting) {
            scrollIn(entry.target);
            self.unobserve(entry.target);
        }
    });
}, config);

function scrollIn(el) {
    if (el.dataset.src) {
        el.src = element.dataset.src;
    }
    el.classList.add('scroll-in');
}

document.querySelectorAll('[data-src]').forEach(img => {
    observer.observe(img);
});

document.querySelectorAll('.animate-on-scroll').forEach(el => {
    observer.observe(el);
});
