<script>
  const sticky = document.querySelector('.sticky')

  if (sticky === null) {
    throw new Error('No sticky found');
  }

  const scrollspy = function() {
    sticky.style.display = (window.scrollY > 360) ? 'block' : 'none';
    const activeIndicator = document.querySelector('.scroll-indicator-controller .active span')

    if(activeIndicator) {
      sticky.querySelector('span.sticky-section').innerText = activeIndicator.innerText.trim();
    }
  }

  scrollspy();

  document.addEventListener('scroll', scrollspy)
</script>

