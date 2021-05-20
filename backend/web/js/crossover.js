function crossover(Data) {
///////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////CROSSOVER FUNCTIONALITY///////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
    var Data = [];

    populateItems(Data, '#items');

    //add btn
    $('#crossover-btn-add').click(function() {
        var selected = $('select#items').val();
        var selectedname = $('select#bayangan').text();
        var ks = selectedname.split("\n");
        $('#items option:selected').remove();
        generateOptionElements(selected, '#selected' ,ks);
    });
    
    //remove btn
    $('#crossover-btn-remove').click(function() {
        var selected = $('select#selected').val();
        var selectedname = $('select#bayangan').text();
        var ks = selectedname.split("\n");
        $('#selected option:selected').remove();
        $('#items option').each(function() {
            selected.push($(this).val());
        });
    
        $('#items option').remove();
        selected.sort();
        generateOptionElements(selected, '#items',ks);
    });

    //populate items box with arr
    function populateItems(arr, targetMultiSelect) {
        arr.sort();
        generateOptionElements(arr, targetMultiSelect);
    }
    
    //temporarily add a new item to the crossover
    $('#add-new-item-btn').click(function() {
        if ($('#new-item-input').val() !== '') {
            var selected = [];
            selected.push($('#new-item-input').val().trim());
    
            $('#selected option').each(function() {
                selected.push($(this).val()); 
            });
    
            selected.sort();
            $('#selected').empty();
    
            generateOptionElements(selected, '#selected');
    
            $('#new-item-input').val('');
        }
    });
    
    //reset demo
    $('#reset-btn').click(function() {
        $('#items').empty();
        $('#selected').empty();
        populateItems(Data, '#items');
    });
    
    
///////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////MINI FUNCTIONS TO AVOID REPEAT CODE///////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
        
//create option elements
function generateOptionElements(arr, targetMultiSelect, selectedname='') {
    var filtered = [];
    $.each(selectedname, function( index, value ) {
        if (value!='') {
            filtered.push(value);
        }
    });
    console.log(filtered)
    for (var i = 0; i < arr.length; i++) {
        var option = document.createElement('OPTION');
        option.value = arr[i];
        option.text = filtered[arr[i]-1];
        $(targetMultiSelect).append(option);
    }
}
};