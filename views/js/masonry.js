
let $grid= $('.container_works').imagesLoaded(function(){
    
    $grid.masonry({
        columnWidth: '.mason-item',
        itemSelector: '.mason-item',
        percentPosition:true,
        gutter:5,
    });
});
