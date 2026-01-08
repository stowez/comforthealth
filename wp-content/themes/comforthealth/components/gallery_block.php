<?php
// Gallery Block
$images = get_sub_field('image_gallery');

if( $images ): ?>
    <div class="gallery-grid grid">
        <?php foreach( $images as $image ): ?>
            <div class="grid__item" data-size="1280x853">
                <a href="<?php echo $image['url']; ?>" class="img-wrap">
                     <img src="<?php echo $image['sizes']['medium']; ?>" alt="<?php echo $image['alt']; ?>"  class="gallery-grid-image"/>
                     <div class="description description--grid"><?php echo $image['caption']; ?></div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
 <!-- /grid -->
    <div class="preview">
        <button class="action action--close"><i class="fa fa-times"></i><span class="text-hidden">Close</span></button>
        <button class="action action--next"><i class="fa fa-chevron-right"></i><span class="text-hidden">Next</span></button>
        <button class="action action--prev"><i class="fa fa-chevron-left"></i><span class="text-hidden">Previous</span></button>
        <div class="description description--preview"></div>
    </div>

    <script src="<?= bloginfo('template_url');?>/js/modernizr-custom.js"></script>
    <script src="<?= bloginfo('template_url');?>/js/imagesloaded.pkgd.min.js"></script>
    <script src="<?= bloginfo('template_url');?>/js/masonry.pkgd.min.js"></script>
    <script src="<?= bloginfo('template_url');?>/js/classie.js"></script>
    <script src="<?= bloginfo('template_url');?>/js/main.js"></script>
    <script>
        (function() {
            // create SVG circle overlay and append it to the preview element
            function createCircleOverlay(previewEl) {
                var dummy = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
                dummy.setAttributeNS(null, 'version', '1.1');
                dummy.setAttributeNS(null, 'width', '100%');
                dummy.setAttributeNS(null, 'height', '100%');
                dummy.setAttributeNS(null, 'class', 'overlay');
                var g = document.createElementNS('http://www.w3.org/2000/svg', 'g');
                var circle = document.createElementNS("http://www.w3.org/2000/svg", "circle");
                circle.setAttributeNS(null, 'cx', 0);
                circle.setAttributeNS(null, 'cy', 0);
                circle.setAttributeNS(null, 'r', Math.sqrt(Math.pow(previewEl.offsetWidth,2) + Math.pow(previewEl.offsetHeight,2)));
                dummy.appendChild(g);
                g.appendChild(circle);
                previewEl.appendChild(dummy);
            }
            
            new GridFx(document.querySelector('.grid'), {
                onInit : function(instance) {
                    createCircleOverlay(instance.previewEl);
                },
                onResize : function(instance) {
                    instance.previewEl.querySelector('svg circle').setAttributeNS(null, 'r', Math.sqrt(Math.pow(instance.previewEl.offsetWidth,2) + Math.pow(instance.previewEl.offsetHeight,2)));
                },
                onOpenItem : function(instance, item) {
                    // item's image
                    var gridImg = item.querySelector('img'),
                        gridImgOffset = gridImg.getBoundingClientRect(),
                        win = {width: document.documentElement.clientWidth, height: window.innerHeight},
                        SVGCircleGroupEl = instance.previewEl.querySelector('svg > g'),
                        SVGCircleEl = SVGCircleGroupEl.querySelector('circle');
                        
                    SVGCircleEl.setAttributeNS(null, 'r', Math.sqrt(Math.pow(instance.previewEl.offsetWidth,2) + Math.pow(instance.previewEl.offsetHeight,2)));
                    // set the transform for the SVG g node. This will animate the circle overlay. The origin of the circle depends on the position of the clicked item.
                    if( gridImgOffset.left + gridImg.offsetWidth/2 < win.width/2 ) {
                        SVGCircleGroupEl.setAttributeNS(null, 'transform', 'translate(' + win.width + ', ' + (gridImgOffset.top + gridImg.offsetHeight/2 < win.height/2 ? win.height : 0) + ')');
                    }
                    else {
                        SVGCircleGroupEl.setAttributeNS(null, 'transform', 'translate(0, ' + (gridImgOffset.top + gridImg.offsetHeight/2 < win.height/2 ? win.height : 0) + ')');
                    }
                }
            });
        })();
    </script>