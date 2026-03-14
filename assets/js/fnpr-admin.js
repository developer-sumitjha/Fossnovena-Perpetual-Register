$ = jQuery;
$(document).ready(function(){

    // Edit entry function
    $('.fnpr-edit-entry').click(function(){
        var id = $(this).closest('tr').data('id');
        // console.log(id);

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'fnpr_edit_entry',
                id: id
            },
            success: function(response){
                // console.log(response);
                $('#fnpr-edit-entry-id').val(response.data.entry.id);
                $('#fnpr-edit-entryid').val(response.data.entry.entry_id);
                $('#fnpr-edit-entry-entry').val(response.data.entry.entry);
                $('#fnpr-edit-entry-life-stats').val(response.data.entry.life_stats);
                $('#fnpr-edit-entry-sort').val(response.data.entry.sort);
                $('.fnpr-modal').show();
            },
            error: function(error){
                console.log(error);
            }
        })
    });

    $('#cancel-entry').click(function(){
        $('.fnpr-modal').hide();
    });

    $('#save-entry').click(function(){
        var modalform = $(this).closest('.fnpr-modal').find('.fnpr-modal-form');
        var id = modalform.find('input[name="id"]').val();
        var entry_id = modalform.find('input[name="entry_id"]').val();
        var entry = modalform.find('input[name="entry"]').val();
        var life_stats = modalform.find('input[name="life_stats"]').val();
        var sort = modalform.find('input[name="sort"]').val();

        var data = {
            action: 'fnpr_save_entry',
            id: id,
            entry_id: entry_id,
            entry: entry,
            life_stats: life_stats,
            sort: sort,
            // nonce: 'save_entry_nonce'
        }
        // console.log(data);
        // console.log(id);
        // console.log(entry_id);
        // console.log(entry);
        // console.log(life_stats);
        // console.log(sort);

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: data,
            success: function(response){
               
                    // console.log(response.data.response , 'rows updated');
                    $('.fnpr-modal .notice').text('Entry Updated Successfully.');
                    $('.fnpr-modal .notice').removeClass('hide');
                    
                    setTimeout(function(){
                        $('.fnpr-modal .notice').addClass('hide');
                        $('.fnpr-modal').hide();
                    }, 2000)
                

            },
            error: function(error){
                console.log(error);
            }
        });
    });

    // Delete entry function
    $('.fnpr-delete-entry').click(function(){
        var id = $(this).closest('tr').data('id');
        console.log('Id:', id);

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'fnpr_delete_entry',
                id: id
            },
            success: function(response){
                // console.log('Delete Response', response);
                alert('Entry Deleted Successfully.');
            },
            error: function(error){
                console.log(error);
            }
        })
    });
});

