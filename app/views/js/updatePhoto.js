document.getElementById('file_logo').addEventListener('input', function(event) {
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
        };
        
        reader.readAsDataURL(file);
    }
});