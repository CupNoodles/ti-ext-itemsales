$(document).ready(function(){
    
    // don't know how to remove the bulkActions checkboxes via config
    $('#lists table td:first-child').hide();
    $('#lists table .list-action:first-child').hide();

    $('.expand-menu-item').on('click', function(){

        ajaxRequest($(this).data('menu-id'));

        
    });


    function ajaxRequest(menu_id, $tr){

        // search filter 
        var search = $('.filter-search input').val();
        var location = $('select[name="list_filter[location]"] option:selected').val();
        var dates = [$('input[data-datepicker-range-start]').val(), $('input[data-datepicker-range-end]').val()];

        $.ajax({
            url: '/admin/cupnoodles/itemsales/itemsales/expand',
            type: 'POST',
            dataType: 'json',
            data: {
              menu_id: menu_id,
              search: search,
              location: location,
              dates: dates
            },
            success: function(data) {
                toggleExpanded(menu_id, data['#orders'])
                

            }
        });
    }

    function toggleExpanded(menu_id, $new_table){
        $chev = $('[data-menu-id="'+menu_id+'"] i');
        
        if($chev.hasClass('fa-chevron-right')){
            $chev.removeClass('fa-chevron-right');
            $chev.addClass('fa-chevron-down');


                $('<tr id="expanded-'+ menu_id +'" class="no-hover"><td colspan="7" style="padding-right: 0">' + $new_table + '</td></tr>').insertAfter($chev.closest('tr'));

                
        }
        else{
            $chev.removeClass('fa-chevron-down');
            $chev.addClass('fa-chevron-right');

            $('#expanded-' + menu_id).remove();
        }
    }



});