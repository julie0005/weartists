
let $grid= $('.container_works').imagesLoaded(function(){
    
    $grid.masonry({
        itemSelector: '.mason-item',
        fitWidth:true,
        gutter:5,
    });
});