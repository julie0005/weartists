
let $grid= $('.container_works').imagesLoaded(function(){
    
    $grid.masonry({
        itemSelector: '.mason-item',
        fitwidth:true,
        gutter:5,
    });
});