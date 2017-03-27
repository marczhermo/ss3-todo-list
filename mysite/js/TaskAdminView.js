(function($){
    $.entwine("ss", function($) {

        $(".task-grid-dialog").entwine({
            loadDialog: function(deferred) {
                var dialog = this.addClass("loading").children(".ui-dialog-content").empty();

                deferred.done(function(data) {
                    var formInputs = $('input, select, button', $(data)).map(function(index, item){
                        return $(item);
                    });
                    var form = $('<form method="post" enctype="application/x-www-form-urlencoded"></form>');
                    var formOriginal = $(data).empty();
                    $(formInputs).each(function(){
                        form.append($(this));
                    });
                    $(form).attr('action', $(formOriginal).attr('action'));
                    dialog.append(form).parent().removeClass("loading");
                });
            }
        });

        $(".task-grid-dialog [name='action_doSave']").entwine({
            onclick: function() {
                var form = $(this).closest('form');
                var data = $(form).serialize();
                var self = this;

                var dialog = this.closest(".task-grid-dialog")
                    .addClass("loading")
                    .children(".ui-dialog-content")
                    .empty();

                $.ajax({
                  // headers: {"X-Pjax" : 'CurrentForm,Breadcrumbs'},
                  type: "POST",
                  url: $(form).attr('action'),
                  data: data,
                  success: function(response){
                    dialog.dialog("close");
                    $(".ss-gridfield").reload();
                  }
                });

                return false;
            }
        });

        $(".ss-gridfield .task-grid-button").entwine({
            onclick: function() {
                var editLink = $(this).parent().find('.action.edit-link').first();
                var dialog = $("<div></div>").appendTo("body").dialog({
                    modal: true,
                    resizable: true,
                    width: 600,
                    height: 300,
                    close: function() {
                        $(this).dialog("destroy").remove();
                    }
                });

                dialog.parent().addClass("task-grid-dialog").loadDialog(
                    $.get($(editLink).attr('href'))
                );
                dialog.data("grid", this.closest(".ss-gridfield"));

                return false;
            }
        });

    });
})(jQuery);
