cmcl.changePage = function(page) {
    $('#pages').children().addClass('hidden');
    page.removeClass('hidden');
};


cmcl.incrementLoading = function() {
    cmcl.loadingcycles++;
    cmcl.updateLoading();
};


cmcl.decrementLoading = function() {
    cmcl.loadingcycles--;
    cmcl.updateLoading();
};


cmcl.updateLoading = function() {
    if(cmcl.loadingcycles > 0) {
        $("#loadmask").mask();
        $('#loadmask').show();
    } else {
        $("#loadmask").unmask();
        $('#loadmask').hide();
    }
};
