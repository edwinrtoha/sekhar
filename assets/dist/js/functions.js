function checkall(){
    var checkboxes = document.getElementsByName('checkbox');
    var button = document.getElementById('toggle');
    var label = document.getElementById('labelselect');

    if(button.value == 'Pilih Semua'){
        for (var i in checkboxes){
            checkboxes[i].checked = 'FALSE';
        }
        button.value = 'deselect';
        label.className='fa fa-check-square-o';
    }else{
        for (var i in checkboxes){
            checkboxes[i].checked = '';
        }
        button.value = 'Pilih Semua';
        label.className='fa fa-square-o';
    }
}