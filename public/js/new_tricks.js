$(document).ready(function() {
    // Get the ul that holds the collection of tags

    $('.add-item').on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();
        let $this = $(this);
        let type = $this.data('type');
        $collectionHolder = $('ul.' + type);
        
        // add a new tag form (see code block below)
        addTagForm($collectionHolder, $this);
    });
    
    $(document).on('click', '.remove-tag', function(e) {
        e.preventDefault();
        
        $(this).parent().remove();
        
        return false;
    });
    
});

function addTagForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $newLinkLi.data('prototype');
    
    // get the new index
    var index = $newLinkLi.data('index');
    
    // Replace '$$name$$' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);
    
    // increase the index with one for the next item
    $newLinkLi.data('index', index + 1);
    
    // Display the form in the page in an li, before the "Add a tag" link li
    $collectionHolder.append(newForm);
}