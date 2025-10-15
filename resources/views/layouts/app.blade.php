<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <title>WordPress Integration</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/functions.css') }}" rel="stylesheet">
    <link href="{{ asset('css/wordpress-info.css') }}" rel="stylesheet">
    <style>
        body { font-family: 'Roboto', Arial, sans-serif; background: #f8f8f8; margin: 0; padding: 0; }
        .container { max-width: 1200px; margin: 0 auto; padding: 2rem; }
    </style>
    @yield('head')
</head>
<body style="background: #e9ecedff; margin: 0; padding: 0;">
    <div class="container">
        @yield('content')
    </div>

    <script>
        // Custom file upload styling and feedback
        document.addEventListener('DOMContentLoaded', function() {
            // Single file upload (upload-images page)
            const mediaInput = document.getElementById('media');
            if (mediaInput) {
                mediaInput.addEventListener('change', function() {
                    const label = document.getElementById('file-label');
                    const fileName = document.getElementById('file-name');
                    
                    if (this.files.length > 0) {
                        label.textContent = '✅ Billede valgt';
                        label.classList.add('has-file');
                        fileName.textContent = 'Valgt: ' + this.files[0].name;
                    } else {
                        label.textContent = '📁 Vælg billede fra computer';
                        label.classList.remove('has-file');
                        fileName.textContent = '';
                    }
                });
            }

            // Multiple files upload (create-page)
            const imagesInput = document.getElementById('images');
            if (imagesInput) {
                imagesInput.addEventListener('change', function() {
                    const label = document.getElementById('images-label');
                    const fileName = document.getElementById('images-name');
                    
                    if (this.files.length > 0) {
                        label.textContent = '✅ ' + this.files.length + ' billede(r) valgt';
                        label.classList.add('has-file');
                        
                        const fileNames = Array.from(this.files).map(file => file.name).join(', ');
                        fileName.textContent = 'Valgt: ' + fileNames;
                    } else {
                        label.textContent = '🖼️ Vælg billeder (flere ad gangen)';
                        label.classList.remove('has-file');
                        fileName.textContent = '';
                    }
                });
            }
        });

        // Custom Select Dropdown
        document.addEventListener('DOMContentLoaded', function() {
            console.log('JavaScript loaded');
            const customSelect = document.getElementById('image-position-select');
            console.log('Custom select element:', customSelect);
            
            if (customSelect) {
                const selectSelected = customSelect.querySelector('.select-selected');
                const selectItems = customSelect.querySelector('.select-items');
                const hiddenSelect = customSelect.querySelector('select');
                const options = selectItems.querySelectorAll('div[data-value]');

                console.log('Elements found:', {selectSelected, selectItems, hiddenSelect, options});

                // Toggle dropdown
                selectSelected.addEventListener('click', function(e) {
                    console.log('Dropdown clicked');
                    e.stopPropagation();
                    selectItems.style.display = selectItems.style.display === 'block' ? 'none' : 'block';
                });

                // Handle option selection
                options.forEach(function(option) {
                    option.addEventListener('click', function(e) {
                        console.log('Option clicked:', this.textContent);
                        const value = this.getAttribute('data-value');
                        const text = this.textContent;

                        // Update display
                        selectSelected.textContent = text;
                        
                        // Update hidden select
                        hiddenSelect.value = value;
                        
                        // Close dropdown
                        selectItems.style.display = 'none';
                    });
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function() {
                    selectItems.style.display = 'none';
                });
            }
        });
    </script>
</body>
</html>