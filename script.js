document.addEventListener("DOMContentLoaded", () => {
  const bars = document.querySelectorAll(".grafik-batang");

  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add("animate");
      }
    });
  }, { threshold: 0.5 }); // start animation when 50% visible

  bars.forEach(bar => observer.observe(bar));
});

//test citra

