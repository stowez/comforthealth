/**
 * PhotoSwipe Gallery Initialization
 * Initializes PhotoSwipe lightbox on all .pswp-gallery elements
 */

document.addEventListener('DOMContentLoaded', function() {
  // Use dynamic imports to load PhotoSwipe modules
  Promise.all([
    import('https://cdn.jsdelivr.net/npm/photoswipe@5.4.4/dist/photoswipe.esm.js'),
    import('https://cdn.jsdelivr.net/npm/photoswipe@5.4.4/dist/photoswipe-lightbox.esm.js'),
    import('https://unpkg.com/photoswipe-dynamic-caption-plugin@1.2.7/photoswipe-dynamic-caption-plugin.esm.js')
  ]).then(([PhotoSwipeModule, PhotoSwipeLightboxModule, PhotoSwipeDynamicCaptionModule]) => {
    const PhotoSwipeLightbox = PhotoSwipeLightboxModule.default;
    const PhotoSwipeDynamicCaption = PhotoSwipeDynamicCaptionModule.default;

    // Initialize PhotoSwipe lightbox for all galleries
    const lightbox = new PhotoSwipeLightbox({
      gallery: '.pswp-gallery',
      children: 'a',
      pswpModule: () => import('https://cdn.jsdelivr.net/npm/photoswipe@5.4.4/dist/photoswipe.esm.js')
    });

    // Initialize Dynamic Caption Plugin
    const captionPlugin = new PhotoSwipeDynamicCaption(lightbox, {
      type: 'below',
      captionContent: '.pswp-caption-content'
    });

    lightbox.init();

    // Extract and display captions from the gallery item
    lightbox.on('contentActivate', function(e) {
      const { content } = e;
      if (content && content.src) {
        // Find the corresponding gallery item link
        const galleryElement = document.querySelector('.pswp-gallery');
        if (galleryElement) {
          const link = galleryElement.querySelector(`a[href="${content.src}"]`);
          if (link) {
            const captionDiv = link.querySelector('.gallery-item__caption');
            if (captionDiv) {
              content.data.caption = captionDiv.textContent.trim();
            }
          }
        }
      }
    });
  }).catch(error => {
    console.error('Error loading PhotoSwipe modules:', error);
  });
});

