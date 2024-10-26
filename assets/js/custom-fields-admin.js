var selectButton = document.getElementById('add_field');


selectButton.addEventListener('click', function() {
    
    const fieldType = document.getElementById('field_type').value;
    const fieldName = document.getElementById('field_name').value;
    const fieldLabel = document.getElementById('field_label').value;
    const fieldOptions = document.getElementById('field_options').value;

  
    if (!fieldType || !fieldName || !fieldLabel) {
        alert('Please fill in all required fields.');
        return; 
    console.log('Field Type:', fieldType);
    console.log('Field Name:', fieldName);
    console.log('Field Label:', fieldLabel);
    console.log('Field Options:', fieldOptions);

    

});



