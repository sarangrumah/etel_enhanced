var OptionValue_Kominfo = function() {


    //
    // Setup module components
    //

    // Select2 examples
    var _componentSelect2 = function() {
        //
        // Loading arrays of data
        //

        // Data
        var array_data = [
            {id: 0, text: 'enhancement'},
            {id: 1, text: 'bug'},
            {id: 2, text: 'duplicate'},
            {id: 3, text: 'invalid'},
            {id: 4, text: 'wontfix'}
        ];

        // Loading array data
        $('.select-data-array-kbli').select2({
            placeholder: 'Click to load data',
            minimumResultsForSearch: Infinity,
            data: array_data
        });


    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentSelect2();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    Select2Selects.init();
});